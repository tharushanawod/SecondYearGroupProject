<?php

class Worker {
  
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getUserById($id) {
        $this->db->query('
            SELECT users.*, farmworkers.bio 
            FROM users
            LEFT JOIN farmworkers
            ON users.user_id = farmworkers.user_id
            WHERE users.user_id = :id
        ');
        $this->db->bind(':id', $id);
        $row = $this->db->single(); // Fetch the result
        return $row;
    }
    

    public function UpdateProfile($data) {
        try {
            $this->db->beginTransaction(); // Start a transaction
            
            // Update the users table
            if (!empty($data['password'])) {
                $this->db->query('UPDATE users SET name = :name, email = :email, phone = :phone, password = :password WHERE user_id = :id');
                $this->db->bind(':password', $data['password']);
            } else {
                $this->db->query('UPDATE users SET name = :name, email = :email, phone = :phone WHERE user_id = :id');
            }
    
            $this->db->bind(':id', $data['user_id']);
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':phone', $data['phone']);
            
            if (!$this->db->execute()) {
                throw new Exception('Failed to update users table');
            }
    
            // Update the farmworkers table
            $this->db->query('UPDATE farmworkers SET bio = :bio WHERE user_id = :id');
            $this->db->bind(':bio', $data['bio']);
            $this->db->bind(':id', $data['user_id']);
            
            if (!$this->db->execute()) {
                throw new Exception('Failed to update farmworkers table');
            }
    
            $this->db->commit(); // Commit the transaction
            return true;
    
        } catch (Exception $e) {
            $this->db->rollBack(); // Rollback the transaction in case of an error
            return false;
        }
    }
    


     // Get profile image path by user ID
     public function getProfileImage($userId) {
        $this->db->query("SELECT file_path FROM profile_pictures WHERE user_id = :userId");
        $this->db->bind(':userId', $userId);
        $row = $this->db->single();

        if($row){
            return $row->file_path;
        } else {
            return false;
        }
       
    }


     // Update or Insert profile image path in the database
    public function updateProfileImage($userId, $imagePath) {
        // Check if a record already exists for the user
        $this->db->query("SELECT id FROM profile_pictures WHERE user_id = :userId");
        $this->db->bind(':userId', $userId);
        $row = $this->db->single();

        if ($row) {
            // Update existing record
            $this->db->query("UPDATE profile_pictures SET file_path = :imagePath WHERE user_id = :userId");
            $this->db->bind(':imagePath', $imagePath);
            $this->db->bind(':userId', $userId);
        } else {
            // Insert new record
            $this->db->query("INSERT INTO profile_pictures (user_id, file_path) VALUES (:userId, :imagePath)");
            $this->db->bind(':userId', $userId);
            $this->db->bind(':imagePath', $imagePath);
        }

        return $this->db->execute();
    }

    public function getWorkers(){
        $this->db->query('SELECT * FROM workers');
        return $this->db->resultSet();
    }

    public function getWorker($id){
        $this->db->query('SELECT * FROM workers WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addWorker($data){
        $this->db->query('INSERT INTO workers (name, email, password) VALUES (:name, :email, :password)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        return $this->db->execute();
    }

    public function updateWorker($data){
        $this->db->query('UPDATE workers SET name = :name, email = :email, password = :password WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':password', $data['password']);
        return $this->db->execute();
    }

    public function deleteWorker($id){
        $this->db->query('DELETE FROM workers WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getJobRequests($userId) {
        try {
            $this->db->query('SELECT users.name, profile_pictures.file_path, job_requests.created_at,job_requests.job_id
                FROM job_requests
                INNER JOIN users ON job_requests.farmer_id = users.user_id
                LEFT JOIN profile_pictures ON users.user_id = profile_pictures.user_id
                WHERE job_requests.worker_id = :userId AND job_requests.status = "Pending"');
    
            $this->db->bind(':userId', $userId);
            
            $result = $this->db->resultSet();
            return $result;
        } catch (Exception $e) {
            die("SQL Error: " . $e->getMessage()); // Stop execution & show error
        }
    }

    public function ViewRequest($job_id) {
        try {
            $this->db->query('SELECT *
                FROM job_requests
                WHERE job_requests.job_id = :job_id');
    
            $this->db->bind(':job_id', $job_id);
            
            $result = $this->db->resultSet();
            return $result;
        } catch (Exception $e) {
            die("SQL Error: " . $e->getMessage()); // Stop execution & show error
        }
    }

    public function AcceptJob($job_id) {
        try {
           
            // Update the job_requests table
            $this->db->query('UPDATE job_requests SET status = "Confirmed" WHERE job_id = :job_id');
            $this->db->bind(':job_id', $job_id);
           
            $this->db->execute();
            return true;
    
        } catch (Exception $e) {
            die("SQL Error: " . $e->getMessage()); // Stop execution & show error
        }
    }

    public function RejectJob($job_id) {
        try {
           
            // Update the job_requests table
            $this->db->query('UPDATE job_requests SET status = "Rejected" WHERE job_id = :job_id');
            $this->db->bind(':job_id', $job_id);
           
            $this->db->execute();
            return true;
    
        } catch (Exception $e) {
            die("SQL Error: " . $e->getMessage()); // Stop execution & show error
        }
    }

    public function DoList($userId){
        try {
            $this->db->query('SELECT users.name, profile_pictures.file_path, job_requests.updated_at,job_requests.job_id
                FROM job_requests
                INNER JOIN users ON job_requests.farmer_id = users.user_id
                LEFT JOIN profile_pictures ON users.user_id = profile_pictures.user_id
                WHERE job_requests.worker_id = :userId AND job_requests.status = "Confirmed"');
    
            $this->db->bind(':userId', $userId);
            
            $result = $this->db->resultSet();
            return $result;
        } catch (Exception $e) {
            die("SQL Error: " . $e->getMessage()); // Stop execution & show error
        }
    }

    public function getAcceptedJobCount($userId){
        try {
            $this->db->query('SELECT COUNT(job_id) as count
                FROM job_requests
                WHERE worker_id = :userId AND status = "Confirmed"');
    
            $this->db->bind(':userId', $userId);
            
            $result = $this->db->single();
            return $result->count;
        } catch (Exception $e) {
            die("SQL Error: " . $e->getMessage()); // Stop execution & show error
        }
    }

    public function getPendingJobCount($userId){
        try {
            $this->db->query('SELECT COUNT(job_id) as count
                FROM job_requests
                WHERE worker_id = :userId AND status = "Pending"');
    
            $this->db->bind(':userId', $userId);
            
            $result = $this->db->single();
            return $result->count;
        } catch (Exception $e) {
            die("SQL Error: " . $e->getMessage()); // Stop execution & show error
        }
    }
    
}








