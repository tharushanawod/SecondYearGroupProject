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

        $this->ManufacturerModel = $this->model('Manufacturer');
       
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
        $prices = $this->ManufacturerModel->getPrices();
        $data = [
            'prices' => $prices
        ];
        $this->view('Manufacturer/ManufacturerDashboard',$data);
    }

    public function LastPrice()
    {
        $test = $this->ManufacturerModel->getLastPrice();
        return $test;
    }

    public function getPreviousPrice()
    {
        $prices = $this->ManufacturerModel->getPreviousPrice();
        return $prices;
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

    public function RemovePrices($id)
    {   
       $result = $this->ManufacturerModel->RemovePrice($id);
       if($result){
           Redirect('ManufacturerController/Dashboard');
       }
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