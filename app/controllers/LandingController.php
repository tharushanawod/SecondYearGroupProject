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

            if(empty($data['name_err']) && empty($data['email_err']) && empty($data['phone_err']) && empty($data['title_err']) && empty($data['password_err']) && empty($data['confirm_password_err']))
            { 
                $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
               //resgister user
                if($this->userModel->register($data))
                {
                     header('location:'.URLROOT.'/Landing/login');
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
                'title' => '',
                'password' => '',
                'confirm_password' => '',
                'name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'title_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];
            $this->View('Landing/signup',$data);
        }
    }


}

?>