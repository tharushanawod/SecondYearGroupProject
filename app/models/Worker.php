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
}








