<?php 

class FarmerController extends Controller {
    private $farmerModel;

    public function __construct() {
        $this->farmerModel = $this->model('Farmer');
    }

    public function dashboard() {
        $data = [];
        $this->View('Farmer/FarmerDashboard', $data);
    }

    public function inventoryManagement() {
        $data = [];
        $this->View('Farmer/Inventory Management', $data);

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
    public function AddProduct() {
            if ($_SESSION['user_role'] !== 'farmer') {
                Redirect('LandingController/index'); // Redirect to user home if not admin
            }
            
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $products = $this->farmerModel->getProductsByFarmerId($_SESSION['user_id']); 
    
            if($_SERVER['REQUEST_METHOD'] == 'POST')
            {    
           
    
                $data = [
                    'price' => trim($_POST['price']),
                    'quantity' => trim($_POST['quantity']),
                    'type' => trim($_POST['type']),
                    'price_err' => '',
                    'quantity_err' => '',
                    'type_err' => '',
                    'products' => $products,
                    'userid' =>$_SESSION['user_id']
                ];
    
                if(empty($data['price'])){
                    $data['price_err'] = 'Please enter a price';
                }
    
                if(empty($data['quantity'])){
                    $data['quantity_err'] = 'Please enter qunatity';
                }
               
                if (empty($data['price_err']) && empty($data['quantity_err'])) {
                    if ($this->farmerModel->AddProduct($data)) {
                        Redirect('FarmerController/AddProduct');
                    } else {
                        die('Something went wrong');
                    }
                } else {
                    // Set the popup flag to true if there are validation errors
                    $data['show_popup'] = true;
                    $this->view('Farmer/AddProducts', $data); // Adjust 'AddProducts' to your actual view name
                }
                
    
    
            }
    
            else{
                $data = [
                    'price' => '',
                    'quantity' => '',
                    'type' => '',
                    'price_err' => '',
                    'quantity_err' => '',
                    'type_err' => '',
                    'products' => $products,
                    'show_popup' => false // Popup is hidden initially
                ];
                $this->view('Farmer/AddProducts', $data);
                
    
            }
    
           
        
    }

    public function DeleteProducts($id) {
        if ($_SESSION['user_role'] !== 'farmer') {
            Redirect('LandingController/index'); // Redirect to user home if not admin
        }
        if ($this->farmerModel->deleteProduct($id)) {
            Redirect('FarmerController/AddProduct');
        } else {
            die('Something went wrong');
        }

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

