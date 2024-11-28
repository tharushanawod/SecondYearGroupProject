<?php 

class ManufacturerController extends Controller
{
    private $ManufacturerModel;

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
    {   $id=$_SESSION['user_id'];
        $prices = $this->ManufacturerModel->getPrices($id);
        $data = [
           
            'prices' => $prices
        ];
        $this->view('Manufacturer/ManufacturerDashboard',$data);
    }

    public function LastPrice()
    {
        $row = $this->ManufacturerModel->getLastPrice();
        return $row;
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
       if($_SERVER['REQUEST_METHOD'] == 'POST'){
           $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
           $data = [
               'type' => trim($_POST['type']),
               'price' => trim($_POST['price']),
               'type_err' => '',
               'price_err' => ''
           ];
         

           if(empty($data['type'])){
               $data['type_err'] = 'Please select a corn type';
           }

           if(empty($data['price'])){
               $data['price_err'] = 'Please input a price';
           }

           if(empty($data['type_err']) && empty($data['price_err'])){
               $result = $this->ManufacturerModel->AddPrices($data);
               if($result){
                   Redirect('ManufacturerController/Dashboard');
               }
           }else{
               $this->view('Manufacturer/AddPrices',$data);
           }
    }

    else{
        $data = [
            'type' => '',
            'price' => '',
            'type_err' => '',
            'price_err' => ''
        ];
        $this->view('Manufacturer/AddPrices',$data);
    }
}

public function getLastPrice()
{
    $row = $this->ManufacturerModel->getLastPrice();

    $data = [
        'date' => $row->date,
        'type' => $row->type,
        'price' => $row->price,
        'priceid' => $row->priceid
    ];
    $this->view('Manufacturer/UpdateLastPrice',$data);
}

public function UpdateLastPrice($priceid)
{  
   if($_SERVER['REQUEST_METHOD'] == 'POST'){
       $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);
       $data = [
           'priceid' => $priceid,
           'price' => trim($_POST['price']),
           'price_err' => ''
       ];

       if(empty($data['price'])){
           $data['price_err'] = 'Please input a price';
       }

       if(empty($data['price_err'])){
           $result = $this->ManufacturerModel->UpdateLastPrice($data);
           if($result){
               Redirect('ManufacturerController/Dashboard');
           }
       }else{
           $this->view('Manufacturer/UpdateLastPrice',$data);
       }
}

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