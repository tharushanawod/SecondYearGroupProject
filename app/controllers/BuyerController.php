<?php 

class BuyerController extends Controller {
    private $BuyerModel;
    private $NotificationModel;

    public function __construct() {
        // Get the current method from the URL
        $currentMethod = $this->getCurrentMethodFromURL();
    
        // Bypass authentication if the current method is 'Notify'
        if ($currentMethod !== 'Notify') {
            // Check if user is logged in
            if (!$this->isloggedin()) {
                unset($_SESSION['user_id']);
                unset($_SESSION['user_email']);
                unset($_SESSION['user_name']);
                session_destroy();
                Redirect('LandingController/login');
            } else {

                  // Load models
        $this->BuyerModel = $this->model('Buyer');
        $this->NotificationModel = $this->model('Notification');

                // User is logged in, now check if they are restricted
                $user_id = $_SESSION['user_id'];
                $user = $this->BuyerModel->getUserStatus($user_id);  // Fetch user status from the database
    
                // If the user is restricted, prevent access to any page except "Manage Profile"
                if ($user->user_status === 'restricted') {
                    if ($currentMethod !== 'ManageProfile' && $currentMethod !== 'Resetricted') {
                        Redirect('BuyerController/Resetricted/' . $user_id);
                    }
                }
                
            }
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


    public function index() {
        $data = [];
        $this->View('inc/404.php', $data);
    }

    public function isloggedin() {
        if (isset($_SESSION['user_id']) && ($_SESSION['user_role'] == 'buyer')) {
            return true;
        } else {
            return false;
        }
    }

    public function Dashboard() {
        $total_bids= $this->BuyerModel->getTotalBids($_SESSION['user_id']);
        $active_products = $this->BuyerModel->getActiveProducts();
        $total_spent = $this->BuyerModel->getTotalSpent($_SESSION['user_id']);
        $auction_won = $this->BuyerModel->getAuctionsWon($_SESSION['user_id']);
        $recent_bids=($this->BuyerModel->getRecentBids($_SESSION['user_id']));
        $data = [
            'user_name' => $_SESSION['user_name'],
            'total_bids' => $total_bids,
            'active_products' => $active_products,
            'total_spent' => $total_spent,
            'auction_won' => $auction_won,
            'recent_bids' => $recent_bids
        ];
        $this->View('Buyer/buyer dashboard', $data);
    }

    public function LandingPage() {
        $prices = $this->BuyerModel->getManufacturerPrices();
        $data = [
            'prices' => $prices
        ];
        $this->view('Buyer/LandingPage', $data);
    }

    public function bidProduct() {
        $data = $this->BuyerModel->getAvailableProducts();
        $this->View('Buyer/bidProduct', $data);
    }

    public function PlaceBid($product_id) {
        $data = $this->BuyerModel->getProductById($product_id);
        $this->View('Buyer/PlaceBid', $data);
    }

    public function SubmitBid() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'product_id' => trim($_POST['product_id']),
                'buyer_id' => trim($_POST['buyer_id']),
                'bid_amount' => trim($_POST['bid_amount']),
            ];
            $result = $this->BuyerModel->submitBid($data);
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
        $this->View('Buyer/BidControl', $data);
    }

    public function getAllActiveBidsForBuyer($user_id) {
        $bids = $this->BuyerModel->getAllActiveBidsForBuyer($user_id);
        echo json_encode($bids);
    }

    public function PendingPayments() {
        $data = [];
        $this->View('Buyer/PendingPayments', $data);
    }

    public function getPendingPayments($user_id) {
        $pendingpayments = $this->BuyerModel->getPendingPayments($user_id);
        echo json_encode($pendingpayments);
    }

    public function PurchaseHistory() {
        $data = [];
        $this->View('Buyer/PurchaseHistory', $data);
    }

    public function ManageProfile() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
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

            if (empty($data['name'])) {
                $data['name_err'] = 'Please input a name';
            }
            if (empty($data['phone'])) {
                $data['contact_err'] = 'Please input a contact number';
            }
            if (empty($data['email'])) {
                $data['email_err'] = 'Please input an email';
            }

            if (empty($data['name_err']) && empty($data['phone_err']) && empty($data['email_err'])) {
                echo 'Profile Updated';
                if (!empty($data['password'])) {
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                }
                $result = $this->BuyerModel->UpdateProfile($data);
                if ($result) {
                    Redirect('BuyerController/ManageProfile');
                }
            } else {
                $this->view('Buyer/ManageProfile', $data);
            }
        } else {
            $user = $this->BuyerModel->getUserById($_SESSION['user_id']);
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
            $this->view('Buyer/ManageProfile', $data);
        }
    }

    public function getProfileImage($user_id) {
        $imagePath = $this->BuyerModel->getProfileImage($_SESSION['user_id']);
        return $imagePath ? URLROOT . '/' . $imagePath : URLROOT . '/images/default.jpg';
    }

    public function uploadProfileImage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
            $targetDir = "uploads/ProfilePictures/";
            $fileName = basename($_FILES["profile_picture"]["name"]);
            $targetFile = $targetDir . $fileName;
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
                $uploadResult = $this->BuyerModel->updateProfileImage($_SESSION['user_id'], $targetFile);
                Redirect('BuyerController/ManageProfile');
            } else {
                echo "Error uploading file.";
            }
        }
    }

    public function FarmerProfile($id) {
        $data = $this->BuyerModel->getFarmersById($id);
        $this->View('Buyer/FarmerProfile', $data);
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
                if ($this->BuyerModel->AddReview($data)) {
                    Redirect('BuyerController/FarmerProfile/' . $farmer_id);
                } else {
                    die('Something went wrong while saving the review.');
                }
            } else {
                $this->view('Buyer/FarmerProfile', $data);
            }
        } else {
            $data = [];
            $this->view('Buyer/FarmerProfile', $data);
        }
    }

    public function fetchReviews($id) {
        $reviews = $this->BuyerModel->fetchReviews($id);
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
            $result = $this->BuyerModel->AddBankAccount($data);
            if ($result) {
                Redirect('BuyerController/ManageProfile');
            }
        } else {
            $user = $this->BuyerModel->GetBankAndCardDetails($_SESSION['user_id']);
            $data = [
                'bank_name' => $user->bank_name,
                'account_number' => $user->account_number,
                'account_name' => $user->account_name,
                'bank_name_err' => '',
                'account_number_err' => '',
                'account_name_err' => ''
            ];
            $this->view('Buyer/ManageProfile', $data);
        }
    }

    public function GetBankAndCardDetails() {
        $existingData = $this->BuyerModel->getBankAccountData($_SESSION['user_id']);
        echo json_encode($existingData);
    }

    public function pay() {
        $data = [];
        $this->View('Buyer/pay', $data);
    }



    public function CancelBid($bid_id) {
        $result = $this->BuyerModel->cancelBid($bid_id);
        header('Content-Type: application/json');
        echo json_encode(['success' => $result]);
    }

    public function AdjustBid($bid_id) {
        $data = $this->BuyerModel->getProductById($bid_id);
        var_dump($data);
        $this->View('Buyer/AdjustBid', $data);
    }

    public function getPaymentDetailsForOrder($order_id) {
        $paymentDetails = $this->BuyerModel->getPaymentDetailsForOrder($order_id);
        $userdetails = $this->BuyerModel->getUserById($_SESSION['user_id']);
    
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
        $this->View('Buyer/Pay', $data);
    }

//function to update the payment status
    public function Notify() {
        $this->BuyerModel = $this->model('Buyer');
        
                    $hash = $_POST['md5sig'];
                    $order_id = $_POST['order_id'];
                    $amount = $_POST['payhere_amount'];
                    $payment_id = $_POST['payment_id'];
                    $status_code = $_POST['status_code'];
                    $currency = $_POST['payhere_currency'];


                    // Your merchant secret key
                    $merchant_secret = $_ENV['MERCHANT_SECRET'];

                    // Verify the received hash
                    $generated_hash = strtoupper(md5(
                        $_POST['merchant_id'] .
                        $_POST['order_id'] .
                        $_POST['payhere_amount'] .
                        $_POST['payhere_currency'] .
                        $_POST['status_code'] .
                        strtoupper(md5($merchant_secret))
                    ));
                    if ($hash === $generated_hash) {
                      error_log("tharusha".var_export($_POST, true));
                        // Hash matches, it's a valid notification
                        if ($status_code == 2) {
                            // Payment successful
                            // Update your database, notify the user, etc.
                            $payment_status = 'paid';
                            // $details=$this->BuyerModel->getPaymentDetailsForOrder($_POST['order_id']);
                            $paid_amount_for_buyer =$amount/22*20;
                            $paid_service_charge = $amount/22*2;


                            $this->BuyerModel->updatePaymentStatus($order_id, $payment_status);
                            $this->BuyerModel->TransactionComplete($order_id, $paid_amount_for_buyer,$paid_service_charge,$payment_id);
                        } else {
                            // Payment failed
                            $payment_status = 'failed';
                            $this->BuyerModel->updatePaymentStatus($order_id, $payment_status);
                        }
                    } else {
                        // Invalid hash
                        echo "Invalid payment notification.";
                    }
    }

    public function Success() {
        // Check if 'order_id' and 'amount' are set in the URL (GET request)
        if (isset($_GET['order_id']) && isset($_GET['amount'])) {
            // Sanitize the input to prevent malicious data
            $order_id = htmlspecialchars($_GET['order_id']);
            $amount = htmlspecialchars($_GET['amount']);
            
            // Prepare the data to pass to the view
            $data = [
                'order_id' => $order_id,
                'amount' => $amount
            ];
    
            // Pass the data to the view
            $this->View('Buyer/PaymentSuccess', $data);
        } else {
            // Handle the case where 'order_id' or 'amount' are not present
            // You can show an error message or redirect to another page
            echo "Invalid payment data.";
        }
    }
    

    public function Cancel() {
        echo "Payment was cancelled!";
    }



    public function getPurchaseHistory($user_id) {
        $purchaseHistory = $this->BuyerModel->getPurchaseHistory($user_id);
        header('Content-Type: application/json');
        echo json_encode($purchaseHistory);
    }

    public function getFarmerDetails($farmerId) {
        $farmerDetails = $this->BuyerModel->getFarmersById($farmerId);
        
        header('Content-Type: application/json');
        echo json_encode([
            'name' => $farmerDetails->name,
            'contact_number' => $farmerDetails->phone,
            'pickup_location' => $farmerDetails->address
        ]);
    }

    public function confirmOrder($order_id){
        $result = $this->BuyerModel->confirmOrder($order_id);
        header('Content-Type: application/json');
        echo json_encode(['success' => $result]);

    }

    public function Resetricted($user_id){
        $data = $this->BuyerModel->getrestrictedDetails($user_id);
        $this->View('inc/Restricted', $data);
    }


    
    public function RequestHelp() {
        $data = [
            'requests' => $this->NotificationModel->getHelpRequestsWithResponses($_SESSION['user_id'])
        ];
        $this->view('Buyer/RequestHelp', $data);
    }

    public function showForm($category) {
        $data = ['category' => $category];
        $this->view('Buyer/RequestHelp', $data);
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
                if ($this->BuyerModel->saveHelpRequest($data)) {
                    $_SESSION['request_success'] = 'Your request has been submitted successfully!';
                    Redirect('BuyerController/RequestHelp');
                } else {
                    error_log("Failed to save help request: " . json_encode($data));
                    $data['request_error'] = 'Failed to submit your request. Please try again.';
                }
            }
    
            $_SESSION['request_error'] = $data['request_error'];
            Redirect('BuyerController/RequestHelp');
        }
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

  



    public function filterBids() {
        $input = json_decode(file_get_contents("php://input"), true);
    
        $category = $input['category'] ?? '';
        $sortBy = $input['sortBy'] ?? '';
        $minPrice = $input['minPrice'] ?? '';
        $maxPrice = $input['maxPrice'] ?? '';
        $minQty = $input['minQty'] ?? '';
        $maxQty = $input['maxQty'] ?? '';
    
        $filtered = $this->BuyerModel->getFilteredBids($category, $sortBy, $minPrice, $maxPrice, $minQty, $maxQty);
    
        echo json_encode($filtered);
    }

    public function getNotifications($buyer_id) {
        $productsnotifications = (array) $this->NotificationModel->getNotifications($buyer_id);
$winningnotifications = (array) $this->NotificationModel->getWinningNotifications($buyer_id);
$helpRequestNotifications = (array)$this->NotificationModel->getHelpRequestNotificationsForUser($buyer_id);
$refundNotifications = (array)$this->NotificationModel->getRefundNotifications($buyer_id);

        // Merge all notifications into a single array
$notifications = array_merge($productsnotifications, $winningnotifications,$helpRequestNotifications,$refundNotifications);

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
    

}

?>