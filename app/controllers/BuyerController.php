<?php 

class BuyerController extends Controller {
    private $pagesModel;

    public function __construct() {
        $this->pagesModel = $this->model('Buyer');
    }

    public function dashboard() {
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

    public function purchaseHistory() {
        $data = [];
        $this->View('Buyer/purchase history', $data);
    }

    public function requestHelp() {
        $data = [];
        $this->View('Buyer/Contact us', $data);
    }
}
?>
    