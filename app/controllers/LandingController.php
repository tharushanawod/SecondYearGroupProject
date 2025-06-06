<?php 
 use PHPMailer\PHPMailer\PHPMailer;
 use PHPMailer\PHPMailer\SMTP;
 use PHPMailer\PHPMailer\Exception;
 ini_set('display_errors', 1);
error_reporting(E_ALL);
 
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

    public function newlanding()
    {
        $data = [];
        $this->View('Landing/new_index',$data);
    }

    public function aboutus()
    {
        $data = [];
        $this->View('Landing/aboutus',$data);
    }

    public function terms()
    {
        $data = [];
        $this->View('Landing/terms',$data);
    }

    public function Auction()
    {
        $data = [];
        $this->View('Landing/Auction',$data);
    }

    public function Register(){
        $data = [];
        $this->View('Landing/SignUp',$data);
    }

    public function signup() {
        // Sanitize data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
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
                'skills' => isset($_POST['skills']) ? $_POST['skills'] : [],
                'skills_err' => '',
                'hourly_rate' => isset($_POST['hourly_rate']) ? trim($_POST['hourly_rate']) : '',
                'hourly_rate_err' => '',
                'user_type' => $_POST['user_type'],
                'password' => trim($_POST['password']),
                'confirm_password' => trim($_POST['confirm_password']),
                'terms' => isset($_POST['terms']) ? "accepted" :"rejected" , // NEW: terms checkbox value
                'terms_err' => '', // NEW: error for terms
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
            if ($this->userModel->FindUserByPhone($data['phone'])) $data['phone_err'] = 'Phone Number already taken';
            if (empty($data['phone'])) $data['phone_err'] = 'Please enter phone number';
            if ($data['user_type'] == 'farmer' && empty($data['address'])) $data['address_err'] = 'Please enter address';
            if ($data['user_type'] == 'farmer' && empty($data['district'])) $data['district_err'] = 'Please enter district';
            if ($data['user_type'] == 'manufacturer' && empty($data['company_name'])) $data['company_name_err'] = 'Please enter company name';
            if ($data['user_type'] == 'farmworker' && empty($data['skills'])) $data['skills_err'] = 'Please select at least one skill';
            if ($data['user_type'] == 'farmworker' && empty($data['hourly_rate'])) $data['hourly_rate_err'] = 'Please enter hourly rate';
    
            // Validate terms checkbox
            if (empty($data['terms'])) $data['terms_err'] = 'You must agree to the terms and conditions.';
    
            // File upload validation
            if (isset($_FILES['document']) && $_FILES['document']['error'] == 0) {
    
                if($data['user_type']=='manufacturer'){
                    $targetDir = "uploads/Manufacturer/Documents/";
                } else {
                    $targetDir = "uploads/Supplier/Documents/";
                }
    
                $fileName = basename($_FILES['document']['name']);
                $targetFilePath = $targetDir . $fileName;
    
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                $allowedTypes = ['jpg', 'jpeg', 'png', 'pdf'];
    
                if (in_array(strtolower($fileType), $allowedTypes)) {
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
            } else {
                $data['document_err'] = 'File Not selected';
            }
    
            if ($data['user_type'] == 'farmworker' && empty($data['working_area'])) $data['working_area_err'] = 'Please enter working area';
            if (empty($data['password'])) $data['password_err'] = 'Please enter password';
            if (empty($data['confirm_password'])) $data['confirm_password_err'] = 'Please enter confirm password';
            elseif ($data['password'] != $data['confirm_password']) $data['confirm_password_err'] = 'Passwords do not match';
    
            // If no errors
            if (empty($data['name_err']) && empty($data['email_err']) && empty($data['phone_err']) && empty($data['address_err']) && empty($data['district_err']) && empty($data['document_err']) && empty($data['password_err']) && empty($data['confirm_password_err']) && empty($data['skills_err']) && empty($data['hourly_rate_err']) && empty($data['terms_err'])) {
                
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                if ($this->userModel->register($data)) {
                    $_SESSION['user_email'] = $data['email'];
                    $this->View('Landing/Otppage', $data);
                    exit;
                } else {
                    die('Something went wrong');
                }
            } else {
                $view = 'Landing/' . ucfirst($data['user_type']) . 'Reg';
                $this->View($view, $data);
            }
        } else {
            $data = [
                'name' => '',
                'email' => '',
                'phone' => '',
                'address' => '',
                'password' => '',
                'confirm_password' => '',
                'hourly_rate' => '',
                'terms' => '',
                'name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'address_err' => '',
                'password_err' => '',
                'confirm_password_err' => '',
                'working_area_err' => '',
                'skills_err' => '',
                'hourly_rate_err' => '',
                'terms_err' => ''
            ];
    
            $view = 'Landing/' . ucfirst($user_type) . 'Reg';
            $this->View($view, $data);
        }
    }
    

    public function OTP(){
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        
        echo "tharusha";
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
                $mail->Password = 'cjvnnrstpmhzntvp';
                $mail->SMTPSecure = 'tls';
                $mail->Port = 587;

                $mail->setFrom('tharushanjayasinghe222@gmail.com', 'Tharusha Nawod');
                $mail->addAddress($receiver);

                $mail->isHTML(true);
                $mail->Subject = 'Corn Cradle Verification';
                
                // HTML email with CSS styling
                $mail->Body = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 5px;'>
                    <div style='background-color: #4CAF50; padding: 15px; text-align: center; border-radius: 5px 5px 0 0;'>
                        <h1 style='color: white; margin: 0;'>Email Verification</h1>
                    </div>
                    <div style='padding: 20px; background-color: #f9f9f9;'>
                        <p style='font-size: 16px; line-height: 1.5; color: #333;'>Hello,</p>
                        <p style='font-size: 16px; line-height: 1.5; color: #333;'>Thank you for registering with Corn Cradle. To complete your registration, please use the verification code below:</p>
                        <div style='text-align: center; margin: 30px 0;'>
                            <div style='background-color: #e8f5e9; border: 2px dashed #4CAF50; padding: 15px; display: inline-block; border-radius: 5px;'>
                                <span style='font-size: 24px; font-weight: bold; letter-spacing: 5px; color: #2E7D32;'>$otp</span>
                            </div>
                        </div>
                        <p style='font-size: 16px; line-height: 1.5; color: #333;'>This code will expire in 15 minutes. If you did not request this code, please ignore this email.</p>
                        <p style='font-size: 16px; line-height: 1.5; color: #333;'>Thank you for using our service!</p>
                    </div>
                    <div style='padding: 15px; text-align: center; color: #666; font-size: 14px; background-color: #e0e0e0; border-radius: 0 0 5px 5px;'>
                        &copy; " . date('Y') . " Corn Cradle. All rights reserved.
                    </div>
                </div>";
                
                // Plain text alternative for email clients that don't support HTML
                $mail->AltBody = "Hello,\n\nYour OTP code is: $otp\n\nThank you for using our service.";

                $mail->send();
                echo "✅ OTP has been successfully sent to $receiver.";
                
            } catch (Exception $e) {
                echo "Mailer Error: {$mail->ErrorInfo}";
            }
        }

        else{
            echo 'isset is not working';
        }
       
        
    }
    // LandingController.php

// LandingController.php

public function SendEmail(){
    // Check if the form is submitted
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        // Sanitize form data
        $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
        $message = htmlspecialchars(trim($_POST['message']));

        // Validate email
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            die('Invalid email format');
        }

        // Prepare email
        $to = 'tharushanawod888$gmail.com'; // The recipient email address
        $subject = 'Message from Contact Form';
        $body = "You have received a new message.\n\n".
                "Email: $email\n".
                "Message: $message";

        $headers = 'From: ' . $email . "\r\n" .
                   'Reply-To: ' . $email . "\r\n" .
                   'X-Mailer: PHP/' . phpversion();

        // Send email
        if (mail($to, $subject, $body, $headers)) {
            // Redirect or show success message
            header("Location: " . URLROOT . "/LandingController/Register");
            exit();
        } else {
            // Show error message if email fails to send
            die('Error sending email');
        }
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

   
    public function ForgotPassword() {
        
        $this->View('Landing/forgot_password');
    }
    

    // Handle the password reset request
    public function handleForgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'];

            // Check if the email exists in the database
            $user = $this->userModel->getUserByEmail($email);

            if ($user) {
                // Generate a unique reset token
                $token = bin2hex(random_bytes(50));

                // Save the token in the database
                $this->userModel->createPasswordResetToken($email, $token);

                // Send the reset link to the user
                $resetLink = "http://localhost/GroupProject/LandingController/showResetPasswordForm?token=" . $token;

                $mail = new PHPMailer(true);
                try {
                    $mail->isSMTP();
                    $mail->Host = 'smtp.gmail.com';
                    $mail->SMTPAuth = true;
                    $mail->Username = 'tharushanjayasinghe222@gmail.com';
                    $mail->Password = 'cjvnnrstpmhzntvp';
                    $mail->SMTPSecure = 'tls';
                    $mail->Port = 587;
            
                    $mail->setFrom('tharushanjayasinghe222@gmail.com', 'Tharusha Nawod');
                    $mail->addAddress($email);
            
                    $mail->isHTML(true);
                    $mail->Subject = 'Corn Cradle - Password Reset Request';
                    
                    // HTML body with CSS styling
                    $mail->Body = "
                    <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 20px; border: 1px solid #e0e0e0; border-radius: 5px;'>
                        <div style='background-color: #4CAF50; padding: 15px; text-align: center; border-radius: 5px 5px 0 0;'>
                            <h1 style='color: white; margin: 0;'>Password Reset</h1>
                        </div>
                        <div style='padding: 20px; background-color: #f9f9f9;'>
                            <p style='font-size: 16px; line-height: 1.5; color: #333;'>Hello,</p>
                            <p style='font-size: 16px; line-height: 1.5; color: #333;'>We received a request to reset your password. Click the button below to reset it:</p>
                            <div style='text-align: center; margin: 30px 0;'>
                                <a href='$resetLink' style='background-color: #4CAF50; color: white; padding: 12px 25px; text-decoration: none; border-radius: 4px; font-weight: bold; display: inline-block;'>Reset Password</a>
                            </div>
                            <p style='font-size: 16px; line-height: 1.5; color: #333;'>If you did not request a password reset, please ignore this email.</p>
                            <p style='font-size: 16px; line-height: 1.5; color: #333;'>The link will expire in 24 hours.</p>
                        </div>
                        <div style='padding: 15px; text-align: center; color: #666; font-size: 14px; background-color: #e0e0e0; border-radius: 0 0 5px 5px;'>
                            &copy; " . date('Y') . " Corn Cradle. All rights reserved.
                        </div>
                    </div>";
                    
                    // Plain text alternative
                    $mail->AltBody = "Hello,\n\nWe received a request to reset your password. Please click the following link to reset it:\n\n$resetLink\n\nIf you did not request a password reset, please ignore this email.\n\nThe link will expire in 24 hours.";
            
                    $mail->send();
                    $data['success'] = 'A password reset link has been sent to your email address.';
                    $this->View('Landing/forgot_password', $data);
                    
                } catch (Exception $e) {
                    echo "Mailer Error: {$mail->ErrorInfo}";
                }

            } else {
                $data['email_err'] = 'Email address not found';
                $this->View('Landing/forgot_password', $data);
            }
        }
    }

    // Show the reset password form
    public function showResetPasswordForm() {
        $token = $_GET['token'];

        // Check if the token is valid
        $resetRequest = $this->userModel->getResetToken($token);

        if ($resetRequest) {
            $this->View('Landing/reset_password');
        } else {
            echo "Invalid or expired token.";
        }
    }

    // Handle the password reset process
    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $token = $_POST['token'];
            $newPassword = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            if ($newPassword === $confirmPassword) {
                // Check if the token is valid
                $resetRequest = $this->userModel->getResetToken($token);

                if ($resetRequest) {
                    // Update the password in the database
                    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                    $this->userModel->updatePassword($resetRequest->email, $hashedPassword);

                    // Delete the token from the database
                    $this->userModel->deleteResetToken($token);

                    echo "Password has been successfully updated.";
                } else {
                    echo "Invalid or expired token.";
                }
            } else {
                echo "Passwords do not match.";
            }
        }
    }

    public function Login(){
        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {
            $_POST = filter_input_array(INPUT_POST, FILTER_DEFAULT);
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
                    else if ($loggedInUser->user_status == 'pending') {
                        $data['verified_err'] = 'Your account is not verified. Please wait Until Admin Verify Your Account';
                        $this->View('Landing/Login', $data);  // Show the error in the login page
                        return; 
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
        $_SESSION['profile_picture'] = $user->file_path;
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

    public function getProfileImage($userid) {
        $imagePath = $this->userModel->getProfileImage($userid);
    
        if (file_exists($imagePath)) {
            header("Content-Type: image/jpeg");
            readfile($imagePath);
            echo URLROOT.'/'.$imagePath;
        } else {
            echo "Image not found at: $imagePath";
        }

       
    }
    
    
    


}

?>