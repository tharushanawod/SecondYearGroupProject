<?php
class WorkerController extends Controller {
    private $WorkerModel;
    private $NotificationModel;

    public function __construct() {  
        if (!$this->isloggedin()) {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            Redirect('LandingController/login');
        } 
        $this->WorkerModel = $this->model('Worker');
        $this->NotificationModel = $this->model('Notification');
    }

    public function isloggedin() {
        return isset($_SESSION['user_id']) && $_SESSION['user_role'] == 'farmworker';
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
                'name_err' => '',
                'phone_err' => '',
                'address_err' => '',
                'email_err' => '',
                'bio_err' => ''
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
                    Redirect('LandingController/logout');
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
                'password' => '',
                'name_err' => '',
                'phone_err' => '',
                'email_err' => '',
                'password_err' => ''
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
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'user_id' => $_SESSION['user_id'],
                'user_role' => $_SESSION['user_role'],
                'category' => trim($_POST['category']),
                'subject' => trim($_POST['subject']),
                'description' => trim($_POST['description']),
                'attachment' => null,
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s')
            ];

            if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = 'Uploads/help_requests/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                $attachmentName = basename($_FILES['attachment']['name']);
                $uploadFile = $uploadDir . $attachmentName;
                if (move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadFile)) {
                    $data['attachment'] = $uploadFile;
                } else {
                    error_log("Failed to upload attachment: " . $attachmentName);
                }
            }

            if ($this->WorkerModel->saveHelpRequest($data)) {
                $_SESSION['request_success'] = 'Your request has been submitted successfully!';
                Redirect('WorkerController/RequestHelp');
            } else {
                error_log("Failed to save help request: " . json_encode($data));
                $_SESSION['request_error'] = 'Failed to submit your request. Please try again.';
                Redirect('WorkerController/RequestHelp');
            }
        }
    }

    public function getNotifications($user_id) {
        $helpRequestNotifications = $this->NotificationModel->getHelpRequestNotificationsForUser($user_id);
        $notifications = $helpRequestNotifications; 
        header('Content-Type: application/json');
        try {
            echo json_encode($notifications);
        } catch (Exception $e) {
            error_log("Failed to encode notifications for user_id $user_id: " . $e->getMessage());
            echo json_encode([]);
        }
    }

    public function getUnreadNotifications() {
        $data = [
            'notifications' => $this->NotificationModel->getHelpRequestNotificationsForUser($_SESSION['user_id']),
            'unread_count' => $this->NotificationModel->getUnreadHelpNotificationsCountForUser($_SESSION['user_id'])->count
        ];
        $this->view('inc/Notification', $data);
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

    public function markNotificationAsRead($notificationId, $userId) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Ensure the user is authorized
            if ($userId != $_SESSION['user_id']) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Unauthorized']);
                exit;
            }

            $notificationModel = $this->model('Notification');
            $result = $notificationModel->markNotificationAsRead($notificationId, $userId);

            header('Content-Type: application/json');
            echo json_encode(['success' => $result]);
            exit;
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Invalid request method']);
            exit;
        }
    }    

    public function getUnreadNotificationsCount($user_id) {
        $count = $this->NotificationModel->getUnreadHelpNotificationsCountForUser($user_id)->count;
        return $count;
    }
    
}
?>
