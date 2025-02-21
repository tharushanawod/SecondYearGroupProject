<?php 


class NotificationController extends Controller {

    private $NotificationModel;
    public function __construct() {
        if (!$this->isloggedin()) {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            Redirect('LandingController/login');
        }
        $this->NotificationModel = $this->model('Notification');
        
    }

    public function isloggedin() {
        if (isset($_SESSION['user_id']) ){
            return true;
        } else {
            return false;
        }
    }



}


?>

