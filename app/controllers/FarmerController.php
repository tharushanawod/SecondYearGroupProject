<?php 

class FarmerController extends Controller {
    private $farmerModel;

    public function __construct() {
        $this->farmerModel = $this->model('Farmer');
    }

    public function dashboard() {
        $data = [];
        $this->View('Farmer/Farmer Dashboard', $data);
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
        $this->View('Farmer/Orders Management', $data);
    }

    public function hireWorkers() {
        $data = [];
        $this->View('Farmer/Hire Workers', $data);
    }

    public function workerManagement() {
        $data = [];
        $this->View('Farmer/Worker Management', $data);
    }

     public function purchaseIngredients() {
        $data = [];
        $this->View('Farmer/Purchase Ingredients', $data);
    }

    public function requestHelp() {
        $data = [];
        $this->View('Farmer/Contact us', $data);
    }

}
?>

