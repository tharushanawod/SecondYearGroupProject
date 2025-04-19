<?php
class ModeratorController extends Controller {
    private $notificationModel;
    private $notification;
    private $ModeratorModel;

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
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $requestId = trim($_POST['request_id']);
            $reply = trim($_POST['reply']);
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
            $category = $_GET['category'];
            $data['selected_category'] = $category;
            $data['requests'] = $this->notificationModel->getRequestsByCategory($category);
        }

        $this->view('Moderator/Help', $data);
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
            die('Invalid request ID.');
        }

        $request = $this->notificationModel->getRequestById($requestId);
        if ($request && !empty($request->attachment) && file_exists($request->attachment)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($request->attachment) . '"');
            readfile($request->attachment);
            exit;
        } else {
            die('File not found.');
        }
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

    public function Manageprofile() {
        $data = [];
        $this->view('Moderator/ManageProfile', $data);
    }
}