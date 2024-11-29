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
        $this->Product = $this->model('Product');
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

    public function productManagement() {
        $products = $this->Product->getProducts();
        $this->view('Ingredient Supplier/Product Management', ['products' => $products]);
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
                'category' => $_POST['category'],
                'price' => $_POST['price'],
                'stock' => $_POST['stock'],
                'description' => $_POST['description'],
                'image' => $image
            ];
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
        $product = $this->Product->getProduct($product_id);
        $this->view('Ingredient Supplier/Edit Product', ['product' => $product]);
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
            'category' => $_POST['category'],
            'price' => $_POST['price'],
            'stock' => $_POST['stock'],
            'description' => $_POST['description'],
            'image' => $image
        ];

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
        // Get the product ID from the POST request
        $product_id = $_POST['product_id'];
    
        // Fetch the product details from the database
        $product = $this->Product->getProduct($product_id);
    
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
        $fertilizerProducts = $this->Product->getProductsByCategory('Fertilizer') ?? [];
        $seedsProducts = $this->Product->getProductsByCategory('Seeds') ?? [];
        $pestControlProducts = $this->Product->getProductsByCategory('Pest Control') ?? [];
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