<?php

class Pages extends Controller{
    //constructor
    public function __construct(){
       $this->pageModel = $this->model('M_pages');
    }

    public function index(){
        echo 'index method loaded';
    }

    public function about(){
       $users = $this->pageModel->getUsers();
         $data = [
            
              'users' => $users
         ];

         $this->View('v_about',$data);
    }
}

?>