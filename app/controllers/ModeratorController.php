<?php
class ModeratorController extends Controller {
    private $notificationModel;

    public function __construct() {
        if (!$this->isloggedin()) {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            Redirect('LandingController/login');
        }
        $this->notificationModel = $this->model('M_pages');
    }

    public function isloggedin() {
        return isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'moderator';
    }

    public function dashboard() {
        // Fetch dashboard data
        $allRequests = $this->notificationModel->getHelpRequests();
        $data = [
            'total_requests' => count($allRequests),
            'pending_requests' => count(array_filter($allRequests, fn($r) => $r->status === 'pending')),
            'in_progress_requests' => count(array_filter($allRequests, fn($r) => $r->status === 'in_progress')),
            'responded_requests' => count(array_filter($allRequests, fn($r) => $r->status === 'responded')),
            'resolved_requests' => count(array_filter($allRequests, fn($r) => $r->status === 'resolved')),
            'closed_requests' => count(array_filter($allRequests, fn($r) => $r->status === 'closed')),
            'categories' => $this->getCategoryPendingCounts($allRequests),
            'recent_requests' => array_slice(array_filter($allRequests, fn($r) => $r->status === 'pending'), 0, 5) // Last 5 pending
        ];

        $this->view('Moderator/dashboard', $data);
    }

    public function Help() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['reply'])) {
            $requestId = $_POST['request_id'];
            $reply = $_POST['reply'];
            $moderatorId = $_SESSION['user_id'];
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

        $this->View('Moderator/Help', $data);
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
        if ($this->notificationModel->addReply($requestId, $moderatorId, $reply)) {
            $this->notificationModel->updateRequestStatus($requestId, $moderatorId, 'responded');
            $_SESSION['reply_success'] = "Reply sent successfully!";
        } else {
            $_SESSION['reply_error'] = "Failed to send reply.";
        }
        $category = $this->notificationModel->getUserByRequestId($requestId)->category ?? '';
        Redirect('ModeratorController/Help?category=' . urlencode($category));
    }

    public function serveAttachment($requestId) {
        $request = $this->notificationModel->getRequestById($requestId); // Add this method to M_pages
        if ($request && !empty($request->attachment) && file_exists($request->attachment)) {
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($request->attachment) . '"');
            readfile($request->attachment);
            exit;
        } else {
            die('File not found.');
        }
    }

    public function Manageprofile() {
        $data = [];
        $this->View('Moderator/ManageProfile', $data);
    }
}
?>