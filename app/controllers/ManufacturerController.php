<?php 

class ManufacturerController extends Controller
{
    public function __construct()
    {
        if(!$this->isloggedin()){
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            Redirect('LandingController/login');
        }
       
    }

    public function isloggedin() {
        if (isset($_SESSION['user_id']) && ($_SESSION['user_role']=='manufacturer')){
            return true;
        } else {
            return false;
        }
    }

    public function Dashboard()
    {
        $this->view('Manufacturer/ManufacturerDashboard');
    }

    public function ManageProfile()
    {
        $this->view('Manufacturer/ManageProfile');
    }

    public function AddPrices()
    {
        $this->view('Manufacturer/AddPrices');
    }

    public function UpdatePrices()
    {
        $this->view('Manufacturer/UpdatePrices');
    }

    public function RemovePrices()
    {
        $this->view('Manufacturer/RemovePrices');
    }

    public function RequestHelp()
    {
        $this->view('Manufacturer/RequestHelp');
    }
    public function StockHolders()
    {
        $this->view('Manufacturer/StockHolders');
    }

}




?>