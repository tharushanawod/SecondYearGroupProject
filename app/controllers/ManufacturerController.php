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
                    Redirect('ManufacturerController/Dashboard');
                }
            }else{
                $this->view('Manufacturer/ManageProfile',$data);
            }
        
            }
            else{

                $user=$this->ManufacturerModel->getUserById($_SESSION['user_id']);
                var_dump($_SESSION['user_id']);
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
                $this->view('Buyer/ManageProfile',$data);
                
            }
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

       public function StockHolders()
    {
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


}




?>