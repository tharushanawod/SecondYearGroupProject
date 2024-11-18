<?php 

class SupplierController extends Controller {
    private $pagesModel;

    public function __construct() {
        $this->pagesModel = $this->model('Supplier');
    }

    public function dashboard() {
        $data = [];
        $this->View('Ingredient Supplier/Supplier Dashboard', $data);
    }

    public function landingPage(){
        $data = [];
        $this->View('Ingredient Supplier/landing page', $data);
    }

    public function shop(){
        $data = [];
        $this->View('Ingredient Supplier/shop', $data);
    }

    public function fertilizer(){
        $data = $this->pagesModel->getProductsByCategory('Fertilizer');
        $this->View('Ingredient Supplier/Fertilizer', $data);
    }

    public function seeds(){
        $data = $this->pagesModel->getProductsByCategory('Seeds');
        $this->View('Ingredient Supplier/Seeds', $data);
    }

    public function pestControl(){
        $data = $this->pagesModel->getProductsByCategory('Pest Control');
        $this->View('Ingredient Supplier/PestControl', $data);
    }

    public function productManagement(){
        $data = [];
        $this->View('Ingredient Supplier/Add product', $data);
    }

    public function viewOrders(){
        $data = [];
        $this->View('Ingredient Supplier/Orders', $data);
    }

    public function requestHelp(){
        $data = [];
        $this->View('Ingredient Supplier/Contact us', $data);
    }

    public function payment(){
        $data = [];
        $this->View('Ingredient Supplier/Payment', $data);
    }

    public function viewCart(){
        $data = [];
        $this->View('Ingredient Supplier/View cart', $data);
    }

    public function checkout(){
        $data = [];
        $this->View('Ingredient Supplier/Checkout', $data);
    }

    public function checkoutConfirmation(){
        $data = [];
        $this->View('Ingredient Supplier/Checkout Confirmation', $data);
    }   

    public function productDetails($id) {
        $data = $this->pagesModel->getProductById($id);
        $this->View('Ingredient Supplier/Payment', $data);
    }

    public function updateProduct() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data = [
                'id' => trim($_POST['id']),
                'product_name' => trim($_POST['product_name']),
                'category' => trim($_POST['category']),
                'price' => trim($_POST['price']),
                'stock' => trim($_POST['stock']),
                'description' => trim($_POST['description']),
                'image' => trim($_POST['image'])
            ];

            if ($this->pagesModel->updateProductDetails($data)) {
                header('location: ' . URLROOT . '/SupplierController/productManagement');
            } else {
                die('Something went wrong');
            }
        }
    }

    public function deleteProduct($id) {
        if ($this->pagesModel->deleteProduct($id)) {
            header('location: ' . URLROOT . '/SupplierController/productManagement');
        } else {
            die('Something went wrong');
        }
    }
}
?>
