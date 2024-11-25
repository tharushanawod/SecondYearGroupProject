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
        $data = [];
        $this->View('Farmer/WorkerManagement', $data);
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
                $data['media'] = $products->media; // Keep existing media if no new file is uploaded
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
        } else {

            $product = $this->farmerModel->getProducts($id);
            $products = $this->farmerModel->getProductsByFarmerId($_SESSION['user_id']);

            $data = [
                'id' => $product->id,
                'price' => $product->price,
                'quantity' => $product->quantity,
                'type' => $product->type,
                'media' => $product->media,
                'price_err' => '',
                'quantity_err' => '',
                'type_err' => '',
                'product' => $products,
                'show_popup' => true
            ];
            $this->view('Farmer/AddProducts', $data);
        }
    }
    

    public function AddProduct() {
    
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $products = $this->farmerModel->getProductsByFarmerId($_SESSION['user_id']);
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {

            $expiryPeriod = trim($_POST['expiry_period']);

            // Calculate the expiry date by adding the selected period to the current date
            $expiryDate = new DateTime('now');
            $expiryDate->modify("+$expiryPeriod days"); // Add the selected days to today's date
            $formattedExpiryDate = $expiryDate->format('Y-m-d H:i:s');

            $data = [
                'price' => trim($_POST['price']),
                'quantity' => trim($_POST['quantity']),
                'type' => trim($_POST['type']),
                'expiry_date' => $formattedExpiryDate,
                'media' => '',
                'price_err' => '',
                'quantity_err' => '',
                'type_err' => '',
                'products' => $products,
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
            if (empty($data['price_err']) && empty($data['quantity_err']) && empty($data['type_err']) && empty($data['expiry_err'])) {
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
                'type' => '',
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

    public function ManageProfile() {
        $data = [];
        $this->View('Farmer/ManageProfile', $data);
    }

}
?>

