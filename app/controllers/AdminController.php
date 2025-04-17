<?php 

class AdminController extends Controller {
    private $AdminModel;

    public function __construct() {

        if(!$this->isloggedin()){
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            Redirect('LandingController/login');
        }
        
        $this->AdminModel = $this->model('Users');
    }

    public function isloggedin() {
        if (isset($_SESSION['user_id']) && ($_SESSION['user_role']=='admin')){
            return true;
        } else {
            return false;
        }
    }

    // Fetch and display users on the dashboard
    public function Dashboard() {
        $user_counts = $this->AdminModel->getUserCountByType();
        $product_count = $this->AdminModel->getProductCount();
        $bid_count = $this->AdminModel->getBidCount();
        $data = [
            'user_counts' => $user_counts,
            'product_count' => $product_count,
            'bid_count' => $bid_count,
        ];

        // Render the view
        $this->View('Admin/LandingDashboard', $data);

        
    }

    public function ManageProfile()
    {
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
                'email_err' => ''
            ];
    
            if (empty($data['name'])) {
                $data['name_err'] = 'Please input a name';
            }
    
            if (empty($data['phone'])) {
                $data['phone_err'] = 'Please input a contact number';
            }
    
            if (empty($data['email'])) {
                $data['email_err'] = 'Please input an email';
            }
    
            if (empty($data['name_err']) && empty($data['phone_err']) && empty($data['email_err'])) {
                if (!empty($data['password'])) {
                    $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
                }
    
                $result = $this->AdminModel->UpdateProfile($data);
                
                if ($result) {
                    Redirect('AdminController/ManageProfile');
                }
            } else {
                $this->view('Admin/ManageProfile', $data);
            }
    
        } else {
            
            $user = $this->AdminModel->getUserById($_SESSION['user_id']);
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
            $this->view('Admin/ManageProfile', $data);
        }
    }
    
    // Get profile image URL
    public function getProfileImage($user_id)
    {
        $imagePath = $this->AdminModel->getProfileImage($_SESSION['user_id']);
        return $imagePath ? URLROOT . '/' . $imagePath : URLROOT . '/images/default.jpg';
    }
    
    // Upload profile picture
    public function uploadProfileImage()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
            $targetDir = "uploads/ProfilePictures/";
            $fileName = basename($_FILES["profile_picture"]["name"]);
            $targetFile = $targetDir . $fileName;
    
            if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
                $this->AdminModel->updateProfileImage($_SESSION['user_id'], $targetFile);
                Redirect('AdminController/ManageProfile');
            } else {
                echo "Error uploading file.";
            }
        }
    }

    public function UserControl(){
       $data = [];

        $this->View('Admin/UserControl',$data);
    }

    public function getAllUsers(){
        $users = $this->AdminModel->getAllUsers();
        echo json_encode($users);
    }
    


    public function RemoveUsers(){
     
        // Retrieve users from the model
        $users = $this->AdminModel->getUnrestrictedtUsers();

        // Pass the user data to the view
        $data = ['users' => $users];
        

        $this->View('Admin/RemoveUsers',$data);
    }



    public function verifyUser($id){
        if($this->AdminModel->verifyUser($id)){
            Redirect('AdminController/getManufacturers');
        }else{  
            die('Something went wrong');
        }
    }

 
  

    public function RestrictUser($user_id) {
      
        // Sanitize the ID
        $user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);

        if($_SESSION['user_id'] == $user_id){
            die('You cannot Restrict yourself');
        }
    
        // Call the model function to delete the user
        if ($this->AdminModel->RestrictUser($user_id)) {
            // Redirect after successful deletion
            Redirect('AdminController/UserControl');
        } else {
            // Handle error if deletion fails
            die('Something went wrong while deleting the user.');
        }
    }

    public function ActivateUser($user_id) {
      
        // Sanitize the ID
        $user_id = filter_var($user_id, FILTER_SANITIZE_NUMBER_INT);
    
        // Call the model function to delete the user
        if ($this->AdminModel->ActivateUser($user_id)) {
            // Redirect after successful deletion
            Redirect('AdminController/UserControl');
        } else {
            // Handle error if deletion fails
            die('Something went wrong while deleting the user.');
        }
    }
    




    public function UserCount($title){
        $count = $this->AdminModel->getUserCount($title);
        return $count;
    }

    public function UpdateUserDetails($id){
      

        $user = $this->AdminModel->getUserById($id);
        $data = [
            'user_id' => $user->user_id,
            'name' => $user->name,
            'email' => $user->email,
            'phone' => $user->phone,
            'user_type' => $user->user_type,
            'password' => '',
            'confirm_password' => '',
            'name_err' => '',
            'email_err' => '',
            'phone_err' => '',
            'user_type_err' => '',
            'password_err' => '',
            'confirm_password_err' => ''
        ];

        $this->View('Admin/UpdateUserDetails',$data);
    }

    public function SubmitUserDetails($user_id){
        

      $user = $this->AdminModel->getUserById($user_id);
       
      
        if($_SERVER['REQUEST_METHOD'] == 'POST'){
            $_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
            $data = [
                'user_id' => trim($_POST['user_id']),
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'user_type' => trim($_POST['user_type']),
                'password' => trim($_POST['password']),
                'name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'user_type_err' => '',
                'password_err' => ''
            ];
            if(empty($data['name'])){
                $data['name_err'] = 'Please enter a username';
            }

            if(empty($data['email'])){
                $data['email_err'] = 'Please enter an email';
            }
            else{
                if($this->AdminModel->findUserByEmail($data['email'])){

                    if($data['email'] !== $user->email){
                        $data['email_err'] = 'Email is already taken';
                    }
                   
                }
            }

            if(empty($data['phone'])){
                $data['phone_err'] = 'Please enter a contact number';
            }

           

            if(empty($data['name_err']) && empty($data['email_err']) && empty($data['phone_err']) ){
                if(!empty($data['password'])){
                $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
                }

                if($this->AdminModel->updateUser($data)){
                    Redirect('AdminController/UserControl');
                }else{
                    die('Something went wrong');
                }
            }else{
                $this->View('Admin/UpdateUserDetails',$data);
            }
    }
    
    
}

    public function ModeratorControl(){

        $data = [];
        $this->view('Admin/ModeratorControl',$data);
    }

    public function getAllModerators(){
        $moderators = $this->AdminModel->getAllModerators();
        echo json_encode($moderators);
    }

    public function AddModerator(){
      
        
        $_POST = filter_input_array(INPUT_POST,FILTER_SANITIZE_STRING);

        if($_SERVER['REQUEST_METHOD'] == 'POST')
        {

            $data = [
                'name' => trim($_POST['name']),
                'email' => trim($_POST['email']),
                'phone' => trim($_POST['phone']),
                'password' => trim($_POST['password']),
                'name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'password_err' => ''
            ];

            if(empty($data['name'])){
                $data['name_err'] = 'Please enter a username';
            }

            if(empty($data['email'])){
                $data['email_err'] = 'Please enter an email';
            }
            else{
                if($this->AdminModel->findUserByEmail($data['email'])){
                    $data['email_err'] = 'Email is already taken';
                }
            }

            if(empty($data['phone'])){
                $data['phone_err'] = 'Please enter a contact number';
            }
            else{
                if($this->AdminModel->FindUserByPhone($data['phone'])){
                    $data['phone_err'] = 'Contact number is already taken';
                }
            }




            if(empty($data['password'])){
                $data['password_err'] = 'Please enter a password';
            }

            if(empty($data['name_err']) && empty($data['email_err']) && empty($data['phone_err']) && empty($data['password_err'])){
                $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
                if($this->AdminModel->AddModerator($data)){
                    Redirect('AdminController/ModeratorControl');
                }else{
                    die('Something went wrong');
                }
            }else{
                $this->view('Admin/AddModerator',$data);
            }


        }

        else{
            $data = [
                'name' => '',
                'email' => '',
                'phone' => '',
                'password' => '',
                'name_err' => '',
                'email_err' => '',
                'phone_err' => '',
                'password_err' => ''
            ];

            $this->view('Admin/AddModerator',$data);

        }

       
    }

    public function getPendingUsers(){
        $users = $this->AdminModel->getPendingUsers();
        echo json_encode($users);
    }

    public function VerifyUsers(){
        $data = [];
        $this->view('Admin/VerifyUsers',$data);
    }


    public function Report() {
      
    
        // Get all users from the model
        $users = $this->AdminModel->getUsers();
    
        // If the user requested a CSV report
       
            $this->generateCSV($users); // Generate CSV
   
    
        // Pass data to the view for display
        $data = ['users' => $users];
        $this->view('Admin/Report', $data);
    }
    
    // Helper function to generate and download CSV
    private function generateCSV($users) {
        // File name
        $fileName = 'User_Report_' . date('Y-m-d_H-i-s') . '.csv';
    
        // Set headers for CSV download
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $fileName . '"');
    
        // Open output stream
        $output = fopen('php://output', 'w');
    
        // Write column headers to CSV
        fputcsv($output, ['ID', 'Name', 'Email', 'Phone', 'Created At']);
    
        // Write user data to CSV
        foreach ($users as $user) {
            fputcsv($output, [
                $user->id,
                $user->name,
                $user->email,
                $user->phone,
                $user->created_at
            ]);
        }
    
        // Close output stream
        fclose($output);
        exit; // Stop further script execution after sending the file
    }

    public function Ratings(){

        // Fetch ratings from the model
        $ratings = $this->AdminModel->getRatings();
        
        $rating_merged = array_merge($ratings['farmer_reviews_worker'], $ratings['buyer_reviews_farmer']);
        // Pass the ratings data to the view
        $data = ['ratings' => $rating_merged];

        $this->View('Admin/Ratings',$data);
    }

    public function ApproveWorkerReview($id){
        if($this->AdminModel->ApproveWorkerReview($id)){
            Redirect('AdminController/Ratings');
        }else{
            die('Something went wrong');
        }
    }
   
    public function ApproveProductReview($id){
        if($this->AdminModel->ApproveProductReview($id)){
            Redirect('AdminController/Ratings');
        }else{
            die('Something went wrong');
        }
    }

    public function RejectWorkerReview($id){
        if($this->AdminModel->RejectWorkerReview($id)){
            Redirect('AdminController/Ratings');
        }else{
            die('Something went wrong');
        }
    }

    public function RejectProductReview($id){
        if($this->AdminModel->RejectProductReview($id)){
            Redirect('AdminController/Ratings');
        }else{
            die('Something went wrong');
        }
    }
 
    


}

?>
