<?php
class NotificationController extends Controller {
    private $NotificationModel;

    public function __construct() {
        session_start(); 
        $this->NotificationModel = $this->model('Notification');
        if (!$this->isLoggedIn()) {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            redirect('LandingController/login');
        }
    }

    private function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

}
?>