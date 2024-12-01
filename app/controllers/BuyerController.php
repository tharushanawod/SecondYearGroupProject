<?php 

class BuyerController extends Controller {
    private $pagesModel;

    public function __construct() {
        if (!$this->isloggedin()) {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            Redirect('LandingController/login');
        }
        $this->pagesModel = $this->model('Buyer');
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
        $this->View('Buyer/landing page', $data);
    }

    public function bidProduct() {
        $data = [];
        $this->View('Buyer/bid product', $data);
    }

    public function placeBid() {
        $data = [];
        $this->View('Buyer/place bid', $data);
    }

    public function cancelBid() {
        $data = [];
        $this->View('Buyer/cancel Bid', $data);
    }

    public function payment() {
        $data = [];
        $this->View('Buyer/pendingPayments', $data);
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
        $this->view('Buyer/ManageProfile');
    }
    public function pay() {
        $data = [];
        $this->View('Buyer/pay', $data);
    }
}
?>
    