<?php
class WorkerController extends Controller {
    private $WorkerModel;
    private $NotificationModel;

    public function __construct() {  

        $currentMethod = $this->getCurrentMethodFromURL();

        if (!$this->isloggedin()) {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            Redirect('LandingController/login');
        } else{
            $this->WorkerModel = $this->model('Worker');
            $this->NotificationModel = $this->model('Notification');

             // User is logged in, now check if they are restricted
             $user_id = $_SESSION['user_id'];
             $user = $this->WorkerModel->getUserStatus($user_id);  // Fetch user status from the database
            
 
             // If the user is restricted, prevent access to any page except "Manage Profile"
             if ($user->user_status === 'restricted') {
                 if ($currentMethod !== 'ManageProfile' && $currentMethod !== 'Resetricted') {
                     Redirect('WorkerController/Resetricted/' . $user_id);
                 }
             }
        }
       
    }

    public function isloggedin() {
        return isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'farmworker';
    }

    private function getCurrentMethodFromURL() {
        // Parse the URL
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            // The second segment of the URL is the method name
            return $url[1] ?? null;
        }
        return null;
    }

    public function Resetricted($user_id){
        $data = $this->WorkerModel->getrestrictedDetails($user_id);
        $this->View('inc/Restricted', $data);
    }

    public function Dashboard() {
        $active_job = $this->WorkerModel->getActiveJob($_SESSION['user_id']);
        $completed_jobs = $this->WorkerModel->getCompletedJobs($_SESSION['user_id']);
        $pending_jobs = $this->WorkerModel->getPendingJobs($_SESSION['user_id']);
        $overall_rating = $this->WorkerModel->getOverallRating($_SESSION['user_id']);
        $recent_tasks = $this->WorkerModel->getRecentTasks($_SESSION['user_id']);
        

        $data = [
            'user_name' => $_SESSION['user_name'],
            'active_job' => $active_job,
            'completed_jobs' => $completed_jobs,
            'pending_jobs' => $pending_jobs,
            'overall_rating' => $overall_rating,
            'recent_tasks' => $recent_tasks
        ];
      
        $this->view('FarmWorker/Dashboard', $data);
    }

    public function ManageProfile() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'user_id' => $_SESSION['user_id'],
                'name' => trim($_POST['name']),
                'phone' => trim($_POST['phone']),
                'email' => trim($_POST['email']),
                'bio' => trim($_POST['bio']),
                'password' => trim($_POST['password']),
                'hourly_rate' => trim($_POST['hourly_rate']),
                'working_area' => trim($_POST['working_area']),
                'availability' => trim($_POST['availability']),
                'skills' => $_POST['skills'],
                'bio_err' => '',
                'name_err' => '',
                'phone_err' => '',
                'address_err' => '',
                'email_err' => '',
                'bio_err' => '',
                'hourly_rate_err' => '',
                'working_area_err' => '',
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
            if (empty($data['bio'])) {
                $data['bio_err'] = 'Please input a bio';
            }

            if (empty($data['name_err']) && empty($data['phone_err']) && empty($data['email_err']) && empty($data['bio_err'])) {
                if (!empty($data['password'])) {
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                }
                $result = $this->WorkerModel->UpdateProfile($data);
                if ($result) {
                    Redirect('WorkerController/ManageProfile');
                }
            }
            $this->view('FarmWorker/ManageProfile', $data);
        } else {
            $user = $this->WorkerModel->getUserById($_SESSION['user_id']);
            $data = [
                'name' => $user->name,
                'phone' => $user->phone,
                'email' => $user->email,
                'bio' => $user->bio,
                'hourly_rate' => $user->hourly_rate,
                'working_area' => $user->working_area,
                'availability' => $user->availability,
                'skills' => $user->skills,
                'password' => '',
                'name_err' => '',
                'phone_err' => '',
                'email_err' => '',
                'password_err' => '',
                'hourly_rate_err' => '',
                'bio_err' => '',
                'working_area_err' => '',
                'availability_err' => '',
                'skills_err' => '',
            ];
            $this->view('FarmWorker/ManageProfile', $data);
        }
    }

    public function getProfileImage($user_id) {
        $imagePath = $this->WorkerModel->getProfileImage($_SESSION['user_id']);
        return $imagePath ? URLROOT . '/' . $imagePath : URLROOT . '/images/default.jpg';
    }

    public function uploadProfileImage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
            $targetDir = "Uploads/ProfilePictures/";
            $fileName = basename($_FILES["profile_picture"]["name"]);
            $targetFile = $targetDir . $fileName;
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
                $uploadResult = $this->WorkerModel->updateProfileImage($_SESSION['user_id'], $targetFile);
                Redirect('WorkerController/ManageProfile');
            } else {
                echo "Error uploading file.";
            }
        }
    }

    public function save() {
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ];
        $this->WorkerModel->addWorker($data);
        $this->view('FarmWorker/Worker Management');
    }

    public function edit($id) {
        $worker = $this->WorkerModel->getWorker($id);
        $this->view('FarmWorker/Edit Worker', ['worker' => $worker]);
    }

    public function update($id) {
        $worker = $this->WorkerModel->getWorker($id);
        $this->view('FarmWorker/Edit Worker', ['worker' => $worker]);
    }

    public function delete($id) {
        $this->WorkerModel->deleteWorker($id);
        $this->view('FarmWorker/Worker Management');
    }  

    public function jobDescription() {
        $this->view('FarmWorker/JobDescription');
    }

    public function jobRequest() {
        $data['jobRequests'] = $this->WorkerModel->getJobRequests($_SESSION['user_id']);
        $this->view('FarmWorker/JobRequest', $data);
    }

    public function ViewRequest($job_id) {
        $requests = $this->WorkerModel->ViewRequest($job_id);
        $data = $requests[0];
        $this->view('FarmWorker/ViewRequest', $data);
    }

    public function trainingSelection() {
        $this->view('FarmWorker/TrainingSelection');
    }

    public function AcceptJob($job_id) {
        $Result = $this->WorkerModel->AcceptJob($job_id);
        if ($Result) {
            Redirect('WorkerController/JobRequest');
        }
    }

    public function RejectJob($job_id) {
        $Result = $this->WorkerModel->RejectJob($job_id);
        if ($Result) {
            Redirect('WorkerController/JobRequest');
        }
    }

    public function DoList() {
        $data['jobRequests'] = $this->WorkerModel->DoList($_SESSION['user_id']);
        $this->view('FarmWorker/DoList', $data);
    }

    public function ViewAcceptedJob($job_id) {
        $requests = $this->WorkerModel->ViewRequest($job_id);
        $data = $requests[0];
        $this->view('FarmWorker/ViewAcceptedJob', $data);
    }

    public function getAcceptedJobCount() {
        $count = $this->WorkerModel->getAcceptedJobCount($_SESSION['user_id']);
        return $count;
    }

    public function getPendingJobCount() {
        $count = $this->WorkerModel->getPendingJobCount($_SESSION['user_id']);
        return $count;
    }

    public function RequestHelp() {
        $data = [
            'requests' => $this->NotificationModel->getHelpRequestsWithResponses($_SESSION['user_id'])
        ];
        $this->view('FarmWorker/RequestHelp', $data);
    }

    public function showForm($category) {
        $data = ['category' => $category];
        $this->view('FarmWorker/RequestHelp', $data);
    }
    
    public function submitRequest() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
            $data = [
                'user_id' => $_SESSION['user_id'],
                'user_role' => $_SESSION['user_role'],
                'category' => htmlspecialchars(trim($_POST['category'])),
                'subject' => htmlspecialchars(trim($_POST['subject'])),
                'description' => htmlspecialchars(trim($_POST['description'])),
                'attachment' => null,
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s'),
                'request_error' => ''
            ];
    
            // Handle file upload
            if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = 'Uploads/help_requests/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
    
                // Validate file extension
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
                $fileExtension = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION));
                $maxFileSize = 5 * 1024 * 1024; // 5MB limit
    
                if (!in_array($fileExtension, $allowedExtensions)) {
                    $data['request_error'] = 'Only JPEG, PNG, or PDF files are allowed.';
                } elseif ($_FILES['attachment']['size'] > $maxFileSize) {
                    $data['request_error'] = 'File size exceeds 5MB limit.';
                } else {
                    // Generate unique file name
                    $uniqueName = uniqid('attachment_') . '.' . $fileExtension;
                    $uploadFile = $uploadDir . $uniqueName;
    
                    if (move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadFile)) {
                        $data['attachment'] = $uploadFile;
                    } else {
                        error_log("Failed to upload attachment: " . $_FILES['attachment']['name']);
                        $data['request_error'] = 'Failed to upload attachment. Please try again.';
                    }
                }
            }
    
            if (empty($data['request_error'])) {
                if ($this->WorkerModel->saveHelpRequest($data)) {
                    $_SESSION['request_success'] = 'Your request has been submitted successfully!';
                    Redirect('WorkerController/RequestHelp');
                } else {
                    error_log("Failed to save help request: " . json_encode($data));
                    $data['request_error'] = 'Failed to submit your request. Please try again.';
                }
            }
    
            $_SESSION['request_error'] = $data['request_error'];
            Redirect('WorkerController/RequestHelp');
        }
    }



    public function markHelpNotificationAsRead($notificationId, $userId) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Ensure the user is authorized
            if ($userId != $_SESSION['user_id']) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Unauthorized']);
                exit;
            }

            $notificationModel = $this->model('Notification');
            $result = $notificationModel->markHelpNotificationAsRead($notificationId, $userId);

            header('Content-Type: application/json');
            echo json_encode(['success' => $result]);
            exit;
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Invalid request method']);
            exit;
        }
    }
 

    public function getNotifications($worker_id) {
        $jobnotifications = (array) $this->NotificationModel->getJobNotifications($worker_id);
        $helpRequestNotifications = (array)$this->NotificationModel->getHelpRequestNotificationsForUser($worker_id);

        $notifications = array_merge($jobnotifications,$helpRequestNotifications);

        header('Content-Type: application/json');
        echo json_encode($notifications);
    }

    public function getUnreadNotifications() {
        $data = [];
        $this->View('inc/Notification', $data);
    }

    public function markNotificationAsRead($id, $worker_id) {
        $result = $this->NotificationModel->markJobNotificationAsRead($id, $worker_id);
        header('Content-Type: application/json');
        echo json_encode(['success' => $result]);
    }

    public function getUnreadNotificationsCount($worker_id) {
       
        $count = $this->NotificationModel->getUnreadNotificationsCount($worker_id);
        return $count->count;
        
    }
    
}
?>
