<?php

class SupplierController extends Controller {
    private $Product;
    private $Supplier;
    
    public function __construct() {
        if (!$this->isloggedin()) {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            Redirect('LandingController/login');
        }
        $this->Product = $this->model('Product');
        $this->Supplier = $this->model('Supplier');
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
        $supplierId = $_SESSION['user_id'];
        $recentOrders = $this->Supplier->getRecentOrders($supplierId);
       
        
        $data = [
            'recentOrders' => $recentOrders
        ];
     
        
        $this->view('Ingredient Supplier/Supplier Dashboard', $data);
    }

    public function productManagement() {
        $supplierId = $_SESSION['user_id'];
        $products = $this->Product->getProducts($supplierId);
        $categories = $this->Supplier->getCategories();
        
        $data = [
            'products' => $products,
            'categories' => $categories
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
                'supplier_id' => $_SESSION['user_id'],
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
            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        } else {
            $image = $_POST['existing_image'];
        }

        $data = [
            'product_id' => $_POST['product_id'],  // Changed from 'id'
            'product_name' => $_POST['product_name'],
            'category_id' => $_POST['category_id'],
            'price' => $_POST['price'],
            'stock' => $_POST['stock'],
            'description' => $_POST['description'],
            'image' => $image,
            'supplier_id' => $_SESSION['user_id']
        ];

        $this->Product->updateProduct($data);
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
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['product_id'])) {
            $product_id = $_POST['product_id'];
            
            // Get product details before deletion
            $product = $this->Product->getProductById($product_id);
            
            if ($product) {
                // Delete the image file if it exists
                $image_path = 'uploads/' . $product->image;
                if (file_exists($image_path)) {
                    unlink($image_path);
                }
                
                // Delete the product from database
                if ($this->Product->deleteProduct($product_id)) {
                    // Set success message
                    $_SESSION['message'] = 'Product deleted successfully';
                    $_SESSION['message_type'] = 'success';
                } else {
                    $_SESSION['message'] = 'Failed to delete product';
                    $_SESSION['message_type'] = 'error';
                }
            }
        }
        header('Location: ' . URLROOT . '/SupplierController/productManagement');
        exit();
    }

    public function shop() {
        $supplier_id = $_SESSION['user_id'];
        $products = $this->Product->getProducts($supplier_id);
        $fertilizerProducts = $this->Product->getProductsByCategory('1', $supplier_id);
        $seedsProducts = $this->Product->getProductsByCategory('2', $supplier_id);
        $pestControlProducts = $this->Product->getProductsByCategory('3', $supplier_id);
        $this->view('Ingredient Supplier/shop', [
            'products' => $products,
            'fertilizerProducts' => $fertilizerProducts,
            'seedsProducts' => $seedsProducts,
            'pestControlProducts' => $pestControlProducts
        ]);
    }

    public function fertilizer() {
        $supplier_id = $_SESSION['user_id'];
        $products = $this->Product->getProductsByCategory('1', $supplier_id);
        $seedsProducts = $this->Product->getProductsByCategory('2', $supplier_id);
        $pestControlProducts = $this->Product->getProductsByCategory('3', $supplier_id);
        $this->view('Ingredient Supplier/Fertilizer', [
            'products' => $products,
            'seedsProducts' => $seedsProducts,
            'pestControlProducts' => $pestControlProducts
        ]);
    }

    public function seeds() {
        $supplier_id = $_SESSION['user_id'];
        $products = $this->Product->getProductsByCategory('2', $supplier_id);
        $fertilizerProducts = $this->Product->getProductsByCategory('1', $supplier_id);
        $pestControlProducts = $this->Product->getProductsByCategory('3', $supplier_id);
        $this->view('Ingredient Supplier/Seeds', [
            'products' => $products,
            'fertilizerProducts' => $fertilizerProducts,
            'pestControlProducts' => $pestControlProducts
        ]);
    }

    public function pestControl() {
        $supplier_id = $_SESSION['user_id'];
        $products = $this->Product->getProductsByCategory('3', $supplier_id);
        $seedsProducts = $this->Product->getProductsByCategory('2', $supplier_id);
        $fertilizerProducts = $this->Product->getProductsByCategory('1', $supplier_id);
        $this->view('Ingredient Supplier/PestControl', [
            'products' => $products,
            'seedsProducts' => $seedsProducts,
            'fertilizerProducts' => $fertilizerProducts
        ]);
    }

    public function viewOrders() {
        // $status = $_GET['status'] ?? 'all';
        // $supplierId = $_SESSION['user_id'];
        // if ($status === 'all') {
        //     $orders = $this->Supplier->getOrdersBySupplierId($supplierId);
        // } else {
        //     $orders = $this->Supplier->getOrdersByStatusAndSupplierId($status, $supplierId);
        // }
        // $data = ['orders' => $orders];
        $this->view('Ingredient Supplier/OrdersManagement');
    }

    public function acceptOrder($orderId) {
        if (!isset($orderId)) {
            $_SESSION['message'] = 'Invalid order ID';
            $_SESSION['message_type'] = 'error';
            Redirect('SupplierController/viewOrders');
            return;
        }
        
        $result = $this->Supplier->updateOrderStatus($orderId, 'accepted');
        
        if ($result) {
            $_SESSION['message'] = 'Order accepted successfully';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Failed to accept order';
            $_SESSION['message_type'] = 'error';
        }
        
        Redirect('SupplierController/viewOrders');
    }
    
    public function rejectOrder() {
        if (!isset($_POST['order_id']) || !isset($_POST['rejection_reason'])) {
            $_SESSION['message'] = 'Invalid request';
            $_SESSION['message_type'] = 'error';
            Redirect('SupplierController/viewOrders');
            return;
        }
        
        $orderId = $_POST['order_id'];
        $reason = trim($_POST['rejection_reason']);
        
        if (empty($reason)) {
            $_SESSION['message'] = 'Rejection reason is required';
            $_SESSION['message_type'] = 'error';
            Redirect('SupplierController/viewOrders');
            return;
        }
        
        $result = $this->Supplier->updateOrderStatus($orderId, 'rejected', $reason);
        
        if ($result) {
            $_SESSION['message'] = 'Order rejected successfully';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Failed to reject order';
            $_SESSION['message_type'] = 'error';
        }
        
        Redirect('SupplierController/viewOrders');
    }
    
    public function viewOrderDetails($orderId) {
        $order = $this->Supplier->getOrderById($orderId);
        echo json_encode($order);
    }

       public function manageProfile() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data = [
                'user_id' => $_SESSION['user_id'],
                'name' => trim($_POST['name']),
                'phone' => trim($_POST['phone']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'name_err' => '',
                'phone_err' => '',
                'email_err' => ''
            ];

            if (empty($data['name'])) {
                $data['name_err'] = 'Please input a name';
            }

            if (empty($data['phone'])) {
                $data['phone_err'] = 'Please input a contact number';
            }

            if (empty($data['email'])) {
                $data['email_err'] = 'Please input an email';
            }

            if (empty($data['name_err']) && empty($data['phone_err']) && empty($data['email_err'])) {
                if (!empty($data['password'])) {
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                }

                $result = $this->Supplier->updateProfile($data);

                if ($result) {
                    Redirect('SupplierController/ManageProfile');
                }
            } else {
                $this->view('Ingredient Supplier/ManageProfile', $data);
            }
        } else {
            $user = $this->Supplier->getUserById($_SESSION['user_id']);
            $_SESSION['user_name'] = $user->name;
            $_SESSION['user_email'] = $user->email;
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
            $this->view('Ingredient Supplier/ManageProfile', $data);
        }
    }

    public function getProfileImage($user_id) {
        $imagePath = $this->Supplier->getProfileImage($_SESSION['user_id']);
        return $imagePath ? URLROOT . '/' . $imagePath : URLROOT . '/images/default.jpg';
    }

    public function uploadProfileImage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
            $targetDir = "uploads/ProfilePictures/";
            $fileName = basename($_FILES["profile_picture"]["name"]);
            $targetFile = $targetDir . $fileName;

            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
                $uploadResult = $this->Supplier->updateProfileImage($_SESSION['user_id'], $targetFile);
                Redirect('SupplierController/manageProfile');
            } else {
                echo "Error uploading file.";
            }
        }
    }

public function notifications() {
    $supplierId = $_SESSION['user_id'];
    $notifications = $this->model('Notification')->getNotificationsByUserId($supplierId);
    $this->view('Ingredient Supplier/Notifications', ['notifications' => $notifications]);
}

public function addRating() {
    if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
        redirect('pages/error');
    }

    $data = [
        'supplier_id' => trim($_POST['supplier_id']),
        'farmer_id' => $_SESSION['user_id'],
        'rating' => trim($_POST['rating']),
        'review' => trim($_POST['review'])
    ];

    if ($this->Supplier->addRating($data)) {
        $_SESSION['message'] = 'Thank you for your review!';
        $_SESSION['message_type'] = 'success';
    } else {
        $_SESSION['message'] = 'Unable to submit review';
        $_SESSION['message_type'] = 'error';
    }

    redirect('CartController/viewDetails/' . $data['supplier_id']);
}

public function getRatings($supplier_id) {
    $reviews = $this->Supplier->getSupplierRatings($supplier_id);
    $averageRating = $this->Supplier->getAverageRating($supplier_id);
    
    return [
        'reviews' => $reviews,
        'averageRating' => $averageRating->avg_rating,
        'totalRatings' => count($reviews)
    ];
}

public function fetchReviews($supplier_id) {
    $reviews = $this->Supplier->getSupplierRatings($supplier_id);
    header('Content-Type: application/json');
    echo json_encode($reviews);
}

public function viewReviews($supplier_id) {
    $reviews = $this->Supplier->getSupplierRatings($supplier_id);
    $averageRating = $this->Supplier->getAverageRating($supplier_id);
    
    $data = [
        'reviews' => $reviews,
        'averageRating' => $averageRating->avg_rating,
        'totalRatings' => count($reviews)
    ];
    
    $this->view('Ingredient Supplier/Reviews', $data);
}

public function RequestHelp() {
    $data = [];
    $this->View('Ingredient Supplier/RequestHelp', $data);
}

public function showForm($category) {
    $data = ['category' => $category];
    $this->View('Ingredient Supplier/RequestHelp', $data);
}

public function submitRequest() {
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
        $data = [
            'user_id' => $_SESSION['user_id'],
            'user_role' => $_SESSION['user_role'],
            'category' => trim($_POST['category']),
            'subject' => trim($_POST['subject']),
            'description' => trim($_POST['description']),
            'attachment' => null,
            'status' => 'pending',
            'created_at' => date('Y-m-d H:i:s')
        ];

        // Handle file upload
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/help_requests/'; 
            if (!file_exists($uploadDir)) {
                mkdir($uploadDir, 0777, true);
            }
            $attachmentName = basename($_FILES['attachment']['name']);
            $uploadFile = $uploadDir . $attachmentName;
            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadFile)) {
                $data['attachment'] = $uploadFile;
            } else {
                error_log("Failed to upload attachment: " . $attachmentName);
            }
        }

        // Save to database
        if ($this->Supplier->saveHelpRequest($data)) {
            $_SESSION['request_success'] = 'Your request has been submitted successfully!';
            Redirect('SupplierController/RequestHelp');
        } else {
            error_log("Failed to save help request: " . json_encode($data));
            $_SESSION['request_error'] = 'Failed to submit your request. Please try again.';
            Redirect('SupplierController/RequestHelp');
        }
    }
}

public function getAllOrders($userId) {
    $orders = $this->Supplier->getAllOrders($userId);
    header('Content-Type: application/json');
    echo json_encode($orders);

}

public function getOrderDetails($orderId) {
    $orderDetails = $this->Supplier->getOrderDetails($orderId);
    header('Content-Type: application/json');
    echo json_encode($orderDetails);
}

public function getBuyerDetails($orderId) {
    $buyerDetails = $this->Supplier->getBuyerDetails($orderId);
    header('Content-Type: application/json');
    echo json_encode($buyerDetails);

}

public function getDeliveryConfirmationStatus($orderId) {
    $status = $this->Supplier->getDeliveryConfirmationStatus($orderId);
    header('Content-Type: application/json');
    echo json_encode($status);
}

public function sendDeliveryCode($orderId) {

  
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
        $data = [
            'orderId' => $orderId,
            'deliveryCompany' => trim($_POST['deliveryCompany']),
            'trackingNumber' => trim($_POST['trackingNumber']),
        ];



            $result = $this->Supplier->sendDeliveryCode($data);

            if ($result) {
                Redirect('SupplierController/viewOrders');
            }
        } 
    else {
    
        $data = [
            'orderId' => $orderId
            
        ];
        $this->view('Ingredient Supplier/DeliveryCode', $data);
    }



}



        public function Wallet(){
            $data=$this->Supplier->getWalletDetails($_SESSION['user_id']);
            $this->View('Ingredient Supplier/Wallet',$data);
        }

}
?>