<?php 
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class LandingController extends Controller{
    private $userModel;

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

    public function Register(){
        $data = [];
        $this->View('Landing/SignUp',$data);
    }

    public function signup() {
        // Sanitize data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        
        // Initialize the user type
        $user_type = $_POST['user_type'] ?? $_GET['user_type'];
        
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'name' => trim($_POST['name']),
                'company_name' => isset($_POST['company_name']) ? trim($_POST['company_name']) : '',
                'compamy_name_err' => '',
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'address' => isset($_POST['address']) ? trim($_POST['address']) : '',
                'district' => isset($_POST['district']) ? trim($_POST['district']) : '',
                'document' => '',
                'document_err' => '',
                'working_area' => isset($_POST['working_area']) ? trim($_POST['working_area']) : '',
                'working_area_err' => '',
                'user_type' => $_POST['user_type'],
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'address_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

         
            // Validate data
            if (empty($data['name'])) $data['name_err'] = 'Please enter name';
            if ($data['user_type'] == 'manufacturer' && empty($data['company_name'])) $data['company_name_err'] = 'Please enter company name';
            if (empty($data['email'])) $data['email_err'] = 'Please enter email';
            if ($this->userModel->finduserbyemail($data['email'])) $data['email_err'] = 'Email already taken';
            if (empty($data['phone'])) $data['phone_err'] = 'Please enter phone number';
            if ($data['user_type'] == 'farmer' && empty($data['address'])) $data['address_err'] = 'Please enter address';
            if ($data['user_type'] == 'farmer' && empty($data['district'])) $data['district_err'] = 'Please enter district';
            if ($data['user_type']== 'manufacturer' && empty($data['company_name'])) $data['company_name_err'] = 'Please enter company name';

    
            // File upload validation
            if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {

                if($data['user_type']=='manufacturer'){
                    $targetDir = "uploads/Manufacturer/Documents/"; // Folder to store uploads
                }
                else{
                    $targetDir = "uploads/Supplier/Documents/"; // Folder to store uploads
                }
              
               
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
            } else if(!isset($_FILES['document'])) {
                $data['document_err'] = '';
            }
            else{
                $data['document_err'] = 'File Not selected';
            }
    
            if ($data['user_type'] == 'farmworker' && empty($data['working_area'])) $data['working_area_err'] = 'Please enter working area';
            if (empty($data['password'])) $data['password_err'] = 'Please enter password';
            if (empty($data['confirm_password'])) $data['confirm_password_err'] = 'Please enter confirm password';
            elseif ($data['password'] != $data['confirm_password']) $data['confirm_password_err'] = 'Passwords do not match';

    
            // If no errors, hash password and register user
            if (empty($data['name_err']) && empty($data['email_err']) && empty($data['phone_err']) && empty($data['address_err']) && empty($data['district_err']) && empty($data['document_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                if ($this->userModel->register($data)) {

                    
                   
                    $_SESSION['user_email'] = $data['email'];
                    // Redirect('LandingController/Otppage');
                    $this->View('Landing/Otppage',$data);
                    exit;
                } else {
                    die('Something went wrong');
                }
            } else {
                $view = 'Landing/' . ucfirst($data['user_type']) . 'Reg';
                $this->View($view, $data);
            }
        } else {
            // Default form load with empty data
            $data = [
                'name' => '',
                'email' => '',
                'phone' => '',
                'address' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'address_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
    
            $view = 'Landing/' . ucfirst($user_type) . 'Reg';
            $this->View($view, $data);
        }
    }

    public function OTP(){
        echo $_SESSION['user_email'];
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        
            // Generate a 6-digit OTP
            $otp = rand(100000, 999999); 
            $_SESSION['otp'] = $otp; // Store OTP in session
            $receiver = $_SESSION['user_email']; // Get the email address from the session
            
        
            // Send OTP via Email
            $mail = new PHPMailer(true);
            try {
                $mail->isSMTP();
                $mail->Host = 'smtp.gmail.com';
                $mail->SMTPAuth = true;
                $mail->Username = 'tharushanjayasinghe222@gmail.com';
                $mail->Password = 'vzsuwxuiitfvakpl';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('tharushanjayasinghe222@gmail.com', 'Tharusha Nawod');
                $mail->addAddress($receiver);

                $mail->isHTML(true);
                $mail->Subject = 'Corn Cradle Verification';
                $mail->Body = "Hello,<br><br>Your OTP code is: <b>$otp</b><br><br>Thank you for using our service.";

                $mail->send();
                echo "✅ OTP has been successfully sent to $receiver.";
                $mail->SMTPDebug = 3; // Debug level (0 to disable debugging)
                $mail->Debugoutput = 'html'; // Output debug info as HTML (useful for web apps)

            } catch (Exception $e) {
                echo "Mailer Error: {$mail->ErrorInfo}";
            }
        }

        else{
            echo 'isset is not working';
        }       
        
    }

    public function VerifyOTP() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $otp = $_POST['code'];
            if ($otp == $_SESSION['otp']) {
                $data['email'] = $_SESSION['user_email'];
                if($this->userModel->VerifyUsers($data)){
                    // OTP is correct
                    echo json_encode(['status' => 'success', 'message' => '✅ OTP is correct', 'redirect' => URLROOT . '/LandingController/Login']);
                }
             
               
            } else {
                // OTP is incorrect
                echo json_encode(['status' => 'error', 'message' => '❌ OTP is incorrect']);
            }
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
                    if ($loggedInUser->otp_status == 'unverified') {
                        // If user is unverified, set error message and prevent login
                        $data['verified_err'] = 'Your account is not verified. Please verify account using OTP.';
                        $this->View('Landing/Login', $data);  // Show the error in the login page
                        return;  // Stop further execution
                    }

                    if($loggedInUser->otp_status == 'restricted'){
                        $data['verified_err'] = 'Your account is restricted. Please contact the admin. ⬇️  CornCradleadmin@mail.com';
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

    public function verifyAccount(){
        $data = [];
        $this->View('Landing/Otppage',$data);
    }

    public function CreateUserSession($user){
        $_SESSION['user_id'] = $user->user_id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_role'] = $user->user_type;
         // Check if the user is an admin
    if ($user->user_type == 'admin') {
        // Redirect to the admin dashboard if the user is an admin
        Redirect('AdminController/Dashboard');
    } else if ($user->user_type == 'moderator') {
        // Redirect to the user home page if the user is not an admin
        Redirect('ModeratorController/Dashboard');
    }
    else if($user->user_type == 'farmer'){
        Redirect('FarmerController/Dashboard');
    }
    else if($user->user_type == 'buyer'){
        Redirect('BuyerController/Dashboard');
    }
    else if($user->user_type == 'supplier'){
        Redirect('SupplierController/Dashboard');
    }
    else if($user->user_type == 'farmworker'){
        Redirect('WorkerController/Dashboard');
    }
    else if($user->user_type == 'manufacturer'){
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