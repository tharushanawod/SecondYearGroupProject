<?php 

class SupplierController extends Controller {
    private $Product;

    public function __construct() {
        $this->Product = $this->model('Product');
    }

    public function index() {
        $this->productManagement();
    }

    public function dashboard() {
        $data = [];
        $this->view('Ingredient Supplier/Supplier Dashboard', $data);
    }

    public function landingPage() {
        $data = [];
        $this->view('Ingredient Supplier/landing page', $data);
    }

    public function productManagement() {
        $products = $this->Product->getProducts();
        $this->view('Ingredient Supplier/Product Management', ['products' => $products]);
    }

    public function add() {
        $this->view('Ingredient Supplier/Add Product');
    }

    public function save() {
        $data = [
            'product_name' => $_POST['product_name'],
            'category' => $_POST['category'],
            'price' => $_POST['price'],
            'stock' => $_POST['stock'],
            'description' => $_POST['description'],
            'image' => $_FILES['image']['name']
        ];
        move_uploaded_file($_FILES['image']['tmp_name'], 'path/to/upload/' . $_FILES['image']['name']);
        $this->Product->addProduct($data);

        // Redirect to the relevant category page
        switch ($_POST['category']) {
            case 'Fertilizer':
                header('Location: ' . URLROOT . '/SupplierController/fertilizer');
                break;
            case 'Seeds':
                header('Location: ' . URLROOT . '/SupplierController/seeds');
                break;
            case 'Pest Control':
                header('Location: ' . URLROOT . '/SupplierController/pestControl');
                break;
            default:
                header('Location: ' . URLROOT . '/SupplierController/productManagement');
                break;
        }
    }

    public function edit($product_id = null) {
        if ($product_id === null) {
            header('Location: ' . URLROOT . '/SupplierController/productManagement');
            exit();
        }
        $product = $this->Product->getProduct($product_id);
        $this->view('Ingredient Supplier/Edit Product', ['product' => $product]);
    }

    public function update() {
        $data = [
            'id' => $_POST['id'],
            'product_name' => $_POST['product_name'],
            'category' => $_POST['category'],
            'price' => $_POST['price'],
            'stock' => $_POST['stock'],
            'description' => $_POST['description'],
            'image' => $_FILES['image']['name']
        ];
        move_uploaded_file($_FILES['image']['tmp_name'], 'path/to/upload/' . $_FILES['image']['name']);
        $this->Product->updateProduct($data);

        // Redirect to the relevant category page
        switch ($_POST['category']) {
            case 'Fertilizer':
                header('Location: ' . URLROOT . '/SupplierController/fertilizer');
                break;
            case 'Seeds':
                header('Location: ' . URLROOT . '/SupplierController/seeds');
                break;
            case 'Pest Control':
                header('Location: ' . URLROOT . '/SupplierController/pestControl');
                break;
            default:
                header('Location: ' . URLROOT . '/SupplierController/productManagement');
                break;
        }
    }

    public function delete($product_id = null) {
        if ($product_id === null) {
            header('Location: ' . URLROOT . '/SupplierController/productManagement');
            exit();
        }
        $product = $this->Product->getProduct($product_id);
        $this->view('Ingredient Supplier/Delete Product', ['product' => $product]);
    }

    public function destroy() {
        $this->Product->deleteProduct($_POST['product_id']);
        header('Location: ' . URLROOT . '/SupplierController/productManagement');
    }

    public function shop() {
        $products = $this->Product->getProducts();
        $fertilizerProducts = $this->Product->getProductsByCategory('Fertilizer');
        $seedsProducts = $this->Product->getProductsByCategory('Seeds');
        $pestControlProducts = $this->Product->getProductsByCategory('Pest Control');
        $this->view('Ingredient Supplier/shop', [
            'products' => $products,
            'fertilizerProducts' => $fertilizerProducts,
            'seedsProducts' => $seedsProducts,
            'pestControlProducts' => $pestControlProducts
        ]);
    }

    public function fertilizer() {
        $products = $this->Product->getProductsByCategory('Fertilizer');
        $seedsProducts = $this->Product->getProductsByCategory('Seeds');
        $pestControlProducts = $this->Product->getProductsByCategory('Pest Control');
        $this->view('Ingredient Supplier/Fertilizer', [
            'products' => $products,
            'seedsProducts' => $seedsProducts,
            'pestControlProducts' => $pestControlProducts
        ]);
    }

    public function seeds() {
        $products = $this->Product->getProductsByCategory('Seeds');
        $fertilizerProducts = $this->Product->getProductsByCategory('Fertilizer');
        $pestControlProducts = $this->Product->getProductsByCategory('Pest Control');
        $this->view('Ingredient Supplier/Seeds', [
            'products' => $products,
            'fertilizerProducts' => $fertilizerProducts,
            'pestControlProducts' => $pestControlProducts
        ]);
    }

    public function pestControl() {
        $products = $this->Product->getProductsByCategory('Pest Control');
        $seedsProducts = $this->Product->getProductsByCategory('Seeds');
        $fertilizerProducts = $this->Product->getProductsByCategory('Fertilizer');
        $this->view('Ingredient Supplier/PestControl', [
            'products' => $products,
            'seedsProducts' => $seedsProducts,
            'fertilizerProducts' => $fertilizerProducts
        ]);
    }

    public function viewOrders() {
        $data = [];
        $this->view('Ingredient Supplier/Orders', $data);
    }

    public function requestHelp() {
        $data = [];
        $this->view('Ingredient Supplier/Contact us', $data);
    }

    public function payment() {
        $data = [];
        $this->view('Ingredient Supplier/Payment', $data);
    }

    public function viewCart() {
        $data = [];
        $this->view('Ingredient Supplier/View cart', $data);
    }

    public function checkout() {
        $data = [];
        $this->view('Ingredient Supplier/Checkout', $data);
    }

    public function checkoutConfirmation() {
        $data = [];
        $this->view('Ingredient Supplier/Checkout Confirmation', $data);
    }
}
?>