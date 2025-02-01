<?php 

class WorkerController extends Controller {
    private $WorkerModel;

    public function __construct() {  
        if (!$this->isloggedin()) {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            Redirect('LandingController/login');
        } 
        $this->WorkerModel = $this->model('Worker');
    }

    public function isloggedin() {
        if (isset($_SESSION['user_id']) && ($_SESSION['user_role']=='farmworker')){
            return true;
        } else {
            return false;
        }
    }

    public function Dashboard() {
        $data = [];
        $this->view('FarmWorker/Dashboard', $data);
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
                'bio'   => trim($_POST['bio']),
                'password' => trim($_POST['password']),
                'name_err' => '',
                'phone_err' => '',
                'address_err' => '',
                'email_err' => '',
                'bio_err' => ''
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

            if(empty($data['bio'])){
                $data['bio_err'] = 'Please input a bio';
            }

           
            

            if(empty($data['name_err']) && empty($data['phone_err'])  && empty($data['email_err']) && empty($data['bio_err']) ){
                echo 'Profile Updated';
                if(!empty($data['password'])){
                    $data['password'] = password_hash($data['password'],PASSWORD_DEFAULT);
                    }
                
                $result = $this->WorkerModel->UpdateProfile($data);
              
                if($result){
                    Redirect('LandingController/logout');
                }
            }else{
                $this->view('FarmWorker/ManageProfile',$data);
            }
        
            }
            else{
                $user=$this->WorkerModel->getUserById($_SESSION['user_id']);
                $data = [
                    'name' => $user->name,
                    'phone' => $user->phone,
                    'email' => $user->email,
                    'bio' => $user->bio,
                    'password' => '',
                    'name_err' => '',
                    'phone_err' => '',
                    'email_err' => '',
                    'password_err' => ''
                ];
                $this->view('FarmWorker/ManageProfile',$data);
                
            }
    }

    // Get profile image URL
    public function getProfileImage($user_id) {
        $imagePath = $this->WorkerModel->getProfileImage($_SESSION['user_id']);
        return $imagePath ? URLROOT .'/'.$imagePath : URLROOT . '/images/default.jpg';
    }

    public function uploadProfileImage() {

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['profile_picture'])) {
    $targetDir = "uploads/ProfilePictures/";
    $fileName = basename($_FILES["profile_picture"]["name"]);
    $targetFile = $targetDir . $fileName;

    if (move_uploaded_file($_FILES["profile_picture"]["tmp_name"], $targetFile)) {
        $uploadResult = $this->WorkerModel->updateProfileImage($_SESSION['user_id'], $targetFile);
       Redirect('WorkerController/ManageProfile');
        // Update user's profile picture in the database here
    } else {
        echo "Error uploading file.";
    }
}

    }


 


    public function save() {
        $data = [
            'name' => $_POST['name'],
            'email' => $_POST['email'],
            'password' => $_POST['password']
        ];
        $this->workerModel->addWorker($data);
        $this->view('FarmWorker/Worker Management');
    }

    public function edit($id) {
        $worker = $this->workerModel->getWorker($id);
        $this->view('FarmWorker/Edit Worker', ['worker' => $worker]);
    }

    public function update($id) {
        $worker = $this->workerModel->getWorker($id);
        $this->view('FarmWorker/Edit Worker', ['worker' => $worker]);
    }

    public function delete($id) {
        $this->workerModel->deleteWorker($id);
        $this->view('FarmWorker/Worker Management');
    }  

    public function RequestHelp() {
        $data = [];
        $this->view('FarmWorker/RequestHelp', $data);
    }

    public function jobDescription() {

       
        $this->view('FarmWorker/JobDescription');
    }

    public function jobRequest() {
        $data['jobRequests'] = $this->WorkerModel->getJobRequests($_SESSION['user_id']);
    
       
        $this->view('FarmWorker/JobRequest',$data);
        
    }

    public function ViewRequest($job_id) {
        $requests =  $this->WorkerModel->ViewRequest($job_id);
        $data= $requests[0];
        $this->view('FarmWorker/ViewRequest', $data);
    }
    

    public function trainingSelection() {
        $this->view('FarmWorker/TrainingSelection');
    }
 
 



}






