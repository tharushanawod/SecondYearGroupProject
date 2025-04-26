<?php 

class FarmerController extends Controller {
    
    private $farmerModel;
    private $cartModel;
    private $NotificationModel;
    private $Supplier;

    public function __construct() {

        $currentMethod = $this->getCurrentMethodFromURL();

        if (!$this->isloggedin()) {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            Redirect('LandingController/login');
        }
        else{
            $this->farmerModel = $this->model('Farmer');
            $this->cartModel = $this->model('Cart');
            $this->NotificationModel = $this->model('Notification');
            $this->Supplier = $this->model('Supplier');

             // User is logged in, now check if they are restricted
             $user_id = $_SESSION['user_id'];
             $user = $this->farmerModel->getUserStatus($user_id);  // Fetch user status from the database
 
             // If the user is restricted, prevent access to any page except "Manage Profile"
             if ($user->user_status === 'restricted') {
                 if ($currentMethod !== 'ManageProfile' && $currentMethod !== 'Resetricted') {
                     Redirect('FarmerController/Resetricted/' . $user_id);
                 }
             }
        }
      
    }

    public function isloggedin() {
        if (isset($_SESSION['user_id']) && ($_SESSION['user_role']=='farmer')){
            return true;
        } else {
            return false;
        }
    }

    private function getCurrentMethodFromURL() {
        // Parse the URL
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            // The second segment of the URL is the method name
            return $url[1] ?? null;
        }
        return null;
    }

    public function Resetricted($user_id){
        $data = $this->farmerModel->getrestrictedDetails($user_id);
        $this->View('inc/Restricted', $data);
    }

    public function Dashboard() {
    
        $recent_orders=$this->farmerModel->getRecentOrders($_SESSION['user_id']);
        $total_orders=$this->farmerModel->getTotalOrders($_SESSION['user_id']);
        $total_earnings=$this->farmerModel->getTotalEarnings($_SESSION['user_id']);
        $active_products=$this->farmerModel->getActiveProducts($_SESSION['user_id']);
        $latest_bid=$this->farmerModel->getLatestBid($_SESSION['user_id']);
        $data = [
            'user_name' => $_SESSION['user_name'],
            'recent_orders' => $recent_orders,
            'total_orders' => $total_orders,
            'total_earnings' => $total_earnings,
            'active_products' => $active_products,
            'bid_amount' => $latest_bid->bid_amount,
            'qunatity' => $latest_bid->quantity,
        ];
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

    public function getAllOrders($farmer_id) {
        $orders = $this->farmerModel->getAllOrders($farmer_id);
        
        // Send all orders to the frontend
        echo json_encode($orders);
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

    public function ViewPendingJobRequests() {
        $data = [];
        $this->View('Farmer/PendingRequests', $data);
    }

    public function getPendingJobRequests() {
        $data = $this->farmerModel->getPendingJobRequests($_SESSION['user_id']);

        echo json_encode($data);

    }

     public function purchaseIngredients() {
        $data = [];
        $this->View('Farmer/Purchase Ingredients', $data);
    }

    public function UpdateProducts($id) {
    
        $product = $this->farmerModel->getCornProductDetails($id);
      
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
    
            // $expiryPeriod = trim($_POST['closing_date']); // Example: "2025-03-10T14:30"
            // $expiryDate = new DateTime($expiryPeriod); 
            // $formattedExpiryDate = $expiryDate->format('Y-m-d H:i:s'); // Convert to SQL format

    
            $data = [
                'id' => $id,
                'starting_price' => trim($_POST['price']),
                'quantity' => trim($_POST['quantity']),
                'closing_date' => trim($_POST['closing_date']),
                'media' => '',
                'price_err' => '',
                'quantity_err' => '',
                'expiry_err' => '',
                'product' => $product,
                'userid' => $_SESSION['user_id']
            ];
           
    
            // Validate fields
            if (empty($data['starting_price'])) {
                $data['price_err'] = 'Please enter a price';
            }
    
            if (empty($data['quantity'])) {
                $data['quantity_err'] = 'Please enter quantity';
            }
    
            if (empty($data['closing_date'])) {
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
                $data['media'] = $product->media; // Keep existing media if no data file is uploaded
            }

            // ini_set('display_errors', 1);
            // ini_set('display_startup_errors', 1);
            // error_reporting(E_ALL);
            
    
            // Check for no errors
            if (empty($data['price_err']) && empty($data['quantity_err'])  && empty($data['expiry_err'])) {
              
                var_dump($data);
                if ($this->farmerModel->UpdateCornProducts($data)) {
                    
                     // Call update function
                    Redirect('FarmerController/AddProduct'); // Redirect to products list
                  
                } else {
                    die('Something went wrong');
                }
            } else {
                $data['show_popup'] = true; // Keep popup open on validation error
                $this->view('Farmer/AddProducts', $data); // Use edit product view
            }
        } 
        else {

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

    
    public function GetIdea() {
        $prices = $this->farmerModel->getManufacturerPrices();
        $data = [
            'prices' => $prices
        ];
        $this->view('Farmer/GetIdea', $data);
    }
    

    public function AddProduct() {
      
        $products = $this->farmerModel->getProductsByFarmerId($_SESSION['user_id']);
       
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);

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
        $product = $this->farmerModel->getCornProductDetails($id);
        
        // Assuming $product is an associative array or object
        echo json_encode($product);
    }
    

    public function BuyIngredients() {
        $products = $this->farmerModel->getSupplierProducts();
        $data = ['products' => $products];
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
                    Redirect('FarmerController/ManageProfile');
                }
            }else{
                $this->view('Farmer/ManageProfile',$data);
            }
        
            }
            else{
                $user=$this->farmerModel->getUserById($_SESSION['user_id']);
                $_SESSION['user_name'] = $user->name;
                $_SESSION['user_email'] = $user->email;
                $data = [
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'address' => $user->address,
                    'district' => $user->district,
                    'password' => '',
                    'name_err' => '',
                    'phone_err' => '',
                    'email_err' => '',
                    'password_err' => '',
                    'address_err' => '',
                    'district_err' => ''
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

    public function HireWorker($workerid){
        // Get the worker's confirmed job dates from model
        $confirmedDates = $this->farmerModel->getWorkerConfirmedDates($workerid);
        
        $data = [
            'workerid' => $workerid,
            'confirmedDates' => $confirmedDates
        ];
    
        $this->view('Farmer/HireWorker', $data);
    }

    public function HireWorkerConfirmation($workerid){
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_SPECIAL_CHARS);
            $data = [
                'farmerid' => $_SESSION['user_id'],
                'workerid' => $workerid,
                'job_type' => trim($_POST['job_type']),
                'work_duration' => trim($_POST['work_duration']),
                'start_date' => trim($_POST['start_date']),
                'end_date' => trim($_POST['end_date']),
                'skills' => isset($_POST['skills']) ? $_POST['skills'] : [],
                'location' => trim($_POST['location']),
                'accommodation' => trim($_POST['accommodation']),
                'food' => trim($_POST['food']),
                'job_type_err' => '',
                'work_duration_err' => '',
                'start_date_err' => '',
                'end_date_err' => '',
                'location_err' => '',
                'accommodation_err' => '',
                'food_err' => ''
            ];

            // Check for no errors
            if (empty($data['job_type_err']) && empty($data['work_duration_err']) && empty($data['start_date_err']) && empty($data['end_date_err']) && empty($data['location_err']) && empty($data['accommodation_err']) && empty($data['food_err'])) {
                if ($this->farmerModel->HireWorker($data)) {
                    Redirect('FarmerController/workerManagement');
                } else {
                    die('Something went wrong');
                }
            } else {
                var_dump($data);
                
            // Validate fields
            if (empty($data['job_type'])) {
                $data['job_type_err'] = 'Please select a job type';
            }
            if (empty($data['work_duration'])) {
                $data['work_duration_err'] = 'Please select work duration';
            }
            if (empty($data['start_date'])) {
                $data['start_date_err'] = 'Please select a start date';
            }
            if (empty($data['end_date'])) {
                $data['end_date_err'] = 'Please select an end date';
            }
            if (empty($data['location'])) {
                $data['location_err'] = 'Please enter a location';
            }
            if (empty($data['accommodation'])) {
                $data['accommodation_err'] = 'Please select accommodation option';
            }
            if (empty($data['food'])) {
                $data['food_err'] = 'Please select food option';
            }


                $this->view('Farmer/HireWorker', $data);
            }
        }

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

    public function ToReceive() {
        $orders = $this->farmerModel->getToReceiveOrders($_SESSION['user_id']);
        $data = [
            'orders' => $orders
        ];
        $this->view('Farmer/ToReceive', $data);
      
    }

    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize POST data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);

            $data = [
                'product_id' => trim($_POST['product_id']),
                'quantity' => trim($_POST['quantity']),
                'user_id' => $_SESSION['user_id']
            ];

            if ($this->cartModel->addCartItem($data)) {
                redirect('FarmerController/viewCart');
            } else {
                die('Something went wrong');
            }
        } else {
            redirect('FarmerController/buyIngredients');
        }
    }

    public function viewCart() {
        $customer_id = $_SESSION['user_id'];
        $cartItems = $this->cartModel->getCartItems($customer_id);
        $subTotal = $this->cartModel->calculateSubTotal($cartItems);
        $total = $subTotal; // Add any additional calculations if needed

        $data = [
            'cartItems' => $cartItems,
            'subTotal' => $subTotal,
            'total' => $total
        ];

        $this->view('Farmer/CartItems', $data);
    }

    public function updateCartItem() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cart_item_id = $_POST['id'];
            $quantity = $_POST['quantity'];
            
            if ($this->cartModel->updateCartItem($cart_item_id, $quantity)) {
                header('Location: ' . URLROOT . '/FarmerController/viewCart');
            } else {
                die('Something went wrong while updating the cart item.');
            }
        }
    }

    public function removeCartItem($id) {
        if ($this->cartModel->removeCartItem($id)) {
            header('Location: ' . URLROOT . '/FarmerController/viewCart');
        } else {
            die('Something went wrong while removing the cart item.');
        }
    }

    public function clearCart() {
        $customer_id = $_SESSION['user_id'];
        if ($this->cartModel->clearCart($customer_id)) {
            header('Location: ' . URLROOT . '/FarmerController/viewCart');
        } else {
            die('Something went wrong while clearing the cart.');
        }
    }

    public function viewDetails($id){
        $product = $this->farmerModel->getProducts($id);
        $relatedProducts = $this->farmerModel->getRelatedProducts($product->category_id, $product->product_id);
        $data = [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ];
        $this->view('Farmer/ViewDetails', $data);
    }

    
    public function getBuyerDetails($buyer_id){
        $buyerDetails = $this->farmerModel->getBuyerDetails($buyer_id);
        if ($buyerDetails) {
            echo json_encode($buyerDetails);
        } else {
            echo json_encode(['error' => 'No details found']);
        }
    }

    public function confirmOrder($order_id) {
      
        $Results = $this->farmerModel->confirmOrder($order_id);
        error_log("ERRor happened". $Results);
        if ($Results) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(['error' => 'No details found']);
        }
    }

    public function Wallet(){
        $data=$this->farmerModel->getWalletDetails($_SESSION['user_id']);
        $this->View('Farmer/Wallet',$data);
    }

    public function orders(){
        $data = [];
        $this->View('Farmer/Orders',$data);
    }

    public function ToPickup(){
        $orders = $this->farmerModel->getToPickupOrders($_SESSION['user_id']);
        $data=[
            'orders' => $orders
        ];
        $this->View('Farmer/ToPickup',$data);
    }

    public function ToPay(){
        $order_details = $this->farmerModel->getToPayOrders($_SESSION['user_id']);
        
   
     $ordersGrouped = [];

     foreach ($order_details as $row) {
         $orderId = $row->order_id;
     
         if (!isset($ordersGrouped[$orderId])) {
             $ordersGrouped[$orderId] = (object)[
                 'order_id' => $row->order_id,
                 'order_date' => $row->order_date,
                 'total_amount'=>$row->total_amount,
                 'items' => []
             ];
         }
     
         $ordersGrouped[$orderId]->items[] = (object)[
             'product_name' => $row->product_name,
             'quantity' => $row->quantity,
             'price' => $row->price,
             'image_url' => $row->image
         ];

     }
     
     // Then pass $ordersGrouped to your view
     
     $data=[
        'orders'=>$ordersGrouped
     ];
  
     
        $this->View('Farmer/ToPay',$data);
    }

    public function ConfirmIngredientOrderReceive($order_id,$product_id) {
        $result =$this->farmerModel->ConfirmIngredientOrderReceive($order_id,$product_id);
        if($result) {
            Redirect('FarmerController/ToReceive');
        } else {
            die('Something went wrong');
        }
    }

    public function RequestHelp() {
        $data = [
            'requests' => $this->NotificationModel->getHelpRequestsWithResponses($_SESSION['user_id'])
        ];
        $this->view('Farmer/RequestHelp', $data);
    }

    public function showForm($category) {
        $data = ['category' => $category];
        $this->view('Farmer/RequestHelp', $data);
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

            if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = 'Uploads/help_requests/';
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

            if ($this->farmerModel->saveHelpRequest($data)) {
                $_SESSION['request_success'] = 'Your request has been submitted successfully!';
                Redirect('FarmerController/RequestHelp');
            } else {
                error_log("Failed to save help request: " . json_encode($data));
                $_SESSION['request_error'] = 'Failed to submit your request. Please try again.';
                Redirect('FarmerController/RequestHelp');
            }
        }
    }

    public function getNotifications($user_id) {
        $helpRequestNotifications = $this->NotificationModel->getHelpRequestNotificationsForUser($user_id);
        $orderNotifications = $this->NotificationModel->getOrdertNotificationsForUser($user_id);

        $notifications = array_merge($helpRequestNotifications, $orderNotifications);
        header('Content-Type: application/json');
        try {
            echo json_encode($notifications);
        } catch (Exception $e) {
            error_log("Failed to encode notifications for user_id $user_id: " . $e->getMessage());
            echo json_encode([]);
        }
    }

    public function getUnreadNotifications() {
        $data = [];
        $this->View('inc/Notification', $data);
    }

    public function markHelpNotificationAsRead($notificationId, $userId) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Ensure the user is authorized
            if ($userId != $_SESSION['user_id']) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Unauthorized']);
                exit;
            }

            $notificationModel = $this->model('Notification');
            $result = $notificationModel->markHelpNotificationAsRead($notificationId, $userId);

            header('Content-Type: application/json');
            echo json_encode(['success' => $result]);
            exit;
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Invalid request method']);
            exit;
        }
    }

    public function markNotificationAsRead($notificationId, $userId) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Ensure the user is authorized
            if ($userId != $_SESSION['user_id']) {
                header('Content-Type: application/json');
                echo json_encode(['success' => false, 'error' => 'Unauthorized']);
                exit;
            }

            $notificationModel = $this->model('Notification');
            $result = $notificationModel->markFarmerOrderNotificationAsRead($notificationId, $userId);

            header('Content-Type: application/json');
            echo json_encode(['success' => $result]);
            exit;
        } else {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'error' => 'Invalid request method']);
            exit;
        }
    }    
    

    public function getUnreadNotificationsCount($user_id) {
        $count = $this->NotificationModel->getUnreadHelpNotificationsCountForUser($user_id)->count;
        return $count;
    }

    //function to add ratingsto suppliers
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

    public function processWithdrawal() {
       
        // Check if the request is a POST request
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Get the withdrawal amount from the request
            $withdrawalAmount = $_POST['amount'];
    
            // Process the withdrawal using the model
            $result = $this->farmerModel->processWithdrawal($withdrawalAmount);

            if ($result === true) {
                Redirect('FarmerController/Wallet');
            } else {
                die('Error: ' . $result); // Show the real error
            }
            
        } else {
            // If not a POST request, redirect to the wallet page
            Redirect('FarmerController/Wallet');
        }
    }

    


}
?>

