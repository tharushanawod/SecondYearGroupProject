<?php 

class BuyerController extends Controller {
    private $BuyerModel;
    private $NotificationModel;

    public function __construct() {
        if (!$this->isloggedin()) {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            Redirect('LandingController/login');
        }
        $this->BuyerModel = $this->model('Buyer');
        $this->NotificationModel = $this->model('Notification');
    }

    public function index() {
        $data=[];
        $this->View('inc/404.php', $data);
    }

    public function isloggedin() {
        if (isset($_SESSION['user_id']) && ($_SESSION['user_role']=='buyer')){
            return true;
        } else {
            return false;
        }
    }

    public function Dashboard() {
        $data = [];
        $this->View('Buyer/buyer dashboard', $data);
    }

    public function LandingPage() {
        $data = [];
        $this->View('Buyer/LandingPage', $data);
    }

    public function bidProduct() {
        $data = $this->BuyerModel->getAvailableProducts();
        $this->View('Buyer/bidProduct', $data);
    }

    public function PlaceBid($product_id) {
       
        $data= $this->BuyerModel->getProductById($product_id);
        $this->View('Buyer/PlaceBid', $data);
    }

    public function SubmitBid() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Sanitize input data
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'product_id' => trim($_POST['product_id']),
                'buyer_id' => trim($_POST['buyer_id']),
                'bid_amount' => trim($_POST['bid_amount']),
            ];
            // Process the bid submission
            $result = $this->BuyerModel->submitBid($data);
            
            // Return JSON response based on the result
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
        $data =[];
        $this->View('Buyer/BidControl', $data);
    }

    public function getAllActiveBidsForBuyer($user_id) {
        $bids = $this->BuyerModel->getAllActiveBidsForBuyer($user_id);
        echo json_encode($bids);
    }

    public function PendingPayment() {
        $data = [];
        $this->View('Buyer/PendingPayment', $data);
    }

    public function purchaseHistory() {
        $data = [];
        $this->View('Buyer/purchase history', $data);
    }

    public function RequestHelp() {
        $data = [];
        $this->View('Buyer/RequestHelp', $data);
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
                
                $result = $this->BuyerModel->UpdateProfile($data);
              
                if($result){
                    // Redirect('BuyerController/ManageProfile');
                    Redirect('LandingController/logout');
                }
            }else{
                $this->view('Buyer/ManageProfile',$data);
            }
        
            }
            else{
                $user=$this->BuyerModel->getUserById($_SESSION['user_id']);
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
                $this->view('Buyer/ManageProfile',$data);
                
            }
    }

    // Get profile image URL
    public function getProfileImage($user_id) {
        $imagePath = $this->BuyerModel->getProfileImage($_SESSION['user_id']);
        return $imagePath ? URLROOT .'/'.$imagePath : URLROOT . '/images/default.jpg';
    }

    public function uploadProfileImage() {

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $targetDir = "uploads/ProfilePictures/";
    $fileName = basename($_FILES["profile_picture"]["name"]);
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
        $uploadResult = $this->BuyerModel->updateProfileImage($_SESSION['user_id'], $targetFile);
       Redirect('BuyerController/ManageProfile');
        // Update user's profile picture in the database here
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
    
            // Validation
            if (empty($data['review_text'])) {
                $data['reviewText_err'] = 'Please enter a review';
            }
            if ($data['rating'] < 1 || $data['rating'] > 5) {
                $data['rating_err'] = 'Please select a rating between 1 and 5';
            }
            
    
            // If no errors, add the review
            if (empty($data['reviewText_err']) && empty($data['rating_err'])) {
                if ($this->BuyerModel->AddReview($data)) {
                    Redirect('BuyerController/FarmerProfile/' . $farmer_id);
                } else {
                    die('Something went wrong while saving the review.');
                }
            } else {
                // Reload the form with errors
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



    public function AddBankAccount(){

        if($_SERVER['REQUEST_METHOD'] == 'POST'){ 
            $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
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
              
                if($result){
                    Redirect('BuyerController/ManageProfile');
                }
        
            }
            else{

               
              
                $user=$this->BuyerModel->GetBankAndCardDetails($_SESSION['user_id']);
              
                $data = [
                    'bank_name' => $user->bank_name,
                    'account_number' => $user->account_number,
                    'account_name' => $user->account_name,
                    'bank_name_err' => '',
                    'account_number_err' => '',
                    'account_name_err' => ''
                ];
                $this->view('Buyer/ManageProfile',$data);
                
            }
    

           }

// In BuyerController.php

public function GetBankAndCardDetails() {
    // Fetch existing data from the database
    $existingData = $this->BuyerModel->getBankAccountData($_SESSION['user_id']); // Example function to fetch data
     var_dump($existingData);
    // Return the data as JSON
    echo json_encode($existingData);
}


    public function pay() {
        $data = [];
        $this->View('Buyer/pay', $data);
    }

    public function getNotifications($buyer_id) {
        $productsnotifications = (array) $this->NotificationModel->getNotifications();
$winningnotifications = (array) $this->NotificationModel->getWinningNotifications($buyer_id);
$notifications = array_merge($productsnotifications, $winningnotifications);

        header('Content-Type: application/json');
        echo json_encode($notifications);
    }


    public function getUnreadNotifications() {
  
       $this->View('inc/Notification',$data);
    }

    public function markNotificationAsRead($id) {
        $result = $this->NotificationModel->markNotificationAsRead($id);
        header('Content-Type: application/json');
        echo json_encode(['success' => $result]);
    }

    public function CancelBid($bid_id) {
        $result = $this->BuyerModel->cancelBid($bid_id);
        header('Content-Type: application/json');
        echo json_encode(['success' => $result]);
    }

}



?>
    