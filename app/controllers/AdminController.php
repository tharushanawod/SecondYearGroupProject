<?php 

class AdminController extends Controller {
    private $pagesModel;

    public function __construct() {

        if(!$this->isloggedin()){
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            Redirect('LandingController/login');
        }
       
   
        $this->pagesModel = $this->model('Users');
    }

    public function isloggedin() {
        if (isset($_SESSION['user_id']) && ($_SESSION['user_role']=='admin')){
            return true;
        } else {
            return false;
        }
    }

    // Fetch and display users on the dashboard
    public function Dashboard() {
       
        // Retrieve users from the model
        $users = $this->pagesModel->getUsers();

        // Pass the user data to the view
        $data = ['users' => $users];

        // Render the view
        $this->View('Admin/LandingDashboard', $data);
    }

    public function RemoveUsers(){
     
        // Retrieve users from the model
        $users = $this->pagesModel->getUnrestrictedtUsers();

        // Pass the user data to the view
        $data = ['users' => $users];
        

        $this->View('Admin/RemoveUsers',$data);
    }

    public function getManufacturers(){
        $users = $this->pagesModel->getManufacturers();

        $data = ['users' => $users];

        $this->View('Admin/getManufacturers',$data);
    }

    public function verifyUser($id){
        if($this->pagesModel->verifyUser($id)){
            Redirect('AdminController/getManufacturers');
        }else{  
            die('Something went wrong');
        }
    }

 
  

    public function RestrictUser($id) {
      
        // Sanitize the ID
        $id = filter_var($id, FILTER_SANITIZE_NUMBER_INT);

        if($_SESSION['user_id'] == $id){
            die('You cannot delete yourself');
        }
    
        // Call the model function to delete the user
        if ($this->pagesModel->RestrictUser($id)) {
            // Redirect after successful deletion
            header('Location: ' . URLROOT . '/AdminController/RemoveUsers');
        } else {
            // Handle error if deletion fails
            die('Something went wrong while deleting the user.');
        }
    }
    

    public function UpdateUsers(){
        $users = $this->pagesModel->getUsers();
        $data = ['users' => $users];

        $this->View('Admin/UpdateUsers',$data);
     
    }


    public function UserCount($title){
        $count = $this->pagesModel->getUserCount($title);
        return $count;
    }

    public function edituser($id){
       

        $user = $this->pagesModel->getUserById($id);
        $data = [
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'title' => $user->title,
            'password' => '',
            'confirm_password' => '',
            'name_err' => '',
            'email_err' => '',
            'phone_err' => '',
            'title_err' => '',
            'password_err' => '',
            'confirm_password_err' => ''
        ];

        $this->View('Admin/SubmitUpdateUser',$data);
    }

    public function SubmitUpdateUser($id){
        

      $user = $this->pagesModel->getUserById($id);
      
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'id' => trim($_POST['id']),
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'title' => trim($_POST['title']),
                'password' => trim($_POST['password']),
                'name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'title_err' => '',
                'password_err' => ''
            ];

            if(empty($data['name'])){
                $data['name_err'] = 'Please enter a username';
            }

            if(empty($data['email'])){
                $data['email_err'] = 'Please enter an email';
            }
            else{
                if($this->pagesModel->findUserByEmail($data['email'])){

                    if($data['email'] !== $user->email){
                        $data['email_err'] = 'Email is already taken';
                    }
                   
                }
            }

            if(empty($data['phone'])){
                $data['phone_err'] = 'Please enter a contact number';
            }

            if(empty($data['title'])){
                $data['title_err'] = 'Please select a title';
            }

           

            if(empty($data['name_err']) && empty($data['email_err']) && empty($data['phone_err']) && empty($data['title_err']) ){
                if(!empty($data['password'])){
                $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
                }

                if($this->pagesModel->updateUser($data)){
                    Redirect('AdminController/UpdateUsers');
                }else{
                    die('Something went wrong');
                }
            }else{
                $this->View('Admin/SubmitUpdateUser',$data);
            }
    }
    
    
}

    public function AddModerators(){
       

        $users=$this->pagesModel->FindModerators();

        $data = ['users' => $users];

        $this->view('Admin/AddModerators',$data);
    }

    public function SubmitModerator(){
      
        
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {

            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'password' => trim($_POST['password']),
                'name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'title_err' => '',
                'password_err' => ''
            ];

            if(empty($data['name'])){
                $data['name_err'] = 'Please enter a username';
            }

            if(empty($data['email'])){
                $data['email_err'] = 'Please enter an email';
            }
            else{
                if($this->pagesModel->findUserByEmail($data['email'])){
                    $data['email_err'] = 'Email is already taken';
                }
            }

            if(empty($data['phone'])){
                $data['phone_err'] = 'Please enter a contact number';
            }


            if(empty($data['password'])){
                $data['password_err'] = 'Please enter a password';
            }

            if(empty($data['name_err']) && empty($data['email_err']) && empty($data['phone_err']) && empty($data['password_err'])){
                $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
                if($this->pagesModel->AddModerators($data)){
                    Redirect('AdminController/AddModerators');
                }else{
                    die('Something went wrong');
                }
            }else{
                $this->view('Admin/SubmitModerator',$data);
            }


        }

        else{
            $data = [
                'name' => '',
                'email' => '',
                'phone' => '',
                'title' => '',
                'password' => '',
                'name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'title_err' => '',
                'password_err' => ''
            ];

            $this->view('Admin/SubmitModerator',$data);

        }

       
    }

  
    public function test (){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $search = trim($_POST['search']);
            $users = $this->pagesModel->searchUsers($search);
           
            $data = ['users' => $users];

        $this->view('Admin/RemoveUsers',$data);
        }
      
    

    }

    public function Report() {
      
    
        // Get all users from the model
        $users = $this->pagesModel->getUsers();
    
        // If the user requested a CSV report
       
            $this->generateCSV($users); // Generate CSV
   
    
        // Pass data to the view for display
        $data = ['users' => $users];
        $this->view('Admin/Report', $data);
    }
    
    // Helper function to generate and download CSV
    private function generateCSV($users) {
        // File name
        $fileName = 'User_Report_' . date('Y-m-d_H-i-s') . '.csv';
    
        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
    
        // Open output stream
        $output = fopen('php://output', 'w');
    
        // Write column headers to CSV
        fputcsv($output, ['ID', 'Name', 'Email', 'Phone', 'Created At']);
    
        // Write user data to CSV
        foreach ($users as $user) {
            fputcsv($output, [
                $user->id,
                $user->name,
                $user->email,
                $user->phone,
                $user->created_at
            ]);
        }
    
        // Close output stream
        fclose($output);
        exit; // Stop further script execution after sending the file
    }

    public function Manageprofile(){
        $this->View('Admin/ManageProfile');
    }
    
    public function AllowUser($id){
        if($this->pagesModel->AllowUser($id)){
            Redirect('AdminController/Dashboard');
        }else{
            die('Something went wrong');
        }
    }

}

?>
