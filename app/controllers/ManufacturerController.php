<?php
class ManufacturerController extends Controller {
    private $ManufacturerModel;
    private $NotificationModel;

    public function __construct() {
        $currentMethod = $this->getCurrentMethodFromURL();
    
        if ($currentMethod !== 'Notify') {            
            if (!$this->isloggedin()) {
                unset($_SESSION['user_id']);
                unset($_SESSION['user_email']);
                unset($_SESSION['user_name']);
                session_destroy();
                Redirect('LandingController/login');
            } else {
        $this->ManufacturerModel = $this->model('Manufacturer');
        $this->NotificationModel = $this->model('Notification');
                $user_id = $_SESSION['user_id'];
                $user = $this->ManufacturerModel->getUserStatus($user_id); 
                if ($user->user_status === 'restricted') {
                    if ($currentMethod !== 'ManageProfile' && $currentMethod !== 'Resetricted') {
                        Redirect('ManufacturerController/Resetricted/' . $user_id);
                    }
                }
                
            }
        }   
      
    }

    public function isloggedin() {
        if (isset($_SESSION['user_id']) && ($_SESSION['user_role'] == 'manufacturer')) {
            return true;
        } else {
            return false;
        }
    }

    public function Dashboard() {
        $last_price = $this->ManufacturerModel->getLastPrice($_SESSION['user_id']);
        $total_bids = $this->ManufacturerModel->getTotalBids($_SESSION['user_id']);
        $active_products = $this->ManufacturerModel->getActiveProducts();
        $total_spent = $this->ManufacturerModel->getTotalSpent($_SESSION['user_id']);
        $auction_won = $this->ManufacturerModel->getAuctionsWon($_SESSION['user_id']);
        $recent_bids = $this->ManufacturerModel->getRecentBids($_SESSION['user_id']);

        $data = [
            'user_name' => $_SESSION['user_name'],
            'last_price' => $last_price ? $last_price->unit_price : null,
            'total_bids' => $total_bids,
            'active_products' => $active_products,
            'total_spent' => $total_spent,
            'auction_won' => $auction_won,
            'recent_bids' => $recent_bids,
            'error' => ''
        ];

        $this->View('Manufacturer/ManufacturerDashboard', $data);
    }

    public function SetPrice() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize input
            $unit_price = filter_input(INPUT_POST, 'unit_price', FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION);
            $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_FULL_SPECIAL_CHARS) ?? 'set';
    
            $data = [
                'unit_price' => $unit_price,
                'unit_price_err' => '',
                'other_prices' => $this->ManufacturerModel->getOtherManufacturersPrices($_SESSION['user_id'])
            ];
    
            if ($action === 'delete') {
                if ($this->ManufacturerModel->deletePrice($_SESSION['user_id'])) {
                    $_SESSION['price_success'] = 'Price deleted successfully!';
                    header('Location: ' . URLROOT . '/ManufacturerController/SetPrice');
                    exit;
                } else {
                    $_SESSION['price_error'] = 'Failed to delete price. Please try again.';
                    header('Location: ' . URLROOT . '/ManufacturerController/SetPrice');
                    exit;
                }
            } elseif ($action === 'set') {
                if (empty($data['unit_price'])) {
                    $data['unit_price_err'] = 'Please enter a unit price';
                } elseif (!is_numeric($data['unit_price']) || $data['unit_price'] <= 0) {
                    $data['unit_price_err'] = 'Please enter a valid positive number';
                } elseif ($data['unit_price'] > 10000) {
                    $data['unit_price_err'] = 'Price cannot exceed 10,000 LKR';
                }
    
                if (empty($data['unit_price_err'])) {
                    if ($this->ManufacturerModel->setPrice($_SESSION['user_id'], $data['unit_price'])) {
                        $_SESSION['price_success'] = 'Price updated successfully!';
                        header('Location: ' . URLROOT . '/ManufacturerController/SetPrice');
                        exit;
                    } else {
                        $data['unit_price_err'] = 'Failed to update price. Please try again.';
                    }
                }
            } else {
                $data['unit_price_err'] = 'Invalid action.';
            }
            $this->View('Manufacturer/SetPrice', $data);
        } else {
            $last_price = $this->ManufacturerModel->getLastPrice($_SESSION['user_id']);
            $data = [
                'unit_price' => $last_price ? $last_price->unit_price : '',
                'unit_price_err' => '',
                'other_prices' => $this->ManufacturerModel->getOtherManufacturersPrices($_SESSION['user_id'])
            ];
            $this->View('Manufacturer/SetPrice', $data);
        }
    }

    public function ManageProfile() {
        if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
            $data = [
                'name' => trim($_POST['name']),
                'contact' => trim($_POST['contact']),
                'address' => trim($_POST['address']),
                'email' => trim($_POST['email']),
                'password' => trim($_POST['password']),
                'name_err' => '',
                'contact_err' => '',
                'address_err' => '',
                'email_err' => '',
                'password_err' => ''
            ];

            if(empty($data['name'])){
                $data['name_err'] = 'Please input a name';
            }

            if(empty($data['contact'])){
                $data['contact_err'] = 'Please input a contact number';
            }

            if(empty($data['address'])){
                $data['address_err'] = 'Please input an address';
            }

            if(empty($data['email'])){
                $data['email_err'] = 'Please input an email';
            }

            if(empty($data['password'])){
                $data['password_err'] = 'Please input a password';
            }

            if(empty($data['name_err']) && empty($data['contact_err']) && empty($data['address_err']) && empty($data['email_err']) && empty($data['password_err'])){
                $result = $this->ManufacturerModel->ManageProfile($data);
                if($result){
                    header('Location: ' . URLROOT . '/ManufacturerController/Dashboard');
                    exit;
                }
            }
            $this->view('Manufacturer/ManageProfile', $data);
        } else {
            $user = $this->ManufacturerModel->getUserById($_SESSION['user_id']);
            $data = [
                'name' => $user->name,
                'contact' => $user->phone,
                'email' => $user->email,
                'password' => '',
                'name_err' => '',
                'phone_err' => '',
                'email_err' => '',
                'password_err' => ''
            ];
            $this->view('Manufacturer/ManageProfile', $data);
        }
    }

    public function StockHolders() {
        $buyers = $this->ManufacturerModel->stockHolders();
        $data = [
            'buyers' => $buyers
        ];
        $this->view('Manufacturer/StockHolders', $data);
    }


    public function RequestHelp() {
        $data = [];
        $this->View('Manufacturer/RequestHelp', $data);
    }

    public function showForm($category) {
        $data = ['category' => $category];
        $this->View('Manufacturer/RequestHelp', $data);
    }

    public function submitRequest() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_UNSAFE_RAW);
            $data = [
                'user_id' => $_SESSION['user_id'],
                'user_role' => $_SESSION['user_role'],
                'category' => htmlspecialchars(trim($_POST['category'])),
                'subject' => htmlspecialchars(trim($_POST['subject'])),
                'description' => htmlspecialchars(trim($_POST['description'])),
                'attachment' => null,
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s'),
                'request_error' => ''
            ];
    
            // Handle file upload
            if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
                $uploadDir = 'Uploads/help_requests/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
    
                // Validate file extension
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'pdf'];
                $fileExtension = strtolower(pathinfo($_FILES['attachment']['name'], PATHINFO_EXTENSION));
                $maxFileSize = 5 * 1024 * 1024; // 5MB limit
    
                if (!in_array($fileExtension, $allowedExtensions)) {
                    $data['request_error'] = 'Only JPEG, PNG, or PDF files are allowed.';
                } elseif ($_FILES['attachment']['size'] > $maxFileSize) {
                    $data['request_error'] = 'File size exceeds 5MB limit.';
                } else {
                    // Generate unique file name
                    $uniqueName = uniqid('attachment_') . '.' . $fileExtension;
                    $uploadFile = $uploadDir . $uniqueName;
    
                    if (move_uploaded_file($_FILES['attachment']['tmp_name'], $uploadFile)) {
                        $data['attachment'] = $uploadFile;
                    } else {
                        error_log("Failed to upload attachment: " . $_FILES['attachment']['name']);
                        $data['request_error'] = 'Failed to upload attachment. Please try again.';
                    }
                }
            }
    
            if (empty($data['request_error'])) {
                if ($this->ManufacturerModel->saveHelpRequest($data)) {
                    $_SESSION['request_success'] = 'Your request has been submitted successfully!';
                    Redirect('ManufacturerController/RequestHelp');
                } else {
                    error_log("Failed to save help request: " . json_encode($data));
                    $data['request_error'] = 'Failed to submit your request. Please try again.';
                }
            }
    
            $_SESSION['request_error'] = $data['request_error'];
            Redirect('ManufacturerController/RequestHelp');
        }
    }

    public function index() {
        $data = [];
        $this->View('inc/404.php', $data);
    }

        
    public function LandingPage() {
        $prices = $this->ManufacturerModel->getManufacturerPrices();
        $data = [
            'prices' => $prices
        ];
        $this->view('Manufacturer/LandingPage', $data);
    }

    public function bidProduct() {
        $data = $this->ManufacturerModel->getAvailableProducts();
        $this->View('Manufacturer/bidProduct', $data);
    }
    

    public function PlaceBid($product_id) {
        $data = $this->ManufacturerModel->getProductById($product_id);
        $this->View('Manufacturer/PlaceBid', $data);
    }

    public function SubmitBid() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'product_id' => trim($_POST['product_id']),
                'buyer_id' => trim($_POST['buyer_id']),
                'bid_amount' => trim($_POST['bid_amount']),
            ];
            $result = $this->ManufacturerModel->submitBid($data);
            header('Content-Type: application/json');
            if ($result) {
                echo json_encode(['success' => true, 'message' => 'Bid submitted successfully!']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Error submitting the bid.']);
            }
            exit;
        }
    }

    public function BidControl() {
        $data = [];
        $this->View('Manufacturer/BidControl', $data);
    }

    public function getAllActiveBidsForBuyer($user_id) {
        $bids = $this->ManufacturerModel->getAllActiveBidsForBuyer($user_id);
        echo json_encode($bids);
    }

    public function PendingPayments() {
        $data = [];
        $this->View('Manufacturer/PendingPayments', $data);
    }

    public function getPendingPayments($user_id) {
        $pendingpayments = $this->ManufacturerModel->getPendingPayments($user_id);
        echo json_encode($pendingpayments);
    }

    public function purchaseHistory() {
        $data = [];
        $this->View('Manufacturer/purchaseHistory', $data);
    }

    public function getProfileImage($user_id) {
        $imagePath = $this->ManufacturerModel->getProfileImage($_SESSION['user_id']);
        return $imagePath ? URLROOT . '/' . $imagePath : URLROOT . '/images/default.jpg';
    }

    public function uploadProfileImage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
            $targetDir = "Uploads/ProfilePictures/";
            $fileName = basename($_FILES["profile_picture"]["name"]);
            $targetFile = $targetDir . $fileName;
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
                $uploadResult = $this->ManufacturerModel->updateProfileImage($_SESSION['user_id'], $targetFile);
                header('Location: ' . URLROOT . '/ManufacturerController/ManageProfile');
                exit;
            } else {
                echo "Error uploading file.";
            }
        }
    }

    public function FarmerProfile($id) {
        $data = $this->ManufacturerModel->getFarmersById($id);
        $this->View('Manufacturer/FarmerProfile', $data);
    }

    public function AddReview($farmer_id) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'review_text' => trim($_POST['review_text']),
                'rating' => (int) $_POST['rating'],
                'farmer_id' => $farmer_id,
                'buyer_id' => $_SESSION['user_id'],
                'reviewText_err' => '',
                'rating_err' => ''
            ];
            if (empty($data['review_text'])) {
                $data['reviewText_err'] = 'Please enter a review';
            }
            if ($data['rating'] < 1 || $data['rating'] > 5) {
                $data['rating_err'] = 'Please select a rating between 1 and 5';
            }
            if (empty($data['reviewText_err']) && empty($data['rating_err'])) {
                if ($this->ManufacturerModel->AddReview($data)) {
                    header('Location: ' . URLROOT . '/ManufacturerController/FarmerProfile/' . $farmer_id);
                    exit;
                } else {
                    die('Something went wrong while saving the review.');
                }
            } else {
                $this->view('Manufacturer/FarmerProfile', $data);
            }
        } else {
            $data = [];
            $this->view('Manufacturer/FarmerProfile', $data);
        }
    }

    public function fetchReviews($id) {
        $reviews = $this->ManufacturerModel->fetchReviews($id);
        header('Content-Type: application/json');
        echo json_encode($reviews);
    }

    public function AddBankAccount() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'user_id' => $_SESSION['user_id'],
                'bank_name' => trim($_POST['bank_name']),
                'account_number' => trim($_POST['account_number']),
                'name_on_card' => trim($_POST['name_on_card']),
                'card_number' => trim($_POST['card_number']),
                'expiry_date' => trim($_POST['expiry_date']),
                'cvv' => trim($_POST['cvv'])
            ];
            $result = $this->ManufacturerModel->AddBankAccount($data);
            if ($result) {
                header('Location: ' . URLROOT . '/ManufacturerController/ManageProfile');
                exit;
            }
        } else {
            $user = $this->ManufacturerModel->GetBankAndCardDetails($_SESSION['user_id']);
            $data = [
                'bank_name' => $user->bank_name ?? '',
                'account_number' => $user->account_number ?? '',
                'account_name' => $user->name_on_card ?? '',
                'bank_name_err' => '',
                'account_number_err' => '',
                'account_name_err' => ''
            ];
            $this->view('Manufacturer/ManageProfile', $data);
        }
    }

    public function GetBankAndCardDetails() {
        $existingData = $this->ManufacturerModel->getBankAccountData($_SESSION['user_id']);
        echo json_encode($existingData);
    }

    public function pay() {
        $data = [];
        $this->View('Manufacturer/pay', $data);
    }

    public function CancelBid($bid_id) {
        $result = $this->ManufacturerModel->cancelBid($bid_id);
        header('Content-Type: application/json');
        echo json_encode(['success' => $result]);
    }

    public function AdjustBid($bid_id) {
        $data = $this->ManufacturerModel->getProductById($bid_id);
        $this->View('Manufacturer/AdjustBid', $data);
    }

    public function getPaymentDetailsForOrder($order_id) {
        $paymentDetails = $this->ManufacturerModel->getPaymentDetailsForOrder($order_id);
        $userdetails = $this->ManufacturerModel->getUserById($_SESSION['user_id']);
    
        if (!$paymentDetails) {
            die("Payment details not found.");
        }
        $quantity = $paymentDetails->quantity;
        $data = [
            'order_id' => $order_id,
            'buyer_id' => $_SESSION['user_id'],
            'product_id' => $paymentDetails->product_id,
            'paymentDetails' => $paymentDetails,
            'total_amount' => $paymentDetails->bid_price * $quantity,
            'advance_payment' => $paymentDetails->bid_price * $quantity * 0.2,
            'service_charge' => $paymentDetails->bid_price * $quantity * 0.02,
            'total_advance' => $paymentDetails->bid_price * $quantity * 0.22,
            'name' => $userdetails->name,
            'phone' => $userdetails->phone,
            'email' => $userdetails->email,
        ];
        $this->View('Manufacturer/Pay', $data);
    }

    public function Notify() {
        error_log("Notify function triggered");
        $merchant_id = $_POST['merchant_id'];
        $order_id = $_POST['order_id'];
        $payment_id = $_POST['payment_id'];
        $status = $_POST['status'];
        $currency = $_POST['currency'];
        $amount = $_POST['amount'];
        $hash = $_POST['hash'];

        $merchant_secret = $_ENV['MERCHANT_SECRET'];
        $generated_hash = strtoupper(md5(
            $merchant_id .
            $order_id .
            number_format($amount, 2, '.', '') .
            $currency .
            strtoupper(md5($merchant_secret))
        ));

        if ($hash === $generated_hash) {
            if ($status == 1) {
                $payment_status = 'paid';
                $this->ManufacturerModel->updatePaymentStatus($order_id, $payment_status);
            } else {
                $payment_status = 'failed';
                $this->ManufacturerModel->updatePaymentStatus($order_id, $payment_status);
            }
        } else {
            echo "Invalid payment notification.";
        }
    }

    public function Success() {
        if (isset($_GET['order_id']) && isset($_GET['amount'])) {
            $order_id = htmlspecialchars($_GET['order_id']);
            $amount = htmlspecialchars($_GET['amount']);
            $data = [
                'order_id' => $order_id,
                'amount' => $amount
            ];
            $this->View('Manufacturer/PaymentSuccess', $data);
        } else {
            echo "Invalid payment data.";
        }
    }    

    public function Cancel() {
        echo "Payment was cancelled!";
    }   
   
    private function getCurrentMethodFromURL() {
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);
            return $url[1] ?? null;
        }
        return null;
    }

    public function getPurchaseHistory($user_id) {
        $purchaseHistory = $this->ManufacturerModel->getPurchaseHistory($user_id);
        header('Content-Type: application/json');
        echo json_encode($purchaseHistory);
    }

    public function getFarmerDetails($farmerId) {
        $farmerDetails = $this->ManufacturerModel->getFarmersById($farmerId);
        
        header('Content-Type: application/json');
        echo json_encode([
            'name' => $farmerDetails->name,
            'contact_number' => $farmerDetails->phone,
            'pickup_location' => $farmerDetails->address
        ]);
    }

    public function confirmOrder($order_id){
        $result = $this->ManufacturerModel->confirmOrder($order_id);
        header('Content-Type: application/json');
        echo json_encode(['success' => $result]);

    }

    public function Resetricted($user_id){
        $data = $this->ManufacturerModel->getrestrictedDetails($user_id);
        $this->View('inc/Restricted', $data);
    }


    public function markHelpNotificationAsRead($notificationId, $userId) {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
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

    public function filterBids() {
        $input = json_decode(file_get_contents("php://input"), true);
    
        $category = $input['category'] ?? '';
        $sortBy = $input['sortBy'] ?? '';
        $minPrice = $input['minPrice'] ?? '';
        $maxPrice = $input['maxPrice'] ?? '';
        $minQty = $input['minQty'] ?? '';
        $maxQty = $input['maxQty'] ?? '';
    
        $filtered = $this->ManufacturerModel->getFilteredBids($category, $sortBy, $minPrice, $maxPrice, $minQty, $maxQty);
    
        echo json_encode($filtered);
    }
    
    public function getNotifications($buyer_id) {
        $productsnotifications = (array) $this->NotificationModel->getNotifications($buyer_id);
        $winningnotifications = (array) $this->NotificationModel->getWinningNotifications($buyer_id);
        $notifications = array_merge($productsnotifications, $winningnotifications);

        header('Content-Type: application/json');
        echo json_encode($notifications);
    }

    public function getUnreadNotifications() {
        $data = [];
        $this->View('inc/Notification', $data);
    }

    public function markNotificationAsRead($id, $buyer_id) {
        $result = $this->NotificationModel->markNotificationAsRead($id, $buyer_id);
        header('Content-Type: application/json');
        echo json_encode(['success' => $result]);
    }

    public function getUnreadNotificationsCount($buyer_id) {
       
        $count = $this->NotificationModel->getUnreadNotificationsCount($buyer_id);
        return $count->count;
        
    }

    public function getStockHolders(){
        $stockHolders = $this->ManufacturerModel->getStockHolders();
        header('Content-Type: application/json');
        echo json_encode($stockHolders);
    }

    public function getBuyerDetails($buyer_id){
        $buyerDetails = $this->ManufacturerModel->getBuyerDetails($buyer_id);
        header('Content-Type: application/json');
        echo json_encode($buyerDetails);
    }
   
}
?>