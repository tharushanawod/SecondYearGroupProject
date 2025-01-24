<?php 

class FarmerController extends Controller {
    
    private $farmerModel;

    public function __construct() {
        if (!$this->isloggedin()) {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            Redirect('LandingController/login');
        }
        $this->farmerModel = $this->model('Farmer');
    }

    public function isloggedin() {
        if (isset($_SESSION['user_id']) && ($_SESSION['user_role']=='farmer')){
            return true;
        } else {
            return false;
        }
    }

    public function Dashboard() {
        $data = [];
        $this->View('Farmer/FarmerDashboard', $data);
    }

    public function inventoryManagement() {
        $data = [];
        $this->View('Farmer/InventoryManagement', $data);

        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'product_name' => trim($_POST['product_name']),
                'category' => trim($_POST['category']),
                'price' => trim($_POST['price']),
                'stock' => trim($_POST['stock'])
            ];

            if($this->farmerModel->addProduct($data)) {
                header('location: ' . URLROOT . '/Farmer/inventoryManagement');
            } else {
                die('Something went wrong');
            }
        }        
    }

    public function orderManagement() {
        $data = [];
        $this->View('Farmer/OrdersManagement', $data);
    }

    public function hireWorkers() {
        $data = [];
        $this->View('Farmer/Hire Workers', $data);
    }

    public function workerManagement() {
       
        $data = $this->farmerModel->getFarmworkers();
        $this->View('Farmer/WorkerManagement', $data);
    }

    public function WorkerProfile($id) {
        $data = $this->farmerModel->getFarmworkerById($id);
       
        $this->View('Farmer/WorkerProfile', $data);

    }

     public function purchaseIngredients() {
        $data = [];
        $this->View('Farmer/Purchase Ingredients', $data);
    }

    public function requestHelp() {
        $data = [];
        $this->View('Farmer/Contact us', $data);
    }

    public function UpdateProducts($id) {
        echo $id;
       
        if ($_SESSION['user_role'] !== 'farmer') {
            Redirect('LandingController/index'); // Redirect if not authorized
        }
    
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $products = $this->farmerModel->getProductsByFarmerId($_SESSION['user_id']);
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
            $expiryPeriod = trim($_POST['expiry_period']);
            $expiryDate = new DateTime('now');
            $expiryDate->modify("+$expiryPeriod days");
            $formattedExpiryDate = $expiryDate->format('Y-m-d H:i:s');
    
            $data = [
                'id' => $id,
                'price' => trim($_POST['price']),
                'quantity' => trim($_POST['quantity']),
                'type' => trim($_POST['type']),
                'expiry_date' => $formattedExpiryDate,
                'media' => '',
                'price_err' => '',
                'quantity_err' => '',
                'type_err' => '',
                'product' => $products,
                'userid' => $_SESSION['user_id']
            ];
    
            // Validate fields
            if (empty($data['price'])) {
                $data['price_err'] = 'Please enter a price';
            }
    
            if (empty($data['quantity'])) {
                $data['quantity_err'] = 'Please enter quantity';
            }
    
            if (empty($data['expiry_date'])) {
                $data['expiry_err'] = 'Please select an expiry period';
            }
    
            // Validate and upload file
            if (isset($_FILES['media']) && $_FILES['media']['error'] == 0) {
                $targetDir = "uploads/Farmer/Products/";
                $fileName = basename($_FILES['media']['name']);
                $targetFilePath = $targetDir . $fileName;
    
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov', 'obj'];
    
                if (in_array(strtolower($fileType), $allowedTypes)) {
                    if (move_uploaded_file($_FILES['media']['tmp_name'], $targetFilePath)) {
                        $data['media'] = $targetFilePath;
                    } else {
                        $data['type_err'] = 'Failed to upload the file';
                    }
                } else {
                    $data['type_err'] = 'Invalid file type';
                }
            } else {
                $data['media'] = $products->media; // Keep existing media if no data file is uploaded
            }

            ini_set('display_errors', 1);
            ini_set('display_startup_errors', 1);
            error_reporting(E_ALL);
            
            
    
            // Check for no errors
            if (empty($data['price_err']) && empty($data['quantity_err']) && empty($data['type_err']) && empty($data['expiry_err'])) {
              
                
                if ($this->farmerModel->editProduct($data)) { // Call update function
                    Redirect('FarmerController/AddProduct'); // Redirect to products list
                    
                  
                } else {
                    die('Something went wrong');
                }
            } else {
                $data['show_popup'] = true; // Keep popup open on validation error
                $this->view('Farmer/AddProducts', $data); // Use edit product view
            }
        } 
        // else {

        //     $product = $this->farmerModel->getProducts($id);
        //     $products = $this->farmerModel->getProductsByFarmerId($_SESSION['user_id']);

        //     $data = [
        //         'id' => $product->id,
        //         'price' => $product->price,
        //         'quantity' => $product->quantity,
        //         'type' => $product->type,
        //         'media' => $product->media,
        //         'price_err' => '',
        //         'quantity_err' => '',
        //         'type_err' => '',
        //         'product' => $products,
        //         'show_popup' => true
        //     ];
        //     $this->view('Farmer/AddProducts', $data);
        // }
    }
    

    public function AddProduct() {
    
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $products = $this->farmerModel->getProductsByFarmerId($_SESSION['user_id']);
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            
            $data = [
                'price' => trim($_POST['price']),
                'quantity' => trim($_POST['quantity']),
                'closing_date' => trim($_POST['closing_date']),
                'media' => '',
                'type_err' => '',
                'products' => $products,
                'user_id' => $_SESSION['user_id']
            ];
    
           
    
            // Validate and upload file
            if (isset($_FILES['media']) && $_FILES['media']['error'] == 0) {
                $targetDir = "uploads/Farmer/Products/"; // Folder to store uploads
                $fileName = basename($_FILES['media']['name']);
                $targetFilePath = $targetDir . $fileName;
    
                $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
                $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'mp4', 'mov', 'obj'];
    
                if (in_array(strtolower($fileType), $allowedTypes)) {
                    // Move file to server
                    if (move_uploaded_file($_FILES['media']['tmp_name'], $targetFilePath)) {
                        $data['media'] = $targetFilePath;
                    } else {
                        $data['type_err'] = 'Failed to upload the file';
                    }
                } else {
                    $data['type_err'] = 'Invalid file type';
                }
            } else {
                $data['type_err'] = 'Please upload a media file';
            }
    
            // Check for no errors
            if (empty($data['type_err']) ) {
                if ($this->farmerModel->AddProduct($data)) {
                    Redirect('FarmerController/AddProduct');
                } else {
                    die('Something went wrong');
                }
            } else {
                $data['show_popup'] = true; // Keep popup open on validation error
                $this->view('Farmer/AddProducts', $data);
            }
        } else {

         
            $data = [
                'price' => '',
                'quantity' => '',
                'media' => '',
                'price_err' => '',
                'quantity_err' => '',
                'type_err' => '',
                'products' => $products,
                'show_popup' => false
                
            ];
            $this->view('Farmer/AddProducts', $data);
        }
    }
    

    public function DeleteProducts($id) {

        if ($this->farmerModel->deleteProduct($id)) {
            Redirect('FarmerController/AddProduct');
        } else {
            die('Something went wrong');
        }

    }

    public function getProductDetails($id) {
        $product = $this->farmerModel->getProducts($id);
        
        // Assuming $product is an associative array or object
        echo json_encode($product);
    }
    

    public function BuyIngredients() {
        $data = [];
        $this->View('Farmer/BuyIngredients', $data);
    }

    public function ManageProfile()
    {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'user_id' => $_SESSION['user_id'],
                'name' => trim($_POST['name']),
                'phone' => trim($_POST['phone']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'name_err' => '',
                'phone_err' => '',
                'address_err' => '',
                'email_err' => ''
            ];

            if(empty($data['name'])){
                $data['name_err'] = 'Please input a name';
            }

            if(empty($data['phone'])){
                $data['contact_err'] = 'Please input a contact number';
            }
           

            if(empty($data['email'])){
                $data['email_err'] = 'Please input an email';
            }

           
            

            if(empty($data['name_err']) && empty($data['phone_err'])  && empty($data['email_err'])){
                echo 'Profile Updated';
                if(!empty($data['password'])){
                    $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
                    }
                
                $result = $this->farmerModel->UpdateProfile($data);
              
                if($result){
                    // Redirect('BuyerController/ManageProfile');
                    Redirect('LandingController/logout');
                }
            }else{
                $this->view('Farmer/ManageProfile',$data);
            }
        
            }
            else{
                $user=$this->farmerModel->getUserById($_SESSION['user_id']);
                $data = [
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'password' => '',
                    'name_err' => '',
                    'phone_err' => '',
                    'email_err' => '',
                    'password_err' => ''
                ];
                $this->view('Farmer/ManageProfile',$data);
                
            }
    }

    // Get profile image URL
    public function getProfileImage($user_id) {
        $imagePath = $this->farmerModel->getProfileImage($_SESSION['user_id']);
        return $imagePath ? URLROOT .'/'.$imagePath : URLROOT . '/images/default.jpg';
    }

    public function uploadProfileImage() {

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $targetDir = "uploads/ProfilePictures/";
    $fileName = basename($_FILES["profile_picture"]["name"]);
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
        $uploadResult = $this->farmerModel->updateProfileImage($_SESSION['user_id'], $targetFile);
       Redirect('FarmerController/ManageProfile');
        // Update user's profile picture in the database here
    } else {
        echo "Error uploading file.";
    }
}
    }


    public function AddReview($farmworker_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'review_text' => trim($_POST['review_text']),
                'rating' => (int) $_POST['rating'],
                'worker_id' => $farmworker_id,
                'farmer_id' => $_SESSION['user_id'],
                'reviewText_err' => '',
                'rating_err' => ''
            ];
    
            // Validation
            if (empty($data['review_text'])) {
                $data['reviewText_err'] = 'Please enter a review';
            }
            if ($data['rating'] < 1 || $data['rating'] > 5) {
                $data['rating_err'] = 'Please select a rating between 1 and 5';
            }
            
    
            // If no errors, add the review
            if (empty($data['reviewText_err']) && empty($data['rating_err'])) {
                if ($this->farmerModel->AddReview($data)) {
                    Redirect('FarmerController/WorkerProfile/' . $farmworker_id);
                } else {
                    die('Something went wrong while saving the review.');
                }
            } else {
                // Reload the form with errors
                $this->view('Farmer/WorkerProfile', $data);
            }
        } else {
            $data = [];
            $this->view('Farmer/WorkerProfile', $data);
        }
    }
    
    public function fetchReviews($id) {
        $reviews = $this->farmerModel->fetchReviews($id);
        header('Content-Type: application/json');
        echo json_encode($reviews);
       
    }
    
    public function ViewCart() {
        $data = [];
        $this->View('Farmer/ViewCart', $data);
    }
    public function Checkout() {
        $data = [];
        $this->View('Farmer/Checkout', $data);
    }

    public function CheckoutConfirmation() {
        $data = [];
        $this->View('Farmer/CheckoutConfirmation', $data);
    }
    public function pay(){
        $data = [];
        $this->View('Farmer/pay', $data);
    }

    public function inventory() {
        $data = [];
        $this->View('Farmer/inventory', $data);
    }

}
?>

