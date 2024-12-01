<?php 

class ModeratorController extends Controller {


    public function __construct() {
    
        if(!$this->isloggedin()){
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            Redirect('LandingController/login');
        }
       
    }

    public function isloggedin() {
        if (isset($_SESSION['user_id']) && ($_SESSION['user_role']=='moderator')){
            return true;
        } else {
            return false;
        }
    }

    public function Dashboard() {
        $data = [];
        $this->View('Moderator/Landing', $data);
    }

    public function Help() {
        $data = [];
        $this->View('Moderator/Help', $data);
    }

    public function Manageprofile() {
        $data = [];
        $this->View('Moderator/ManageProfile', $data);
    }
  


   


}

?>
