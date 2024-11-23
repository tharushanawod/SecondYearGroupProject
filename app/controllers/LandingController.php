<?php 
class LandingController extends Controller {

    public function __construct() {
        $this->userModel = $this->model('Users');
    }

    public function index() {
        $data = [];
        $this->View('Landing/index', $data);
    }

    public function aboutus() {
        $data = [];
        $this->View('Landing/aboutus', $data);
    }

    public function products() {
        $data = [];
        $this->View('Landing/products', $data);
    }

    public function signup() {
        // Validate data
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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
                'address_err' => '',
                'title_err' => '',
                'password_err' => '',
                'confirm_password_err' => ''
            ];

            if (empty($data['name'])) {
                $data['name_err'] = 'Please enter name';
            }

            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } else {
                if ($this->userModel->finduserbyemail($data['email'])) {
                    $data['email_err'] = 'Email already taken';
                }
            }

            if (empty($data['phone'])) {
                $data['phone_err'] = 'Please enter phone number';
            }

            if (empty($data['address'])) {
                $data['address_err'] = 'Please enter address';
            }

            if (empty($data['title'])) {
                $data['title_err'] = 'Please select a title';
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }

            if (empty($data['confirm_password'])) {
                $data['confirm_password_err'] = 'Please enter confirm password';
            } else {
                if ($data['password'] != $data['confirm_password']) {
                    $data['confirm_password_err'] = 'Passwords do not match';
                }
            }

            if (empty($data['name_err']) && empty($data['email_err']) && empty($data['phone_err']) && empty($data['address_err']) && empty($data['title_err']) && empty($data['password_err']) && empty($data['confirm_password_err'])) {
                $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                // Register user
                if ($this->userModel->register($data)) {
                    $this->redirect('LandingController/Login');
                    exit;
                } else {
                    die('Something went wrong');
                }
            } else {
                $this->View('Landing/signup', $data);
            }
        } else {
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
            $this->View('Landing/signup', $data);
        }
    }

    public function Login() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'email_err' => '',
                'password_err' => ''
            ];

            if (empty($data['email'])) {
                $data['email_err'] = 'Please enter email';
            } else {
                if ($this->userModel->finduserbyemail($data['email'])) {
                    // User found
                } else {
                    $data['email_err'] = 'No user found';
                }
            }

            if (empty($data['password'])) {
                $data['password_err'] = 'Please enter password';
            }

            if (empty($data['email_err']) && empty($data['password_err'])) {
                $loggedInUser = $this->userModel->login($data['email'], $data['password']);
                if ($loggedInUser) {
                    $this->CreateUserSession($loggedInUser);
                } else {
                    $data['password_err'] = 'Password incorrect';
                    $this->View('Landing/Login', $data);
                }
            } else {
                $this->View('Landing/Login', $data);
            }
        } else {
            $data = [
                'email' => '',
                'password' => '',
                'email_err' => '',
                'password_err' => ''
            ];
            $this->View('Landing/Login', $data);
        }
    }

    public function CreateUserSession($user) {
        $_SESSION['user_id'] = $user->id;
        $_SESSION['user_email'] = $user->email;
        $_SESSION['user_name'] = $user->name;
        $_SESSION['user_role'] = $user->title;
        // Check if the user is an admin
        if ($user->title == 'admin') {
            // Redirect to the admin dashboard if the user is an admin
            $this->redirect('AdminController/index');
        } else if ($user->title == 'moderator') {
            // Redirect to the user home page if the user is not an admin
            $this->redirect('ModeratorController/index');
        } else if ($user->title == 'farmer') {
            $this->redirect('FarmerController/dashboard');
        } else if ($user->title == 'buyer') {
            $this->redirect('BuyerController/index');
        } else if ($user->title == 'supplier') {
            $this->redirect('SupplierController/dashboard');
        } else if ($user->title == 'farmworker') {
            $this->redirect('FarmworkerController/index');
        } else if ($user->title == 'manufacturer') {
            $this->redirect('ManufacturerController/index');
        }
    }

    public function logout() {
        unset($_SESSION['user_id']);
        unset($_SESSION['user_email']);
        unset($_SESSION['user_name']);
        session_destroy();
        $this->redirect('LandingController/Login');
    }

    public function isloggedin() {
        if (isset($_SESSION['user_id'])) {
            return true;
        } else {
            return false;
        }
    }

    private function redirect($url) {
        header('Location: ' . URLROOT . '/' . $url);
        exit();
    }
}
?>