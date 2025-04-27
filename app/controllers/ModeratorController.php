<?php
class ModeratorController extends Controller {
    private $notificationModel;
    private $notification;
    private $ModeratorModel;
    private $userModel;

    public function __construct() {
        if (!$this->isloggedin()) {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            Redirect('LandingController/login');
        }
        $this->notificationModel = $this->model('M_pages');
        $this->notification = $this->model('Notification');
        $this->ModeratorModel = $this->model('Moderator');
        $this->userModel = $this->model('Users');

    }

    public function isloggedin() {
        return isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'moderator';
    }

    public function dashboard() {
        $allRequests = $this->notificationModel->getHelpRequests();
        $data = [
            'total_requests' => count($allRequests),
            'pending_requests' => count(array_filter($allRequests, fn($r) => $r->status === 'pending')),
            'in_progress_requests' => count(array_filter($allRequests, fn($r) => $r->status === 'in_progress')),
            'responded_requests' => count(array_filter($allRequests, fn($r) => $r->status === 'responded')),
            'resolved_requests' => count(array_filter($allRequests, fn($r) => $r->status === 'resolved')),
            'closed_requests' => count(array_filter($allRequests, fn($r) => $r->status === 'closed')),
            'categories' => $this->getCategoryPendingCounts($allRequests),
            'recent_requests' => array_slice(array_filter($allRequests, fn($r) => $r->status === 'pending'), 0, 5)
        ];
        $this->view('Moderator/dashboard', $data);
    }

    public function Help() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply'])) {
            $_POST = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
            $requestId = htmlspecialchars(trim($_POST['request_id']));
            $reply = htmlspecialchars(trim($_POST['reply']));
            $moderatorId = $_SESSION['user_id'];
    
            // Validate inputs
            if (!is_numeric($requestId)) {
                $_SESSION['reply_error'] = 'Invalid request ID.';
                Redirect('ModeratorController/Help');
            }
            if (empty($reply)) {
                $_SESSION['reply_error'] = 'Please enter a reply.';
                $category = $this->notificationModel->getRequestById($requestId)->category ?? '';
                Redirect('ModeratorController/Help?category=' . urlencode($category));
            }
    
            // Check if request_id exists
            $request = $this->notificationModel->getRequestById($requestId);
            if (!$request) {
                error_log("Invalid help request ID: $requestId");
                $_SESSION['reply_error'] = 'Help request not found.';
                Redirect('ModeratorController/Help');
            }
    
            $this->handleReply($requestId, $moderatorId, $reply);
        }
    
        $data = [];
        $allRequests = $this->notificationModel->getHelpRequests();
        $data['categories'] = $this->getCategoryPendingCounts($allRequests);
    
        if (isset($_GET['category'])) {
            $category = htmlspecialchars($_GET['category']);
            $data['selected_category'] = $category;
            $requests = $this->notificationModel->getRequestsByCategory($category);
            // Add file type to each request
            foreach ($requests as $request) {
                if (!empty($request->attachment) && file_exists($request->attachment)) {
                    $request->file_type = function_exists('mime_content_type')
                        ? mime_content_type($request->attachment)
                        : $this->getMimeTypeFromExtension($request->attachment);
                } else {
                    $request->file_type = null;
                }
            }
            $data['requests'] = $requests;
        }
    
        $this->view('Moderator/Help', $data);
    }
    
    // Helper method to get MIME type from file extension
    private function getMimeTypeFromExtension($filePath) {
        $extension = strtolower(pathinfo($filePath, PATHINFO_EXTENSION));
        $extensionToMime = [
            'jpg' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'png' => 'image/png',
            'pdf' => 'application/pdf'
        ];
        return $extensionToMime[$extension] ?? 'application/octet-stream';
    }



    private function getCategoryPendingCounts($requests) {
        $categories = [];
        foreach ($requests as $request) {
            if (!isset($categories[$request->category])) {
                $categories[$request->category] = 0;
            }
            if ($request->status === 'pending') {
                $categories[$request->category]++;
            }
        }
        return $categories;
    }



    private function handleReply($requestId, $moderatorId, $reply) {
        try {
            // Add reply
            if (!$this->notificationModel->addReply($requestId, $moderatorId, $reply)) {
                error_log("Failed to add reply for request_id $requestId by moderator $moderatorId");
                $_SESSION['reply_error'] = 'Failed to send reply.';
                $category = $this->notificationModel->getRequestById($requestId)->category ?? '';
                Redirect('ModeratorController/Help?category=' . urlencode($category));
            }
    
            // Update request status
            if (!$this->notificationModel->updateRequestStatus($requestId, $moderatorId, 'responded')) {
                error_log("Failed to update status for request_id $requestId by moderator $moderatorId");
                $_SESSION['reply_error'] = 'Failed to update request status.';
                $category = $this->notificationModel->getRequestById($requestId)->category ?? '';
                Redirect('ModeratorController/Help?category=' . urlencode($category));
            }
    
            // Send notification to the user
            $user = $this->notificationModel->getUserByRequestId($requestId);
            if ($user && $user->user_id && $user->user_role) {
                if (!$this->notification->createHelpRequestNotification($user->user_id, $user->user_role, $requestId)) {
                    error_log("Failed to send notification for user_id {$user->user_id}, request_id $requestId");
                }
            } else {
                error_log("Invalid user data for request_id $requestId");
            }
    
            $_SESSION['reply_success'] = 'Reply sent successfully!';
        } catch (Exception $e) {
            error_log("Error in handleReply for request_id $requestId: " . $e->getMessage());
            $_SESSION['reply_error'] = 'An unexpected error occurred.';
        }
    
        $category = $this->notificationModel->getRequestById($requestId)->category ?? '';
        Redirect('ModeratorController/Help?category=' . urlencode($category));
    }


    public function serveAttachment($requestId) {
        if (!is_numeric($requestId)) {
            $_SESSION['reply_error'] = 'Invalid request ID.';
            Redirect('ModeratorController/Help');
        }
    
        if (!$this->isloggedin()) {
            $_SESSION['reply_error'] = 'Unauthorized access.';
            Redirect('ModeratorController/Help');
        }
    
        $request = $this->notificationModel->getRequestById($requestId);
        if (!$request || empty($request->attachment) || !file_exists($request->attachment)) {
            error_log("Failed to serve attachment for request_id $requestId: File not found");
            $_SESSION['reply_error'] = 'File not found.';
            Redirect('ModeratorController/Help');
        }
    
        $filePath = $request->attachment;
        $fileType = $this->getMimeTypeFromExtension($filePath); // Use extension-based MIME type
        $fileName = basename($filePath);
    
        switch ($fileType) {
            case 'image/jpeg':
            case 'image/png':
                header('Content-Type: ' . $fileType);
                header('Content-Disposition: inline; filename="' . $fileName . '"');
                break;
            case 'application/pdf':
                header('Content-Type: application/pdf');
                header('Content-Disposition: inline; filename="' . $fileName . '"');
                break;
            default:
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename="' . $fileName . '"');
        }
    
        header('Content-Length: ' . filesize($filePath));
        readfile($filePath);
        exit;
    }


    public function submitReply() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'request_id' => trim($_POST['request_id']),
                'moderator_id' => $_SESSION['user_id'],
                'reply' => trim($_POST['reply']),
                'status' => trim($_POST['status'] ?? 'in_progress')
            ];

            if (!is_numeric($data['request_id'])) {
                error_log("Invalid request_id {$data['request_id']} in submitReply");
                $_SESSION['reply_error'] = 'Invalid request ID.';
                Redirect('ModeratorController/Help');
            }

            if (empty($data['reply'])) {
                $_SESSION['reply_error'] = 'Please enter a reply.';
                Redirect('ModeratorController/Help/' . $data['request_id']);
            }

            if ($this->notificationModel->addReply($data['request_id'], $data['moderator_id'], $data['reply'])) {
                $_SESSION['reply_success'] = 'Reply submitted successfully!';
                Redirect('ModeratorController/Help');
            } else {
                error_log("Failed to submit reply for request_id {$data['request_id']} in submitReply");
                $_SESSION['reply_error'] = 'Failed to submit reply. Please try again.';
                Redirect('ModeratorController/Help/' . $data['request_id']);
            }
        }
    }
    
    public function ManageProfile() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'user_id' => $_SESSION['user_id'],
                'name' => trim($_POST['name']),
                'phone' => trim($_POST['phone']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'name_err' => '',
                'phone_err' => '',
                'address_err' => '',
                'email_err' => ''
            ];

            if (empty($data['name'])) {
                $data['name_err'] = 'Please input a name';
            }
            if (empty($data['phone'])) {
                $data['contact_err'] = 'Please input a contact number';
            }
            if (empty($data['email'])) {
                $data['email_err'] = 'Please input an email';
            }

            if (empty($data['name_err']) && empty($data['phone_err']) && empty($data['email_err'])) {
                echo 'Profile Updated';
                if (!empty($data['password'])) {
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                }
                $result = $this->ModeratorModel->UpdateProfile($data);
                if ($result) {
                    Redirect('ModeratorController/ManageProfile');
                }
            } else {
                $this->view('Moderator/ManageProfile', $data);
            }
        } else {
            $user = $this->ModeratorModel->getUserById($_SESSION['user_id']);
            $_SESSION['user_name'] = $user->name;
            $_SESSION['user_email'] = $user->email;
            $data = [
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'password' => '',
                'name_err' => '',
                'phone_err' => '',
                'email_err' => '',
                'password_err' => ''
            ];
            $this->view('Moderator/ManageProfile', $data);
        }
    }

    public function getProfileImage($user_id) {
        $imagePath = $this->ModeratorModel->getProfileImage($_SESSION['user_id']);
        return $imagePath ? URLROOT . '/' . $imagePath : URLROOT . '/images/default.jpg';
    }

    public function uploadProfileImage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
            $targetDir = "uploads/ProfilePictures/";
            $fileName = basename($_FILES["profile_picture"]["name"]);
            $targetFile = $targetDir . $fileName;
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
                $uploadResult = $this->ModeratorModel->updateProfileImage($_SESSION['user_id'], $targetFile);
                Redirect('ModeratorController/ManageProfile');
            } else {
                echo "Error uploading file.";
            }
        }
    }

    public function AccountLog() {
        $this->view('Moderator/AccountLog');
    }

    public function getAccountLog() {
       $logs = $this->ModeratorModel->getAccountLog();
       
       echo json_encode($logs);
        
    }

    
    public function BuyerOrderLog() {
        $this->view('Moderator/BuyerOrderLog');
    }

    public function getBuyerOrderLog() {
       $logs = $this->ModeratorModel->getBuyerOrderLog();
       
       echo json_encode($logs);
        
    }

    public function BuyerTransactionLog() {
        $this->view('Moderator/BuyerTransactionLog');
    }

    public function getBuyerTransactionLog() {
       $logs = $this->ModeratorModel->getBuyerTransactionLog();
       
       echo json_encode($logs);
        
    }

    public function FarmerOrderLog() {
        $this->view('Moderator/FarmerOrderLog');
    }

    public function getFarmerOrderLog() {
       $logs = $this->ModeratorModel->getFarmerOrderLog();
       
       echo json_encode($logs);
        
    }

    public function FarmerTransactionLog() {
        $this->view('Moderator/FarmerTransactionLog');
    }

    public function getFarmerTransactionLog() {
       $logs = $this->ModeratorModel->getFarmerTransactionLog();     
       echo json_encode($logs);
        
    }

    public function ReportToAdmin(){
      
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data = [
                'user_id' => trim($_POST['user_id']),
                'moderator_comments' =>trim($_POST['moderator_comments']),
                'moderator_id'=> $_SESSION['user_id']
            ];
     

            if (!empty($data['user_id']) && !empty($data['moderator_comments'])) {
                $result = $this->ModeratorModel->ReportToAdmin($data);
                if ($result) {
                    $data= 
                    ['report_success'=>"Report submitted successfully!" ];

                    $this->view('Moderator/ReportToAdmin', $data);
                } else {
                    echo 'Failed to report to admin';
                }
            } else {
                $this->view('Moderator/ReportToAdmin', $data);
            }

           
        }else{
            $data = [
                'user_id' => '',
                'moderator_comments' => ''
                
            ];

            $this->view('Moderator/ReportToAdmin', $data);
        }
    }

    public function Ratings(){

        // Fetch ratings from the model
        $ratings = $this->userModel->getRatings();
        
        $rating_merged = array_merge($ratings['farmer_reviews_worker'], $ratings['buyer_reviews_farmer']);
        // Pass the ratings data to the view
        $data = ['ratings' => $rating_merged];

        $this->View('Moderator/Ratings',$data);
    }

    public function ApproveWorkerReview($id){
        if($this->userModel->ApproveWorkerReview($id)){
            Redirect('ModeratorController/Ratings');
        }else{
            die('Something went wrong');
        }
    }
   
    public function ApproveProductReview($id){
        if($this->userModel->ApproveProductReview($id)){
            Redirect('ModeratorController/Ratings');
        }else{
            die('Something went wrong');
        }
    }

    public function RejectWorkerReview($id){
        if($this->userModel->RejectWorkerReview($id)){
            Redirect('ModeratorController/Ratings');
        }else{
            die('Something went wrong');
        }
    }

    public function RejectProductReview($id){
        if($this->userModel->RejectProductReview($id)){
            Redirect('ModeratorController/Ratings');
        }else{
            die('Something went wrong');
        }
    }
}

?>