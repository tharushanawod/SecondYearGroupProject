<?php 

class AdminController extends Controller {

    public function __construct() {
       
        $this->pagesModel = $this->model('Users');
    }

    // Fetch and display users on the dashboard
    public function dashboard() {
        // Retrieve users from the model
        $users = $this->pagesModel->getUsers();

        // Pass the user data to the view
        $data = ['users' => $users];

        // Render the view
        $this->View('Admin/LandingDashboard', $data);
    }

   public function RemoveUsers(){
  $data =[];

    $this->View('Admin/RemoveUsers',$data);
   }

    public function AddModerators(){
    
     $data =[];
    
     $this->View('Admin/AddModerators',$data);
    }

 
  

    public function deleteUser($id) {
        // Call the deleteUser method from the model to delete the user
        if ($this->pagesModel->deleteUser($id)) {
            // Redirect to users list page or dashboard
            header('Location: ' . URLROOT . '/AdminController/RemoveUsers');
        } else {
            die('Something went wrong while deleting the user.');
        }
    }

    public function UpdateUsers(){
        $data =[];
        $this->View('Admin/UpdateUsers',$data);
    }

    
    
}

?>
