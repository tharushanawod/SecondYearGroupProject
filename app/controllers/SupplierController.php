<?php 

class SupplierController extends Controller {
    private $Product;

    public function __construct() {
        if (!$this->isloggedin()) {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            Redirect('LandingController/login');
        }
        $this->Product = $this->model('Supplier');
    }

    public function isloggedin() {
        if (isset($_SESSION['user_id']) && ($_SESSION['user_role']=='supplier')){
            return true;
        } else {
            return false;
        }
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
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'product_name' => trim($_POST['product_name']),
            'category' => trim($_POST['category']),
            'price' => trim($_POST['price']),
            'stock' => trim($_POST['stock']),
            'description' => trim($_POST['description']),
            'image' => ''
        ];

        // Validate fields
        if (empty($data['product_name'])) {
            $data['product_name_err'] = 'Please enter a product name';
        }

        if (empty($data['price'])) {
            $data['price_err'] = 'Please enter a price';
        }

        if (empty($data['stock'])) {
            $data['stock_err'] = 'Please enter stock quantity';
        }

        // Validate and upload file
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $targetDir = "uploads/Supplier/Products/";
            $fileName = basename($_FILES['image']['name']);
            $targetFilePath = $targetDir . $fileName;

            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array(strtolower($fileType), $allowedTypes)) {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    $data['image'] = $targetFilePath;
                } else {
                    $data['image_err'] = 'Failed to upload the file';
                }
            } else {
                $data['image_err'] = 'Invalid file type';
            }
        } else {
            $data['image_err'] = 'Please upload an image file';
        }

        // Check for no errors
        if (empty($data['product_name_err']) && empty($data['price_err']) && empty($data['stock_err']) && empty($data['image_err'])) {
            if ($this->Product->addProduct($data)) {
                Redirect('SupplierController/productManagement');
            } else {
                die('Something went wrong');
            }
        } else {
            $data['show_popup'] = true; // Keep popup open on validation error
            $this->view('Ingredient Supplier/Add Product', $data);
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
        if ($_SESSION['user_role'] !== 'supplier') {
            Redirect('LandingController/index'); // Redirect if not authorized
        }

        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

        $data = [
            'id' => trim($_POST['id']),
            'product_name' => trim($_POST['product_name']),
            'category' => trim($_POST['category']),
            'price' => trim($_POST['price']),
            'stock' => trim($_POST['stock']),
            'description' => trim($_POST['description']),
            'image' => ''
        ];

        // Validate fields
        if (empty($data['product_name'])) {
            $data['product_name_err'] = 'Please enter a product name';
        }

        if (empty($data['price'])) {
            $data['price_err'] = 'Please enter a price';
        }

        if (empty($data['stock'])) {
            $data['stock_err'] = 'Please enter stock quantity';
        }

        // Validate and upload file
        if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
            $targetDir = "uploads/Supplier/Products/";
            $fileName = basename($_FILES['image']['name']);
            $targetFilePath = $targetDir . $fileName;

            $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);
            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

            if (in_array(strtolower($fileType), $allowedTypes)) {
                if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                    $data['image'] = $targetFilePath;
                } else {
                    $data['image_err'] = 'Failed to upload the file';
                }
            } else {
                $data['image_err'] = 'Invalid file type';
            }
        } else {
            $data['image'] = $this->Product->getProduct($data['id'])->image; // Keep existing image if no new file is uploaded
        }

        // Check for no errors
        if (empty($data['product_name_err']) && empty($data['price_err']) && empty($data['stock_err']) && empty($data['image_err'])) {
            if ($this->Product->updateProduct($data)) {
                Redirect('SupplierController/productManagement');
            } else {
                die('Something went wrong');
            }
        } else {
            $data['show_popup'] = true; // Keep popup open on validation error
            $this->view('Ingredient Supplier/Edit Product', $data);
        }
    }

    public function delete($product_id = null) {
        if ($_SESSION['user_role'] !== 'supplier') {
            Redirect('LandingController/index'); // Redirect if not authorized
        }
        $product = $this->Product->getProduct($product_id);
        $this->view('Ingredient Supplier/Delete Product', ['product' => $product]);
    }

    public function destroy() {
        $this->Product->deleteProduct($_POST['product_id']);
        header('Location: ' . URLROOT . '/SupplierController/productManagement');
    }

    public function getProductDetails($id) {
        $product = $this->Product->getProduct($id);
        echo json_encode($product);
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