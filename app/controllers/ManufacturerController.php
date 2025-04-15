<?php 

class ManufacturerController extends Controller {
    private $ManufacturerModel;
    private $NotificationModel;

    public function __construct() {
        if (!$this->isloggedin()) {
            error_log("Unauthorized access attempt to ManufacturerController by user: " . ($_SESSION['user_email'] ?? 'unknown'));
            unset($_SESSION['user_id'], $_SESSION['user_email'], $_SESSION['user_name']);
            session_destroy();
            Redirect('LandingController/login');
        }

        $this->ManufacturerModel = $this->model('Manufacturer');
        $this->NotificationModel = $this->model('Notification');
    }

    public function isloggedin() {
        return isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'manufacturer';
    }

    public function Dashboard() {
        try {
            if (!$this->isloggedin()) {
                error_log("Unauthorized access attempt to ManufacturerController by user: " . ($_SESSION['user_email'] ?? 'unknown'));
                unset($_SESSION['user_id'], $_SESSION['user_email'], $_SESSION['user_name']);
                session_destroy();
                Redirect('LandingController/login');
            }

            $id = $_SESSION['user_id'];
            $data = $this->ManufacturerModel->getPrices($id);
            $data['is_default_floor_price'] = $this->ManufacturerModel->getFloorPrice() == 1000;
            $data['recent_bids'] = $this->ManufacturerModel->getRecentBids($id);
            $data['recent_purchases'] = $this->ManufacturerModel->getRecentPurchases($id);
            if (empty($data['floor_price']) && empty($data['market_average']) && empty($data['price_history'])) {
                error_log("No data returned from getPrices for user_id: $id");
                $_SESSION['error'] = 'Failed to load dashboard data. Please try again.';
            }
            $this->view('Manufacturer/ManufacturerDashboard', $data);
        } catch (Exception $e) {
            error_log("Error in Dashboard: " . $e->getMessage());
            $_SESSION['error'] = 'An error occurred while loading the dashboard. Please contact support.';
            $this->view('Manufacturer/ManufacturerDashboard', []);
        }
    }

    public function setMinimumPrice() {
        $id = $_SESSION['user_id'];
        $floor_price = $this->ManufacturerModel->getFloorPrice();
    
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $action = trim($_POST['action']);
            $market_data = $this->ManufacturerModel->getMarketAverage();
            $data = [
                'manufacturer_id' => $id,
                'unit_price' => trim($_POST['unit_price'] ?? ''),
                'floor_price' => $floor_price,
                'market_average' => $market_data['avg_price'],
                'market_average_reliable' => $market_data['is_reliable'],
                'price_history' => $this->ManufacturerModel->getPreviousPrice($id),
                'price_err' => '',
                'is_default_floor_price' => $floor_price == 1000
            ];
    
            if ($action == 'update') {
                if (empty($data['unit_price'])) {
                    $data['price_err'] = 'Please enter a price';
                } elseif (!is_numeric($data['unit_price']) || $data['unit_price'] <= 0) {
                    $data['price_err'] = 'Price must be a positive number';
                } elseif ($data['unit_price'] < $data['floor_price']) {
                    $data['price_err'] = 'Price must be at least LKR ' . $data['floor_price'];
                }
    
                if (empty($data['price_err'])) {
                    if ($this->ManufacturerModel->setMinimumPrice($data)) {
                        $_SESSION['success'] = 'Minimum price updated successfully';
                        Redirect('ManufacturerController/setMinimumPrice');
                    } else {
                        $data['price_err'] = 'Failed to update price';
                    }
                }
            } elseif ($action == 'delete') {
                if ($this->ManufacturerModel->deleteLastPrice($id)) {
                    $_SESSION['success'] = 'Minimum price deleted successfully';
                    Redirect('ManufacturerController/setMinimumPrice');
                } else {
                    $data['price_err'] = 'Failed to delete price';
                }
            }
    
            $this->view('Manufacturer/SetMinPrice', $data);
        } else {
            try {
                $market_data = $this->ManufacturerModel->getMarketAverage();
                $data = [
                    'manufacturer_id' => $id,
                    'unit_price' => $this->ManufacturerModel->getLastPrice($id) ? $this->ManufacturerModel->getLastPrice($id)->unit_price : '',
                    'floor_price' => $floor_price,
                    'market_average' => $market_data['avg_price'],
                    'market_average_reliable' => $market_data['is_reliable'],
                    'price_history' => $this->ManufacturerModel->getPreviousPrice($id),
                    'price_err' => '',
                    'is_default_floor_price' => $floor_price == 1000
                ];
                $this->view('Manufacturer/SetMinPrice', $data);
            } catch (Exception $e) {
                error_log("Error in setMinimumPrice GET: " . $e->getMessage());
                $_SESSION['error'] = 'Failed to load page. Please try again.';
                $this->view('Manufacturer/SetMinPrice', [
                    'price_err' => 'Server error',
                    'floor_price' => $floor_price,
                    'market_average' => 0,
                    'market_average_reliable' => false,
                    'price_history' => [],
                    'unit_price' => '',
                    'is_default_floor_price' => $floor_price == 1000
                ]);
            }
        }
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
                $result = $this->ManufacturerModel->UpdateProfile($data);
                if ($result) {
                    Redirect('LandingController/logout');
                }
            } else {
                $this->view('Manufacturer/ManageProfile', $data);
            }
        } else {
            $user = $this->ManufacturerModel->getUserById($_SESSION['user_id']);
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
            $this->view('Manufacturer/ManageProfile', $data);
        }
    }

    public function getProfileImage($user_id) {
        $imagePath = $this->ManufacturerModel->getProfileImage($_SESSION['user_id']);
        return $imagePath ? URLROOT . '/' . $imagePath : URLROOT . '/profile_picture/1.jpg';
    }

    public function uploadProfileImage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
            $targetDir = "uploads/ProfilePictures/";
            $fileName = basename($_FILES["profile_picture"]["name"]);
            $targetFile = $targetDir . $fileName;
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
                $uploadResult = $this->ManufacturerModel->updateProfileImage($_SESSION['user_id'], $targetFile);
                Redirect('ManufacturerController/ManageProfile');
            } else {
                echo "Error uploading file.";
            }
        }
    }

       public function StockHolders() {
        $this->view('Manufacturer/StockHolders');
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
            if ($this->ManufacturerModel->saveHelpRequest($data)) {
                $_SESSION['request_success'] = 'Your request has been submitted successfully!';
                Redirect('ManufacturerController/RequestHelp');
            } else {
                error_log("Failed to save help request: " . json_encode($data));
                $_SESSION['request_error'] = 'Failed to submit your request. Please try again.';
                Redirect('ManufacturerController/RequestHelp');
            }
        }
    }





    
    public function index() {
        $data = [];
        $this->View('inc/404.php', $data);
    }

    public function LandingPage() {
        $data = [];
        $this->View('Buyer/LandingPage', $data);
    }

    public function bidProduct() {
        $data = $this->ManufacturerModel->getAvailableProducts();
        $this->View('Buyer/bidProduct', $data);
    }

    public function PlaceBid($product_id) {
        $data = $this->ManufacturerModel->getProductById($product_id);
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
        $this->View('Buyer/BidControl', $data);
    }

    public function getAllActiveBidsForBuyer($user_id) {
        $bids = $this->ManufacturerModel->getAllActiveBidsForBuyer($user_id);
        echo json_encode($bids);
    }

    public function PendingPayments() {
        $data = [];
        $this->View('Buyer/PendingPayments', $data);
    }

    public function getPendingPayments($user_id) {
        $pendingpayments = $this->ManufacturerModel->getPendingPayments($user_id);
        echo json_encode($pendingpayments);
    }

    public function purchaseHistory() {
        $data = [];
        $this->View('Buyer/purchase history', $data);
    }

    public function FarmerProfile($id) {
        $data = $this->ManufacturerModel->getFarmersById($id);
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
                if ($this->ManufacturerModel->AddReview($data)) {
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
                Redirect('BuyerController/ManageProfile');
            }
        } else {
            $user = $this->ManufacturerModel->GetBankAndCardDetails($_SESSION['user_id']);
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
        $existingData = $this->ManufacturerModel->getBankAccountData($_SESSION['user_id']);
        echo json_encode($existingData);
    }

    public function pay() {
        $data = [];
        $this->View('Buyer/pay', $data);
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

    public function CancelBid($bid_id) {
        $result = $this->ManufacturerModel->cancelBid($bid_id);
        header('Content-Type: application/json');
        echo json_encode(['success' => $result]);
    }

    public function AdjustBid($bid_id) {
        $data = $this->ManufacturerModel->getProductById($bid_id);
        var_dump($data);
        $this->View('Buyer/AdjustBid', $data);
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
        $this->View('Buyer/Pay', $data);
    }

//function to update the payment status
    public function Notify() {
        error_log("Notify function triggered");
                        // Sample data from the POST request
                    $merchant_id = $_POST['merchant_id'];
                    $order_id = $_POST['order_id'];
                    $payment_id = $_POST['payment_id'];
                    $status = $_POST['status'];
                    $currency = $_POST['currency'];
                    $amount = $_POST['amount'];
                    $hash = $_POST['hash'];

                    // Your merchant secret key
                    $merchant_secret = $_ENV['MERCHANT_SECRET'];

                    // Verify the received hash
                    $generated_hash = strtoupper(md5(
                        $merchant_id .
                        $order_id .
                        number_format($amount, 2, '.', '') .
                        $currency .
                        strtoupper(md5($merchant_secret))
                    ));

                    if ($hash === $generated_hash) {
                        // Hash matches, it's a valid notification
                        if ($status == 1) {
                            // Payment successful
                            // Update your database, notify the user, etc.
                            $payment_status = 'paid';
                            $this->ManufacturerModel->updatePaymentStatus($order_id, $payment_status);
                        } else {
                            // Payment failed
                            $payment_status = 'failed';
                            $this->ManufacturerModel->updatePaymentStatus($order_id, $payment_status);
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


}
?>