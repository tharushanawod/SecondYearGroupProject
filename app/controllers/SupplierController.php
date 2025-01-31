<?php

class SupplierController extends Controller {
    private $Product;
    private $supplierModel;

    public function __construct() {
        if (!$this->isloggedin()) {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            Redirect('LandingController/login');
        }
        $this->Product = $this->model('Product');
        $this->supplierModel = $this->model('Supplier');
    }

    public function isloggedin() {
        if (isset($_SESSION['user_id']) && ($_SESSION['user_role'] == 'supplier')) {
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

    public function productManagement() {
        $supplier = $this->supplierModel;
        $data = [
            'products' => $supplier->getProducts(),
            'categories' => $supplier->getCategories()
        ];
        $this->view('Ingredient Supplier/ProductManagement', $data);
    }

    public function add() {
        if ($_SESSION['user_role'] !== 'supplier') {
            header('Location: ' . URLROOT . '/SupplierController/productManagement');
            exit();
        }
        $this->view('Ingredient Supplier/Add Product');
    }

    public function save() {
        $image = $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);

        // Move the uploaded file to the target directory
        if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
            $data = [
                'product_name' => $_POST['product_name'],
                'category_id' => $_POST['category_id'],
                'supplier_id' => $_SESSION['supplier_id'],
                'price' => $_POST['price'],
                'stock' => $_POST['stock'],
                'description' => $_POST['description'],
                'image' => $image
            ];
            $this->Product->addProduct($data);

            // Redirect to the product management page
            header('Location: ' . URLROOT . '/SupplierController/productManagement');
        } else {
            // Handle the error
            echo "Sorry, there was an error uploading your file.";
        }
    }

    public function edit($product_id = null) {
        if ($product_id === null) {
            header('Location: ' . URLROOT . '/SupplierController/productManagement');
            exit();
        }
        $product = $this->Product->getProductById($product_id);
        $categoryModel = $this->model('Category');
        $categories = $categoryModel->getCategories();
        $this->view('Ingredient Supplier/Edit Product', ['product' => $product, 'categories' => $categories]);
    }

    public function update() {
        $image = $_FILES['image']['name'];
        $target_dir = "uploads/";
        $target_file = $target_dir . basename($image);

        if (!empty($image)) {
            // Move the uploaded file to the target directory
            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        } else {
            $image = $_POST['existing_image'];
        }

        $data = [
            'id' => $_POST['id'],
            'product_name' => $_POST['product_name'],
            'category_id' => $_POST['category_id'],
            'price' => $_POST['price'],
            'stock' => $_POST['stock'],
            'description' => $_POST['description'],
            'image' => $image
        ];

        $this->Product->updateProduct($data);

        // Redirect to the product management page
        header('Location: ' . URLROOT . '/SupplierController/productManagement');
    }

    public function delete($product_id = null) {
        if ($product_id === null) {
            header('Location: ' . URLROOT . '/SupplierController/productManagement');
            exit();
        }
        $product = $this->Product->getProductById($product_id);
        $this->view('Ingredient Supplier/Delete Product', ['product' => $product]);
    }

    public function destroy() {
        // Get the product ID from the POST request
        $product_id = $_POST['product_id'];

        // Fetch the product details from the database
        $product = $this->Product->getProductById($product_id);

        // Check if the product exists
        if ($product) {
            // Delete the product image from the server
            if (file_exists('uploads/' . $product->image)) {
                unlink('uploads/' . $product->image);
            }

            // Delete the product from the database
            $this->Product->deleteProduct($product_id);

            // Redirect to the product management page
            header('Location: ' . URLROOT . '/SupplierController/productManagement');
        } else {
            // Handle the case where the product does not exist
            echo "Product not found.";
        }
    }

    public function shop() {
        $products = $this->Product->getProducts();
        $fertilizerProducts = $this->Product->getProductsByCategory('1') ?? [];
        $seedsProducts = $this->Product->getProductsByCategory('2') ?? [];
        $pestControlProducts = $this->Product->getProductsByCategory('3') ?? [];
        $this->view('Ingredient Supplier/shop', [
            'products' => $products,
            'fertilizerProducts' => $fertilizerProducts,
            'seedsProducts' => $seedsProducts,
            'pestControlProducts' => $pestControlProducts
        ]);
    }

    public function fertilizer() {
        $products = $this->Product->getProductsByCategory('1');
        $seedsProducts = $this->Product->getProductsByCategory('2');
        $pestControlProducts = $this->Product->getProductsByCategory('3');
        $this->view('Ingredient Supplier/Fertilizer', [
            'products' => $products,
            'seedsProducts' => $seedsProducts,
            'pestControlProducts' => $pestControlProducts
        ]);
    }

    public function seeds() {
        $products = $this->Product->getProductsByCategory('2');
        $fertilizerProducts = $this->Product->getProductsByCategory('1');
        $pestControlProducts = $this->Product->getProductsByCategory('3');
        $this->view('Ingredient Supplier/Seeds', [
            'products' => $products,
            'fertilizerProducts' => $fertilizerProducts,
            'pestControlProducts' => $pestControlProducts
        ]);
    }

    public function pestControl() {
        $products = $this->Product->getProductsByCategory('3');
        $seedsProducts = $this->Product->getProductsByCategory('2');
        $fertilizerProducts = $this->Product->getProductsByCategory('1');
        $this->view('Ingredient Supplier/PestControl', [
            'products' => $products,
            'seedsProducts' => $seedsProducts,
            'fertilizerProducts' => $fertilizerProducts
        ]);
    }

    public function viewOrders() {
        $supplierId = $_SESSION['user_id']; // Assuming supplier ID is stored in session
        $orders = $this->supplierModel->getOrdersBySupplierId($supplierId);

        // Debugging: Log the fetched orders
        error_log(print_r($orders, true));

        $data = ['orders' => $orders];
        $this->view('Ingredient Supplier/Orders', $data);
    }

    public function RequestHelp() {
        $data = [];
        $this->view('Ingredient Supplier/RequestHelp', $data);
    }

    public function manageProfile() {
        $data = [];
        $this->view('Ingredient Supplier/ManageProfile', $data);
    }
}
?>