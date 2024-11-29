<?php 

class WorkerController extends Controller {
    private $workerModel;

    public function __construct() {  
        if (!$this->isloggedin()) {
            unset($_SESSION['user_id']);
            unset($_SESSION['user_email']);
            unset($_SESSION['user_name']);
            session_destroy();
            Redirect('LandingController/login');
        } 
        $this->workerModel = $this->model('Worker');
    }

    public function isloggedin() {
        if (isset($_SESSION['user_id']) && ($_SESSION['user_role']=='worker')){
            return true;
        } else {
            return false;
        }
    }

    public function dashboard() {
        $data = [];
        $this->view('FarmWorker/Dashboard', $data);
    }

    public function landingPage() {
        $data = [];
        $this->view('FarmWorker/Landing Page', $data);
    }

    public function workerManagement() {
        $workers = $this->workerModel->getWorkers();
        $this->view('FarmWorker/Worker Management', ['workers' => $workers]);
    }

    public function add() {
        $this->view('FarmWorker/Add Worker');
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

    public function requestHelp() {
        $data = [];
        $this->view('FarmWorker/Contact us', $data);
    }

    public function jobDescription() {
        $this->view('FarmWorker/JobDescription');
    }

    public function jobRequest() {
        $this->view('FarmWorker/JobRequest');
    }

    public function trainingSelection() {
        $this->view('FarmWorker/TrainingSelection');
    }

    public function manageProfile() {
        $this->view('FarmWorker/ManageProfile');
    }



}






