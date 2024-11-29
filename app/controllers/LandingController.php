<?php 
class LandingController extends Controller{

    public function __construct()
    {
       $this->userModel = $this->model('Users');
    }

    public function index()
    {
         $data = [];
        $this->View('Landing/index',$data);
    }

    public function aboutus()
    {
        $data = [];
        $this->View('Landing/aboutus',$data);
    }

    public function products()
    {
        $data = [];
        $this->View('Landing/products',$data);
    }

    public function signup()
    {

        //validate data
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        
        {
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'address' => trim($_POST['address']),
                'title' => trim($_POST['title']),
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'title_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            if(empty($data['name']))
            {
                $data['name_err'] = 'Please enter name';
            }

            if(empty($data['email']))
            {
                $data['email_err'] = 'Please enter email';
            }
            else
            {
                if($this->userModel->finduserbyemail($data['email']))
                {
                    $data['email_err'] = 'Email already taken';
                }
            }

            if(empty($data['phone']))
            {
                $data['phone_err'] = 'Please enter phone number';
            }

            if(empty($data['address']))
            {
                $data['address_err'] = 'Please enter address';
            }

            if(empty($data['title']))
            {
                $data['title_err'] = 'Please select a title';
            }

            if(empty($data['password']))
            {
                $data['password_err'] = 'Please enter password';
            }

            if(empty($data['confirm_password']))
            {
                $data['confirm_password_err'] = 'Please eneter confirm password';
            }
            else{
                if($data['password'] != $data['confirm_password'])
                {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            if(empty($data['name_err']) && empty($data['email_err']) && empty($data['phone_err']) && empty($data['address_err']) && empty($data['title_err']) && empty($data['password_err']) && empty($data['confirm_password_err']))
            { 
                $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
               //resgister user
                if($this->userModel->register($data))
                {
                     Redirect('LandingController/Login');
                     exit;
                }
                else
                {
                     die('Something went wrong');
                }
            }
            else
            {
                $this->View('Landing/signup',$data);
            }
        }
        else
        {
            $data = [
                'name' => '',
                'email' => '',
                'phone' => '',
                'address' => '',
                'title' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'address_err' => '',
                'title_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            $this->View('Landing/signup',$data);
        }
    }

    public function Login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'verified_err' => '',
                'password_err' => ''
            ];

            if(empty($data['email']))
            {
                $data['email_err'] = 'Please enter email';
            }
            else{
                if($this->userModel->finduserbyemail($data['email']))
                {
                    //user found
                }
                else
                {
                    $data['email_err'] = 'No user found';
                }
            }

            if(empty($data['password']))
            {
                $data['password_err'] = 'Please enter password';
            }
          

            if (empty($data['email_err']) && empty($data['password_err'])) {
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                
                if ($loggedInUser) {
                    // Check if the user is verified
                    if ($loggedInUser->status == 'unverified') {
                        // If user is unverified, set error message and prevent login
                        $data['verified_err'] = 'Your account is not verified. Please wait Untill An Admin Verify You.';
                        $this->View('Landing/Login', $data);  // Show the error in the login page
                        return;  // Stop further execution
                    }
    
                    // If the user is verified, create session
                    $this->CreateUserSession($loggedInUser);
    
                } else {
                    $data['password_err'] = 'Password incorrect';
                    $this->View('Landing/Login', $data);  // Show password error
                }
            } else {
                // If there are errors, re-render the login form
                $this->View('Landing/Login', $data);
            }
        }
        else
        {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];
            $this->View('Landing/Login',$data);
        }
    }

    public function CreateUserSession($user){
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_role'] = $user->title;
         // Check if the user is an admin
    if ($user->title == 'admin') {
        // Redirect to the admin dashboard if the user is an admin
        Redirect('AdminController/Dashboard');
    } else if ($user->title == 'moderator') {
        // Redirect to the user home page if the user is not an admin
        Redirect('ModeratorController/Dashboard');
    }
    else if($user->title == 'farmer'){
        Redirect('FarmerController/Dashboard');
    }
    else if($user->title == 'buyer'){
        Redirect('BuyerController/Dashboard');
    }
    else if($user->title == 'supplier'){
        Redirect('SupplierController/Dashboard');
    }
    else if($user->title == 'farmworker'){
        Redirect('WorkerController/Dashboard');
    }
    else if($user->title == 'manufacturer'){
        Redirect('ManufacturerController/Dashboard');
    }
    }

    public function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        Redirect('LandingController/Login');
    }   

    public function isloggedin(){
        if(isset($_SESSION['user_id'])){
            return true;
        }else{
            return false;
        }
    }

    public function RegisterManufacturer()
    {

        //validate data
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        
        {
            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'document' => '',
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'document_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            if(empty($data['name']))
            {
                $data['name_err'] = 'Please enter name';
            }

            if(empty($data['email']))
            {
                $data['email_err'] = 'Please enter email';
            }
            else
            {
                if($this->userModel->finduserbyemail($data['email']))
                {
                    $data['email_err'] = 'Email already taken';
                }
            }

            if(empty($data['phone']))
            {
                $data['phone_err'] = 'Please enter phone number';
            }

            if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
                $targetDir = "uploads/Manufacturer/Documents/"; // Folder to store uploads
                $fileName = basename($_FILES['document']['name']);
                $targetFilePath = $targetDir . $fileName;
    
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];

    
                if (in_array(strtolower($fileType), $allowedTypes)) {
                    // Move file to server
                    if (move_uploaded_file($_FILES['document']['tmp_name'], $targetFilePath)) {
                        $data['document'] = $targetFilePath;
                    } else {
                        $data['document_err'] = 'Failed to upload the file';
                    }
                } else {
                    $data['document_err'] = 'Invalid file type';
                }
            } else {
                $data['document_err'] = 'File Not selected';
            }
          

            if(empty($data['password']))
            {
                $data['password_err'] = 'Please enter password';
            }

            if(empty($data['confirm_password']))
            {
                $data['confirm_password_err'] = 'Please eneter confirm password';
            }
            else{
                if($data['password'] != $data['confirm_password'])
                {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            if(empty($data['name_err']) && empty($data['email_err']) && empty($data['phone_err']) && empty($data['document_err']) && empty($data['password_err']) && empty($data['confirm_password_err']))
            { 
                $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
               //resgister user
                if($this->userModel->RegisterManufacturer($data))
                {
                     Redirect('LandingController/Login');
                     exit;
                }
                else
                {
                     die('Something went wrong');
                }
            }
            else
            {
                $this->View('Landing/RegisterManufacturer',$data);
            }
        }
        else
        {
            $data = [
                'name' => '',
                'email' => '',
                'phone' => '',
                'document' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'document_err' => '',
                'phone_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            $this->View('Landing/RegisterManufacturer',$data);
        }
    }

}

?>