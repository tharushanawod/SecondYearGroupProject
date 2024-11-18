<?php 

class ModeratorController extends Controller {


    public function __construct() {
    
    }
    public function index() {
        $data = [];
        $this->View('Moderator/Landing', $data);
    }


    // public function index() {

    //     $data = [];
    //     $this->View('Moderator/Landing', $data);
    // }

    // public function Help() {
    //     $data = [];
    //     $this->View('Moderator/Help', $data);
    // }

    // public function LabourRequests() {
    //     $data = [];
    //     $this->View('Moderator/Labourrequests', $data);
    // }


}

?>
