<?php

class Users {
  
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function UpdateProfile($data) {
        if (!empty($data['password'])) {
            // Include password in the update query
            $this->db->query('UPDATE users SET name = :name, email = :email, phone = :phone,  password = :password WHERE user_id = :id');
            $this->db->bind(':password', $data['password']);
        } else {
            // Exclude password from the update query
            $this->db->query('UPDATE users SET name = :name, email = :email, phone = :phone WHERE user_id = :id');
        }
    
     
        $this->db->bind(':id', $data['user_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
       
    

        if ($this->db->execute()) {
            return true;
        } else {
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

    public function finduserbyemail($email){
        $this->db->query('SELECT * FROM users WHERE email = :email');
        $this->db->bind(':email',$email);
        $row = $this->db->single();
        if($this->db->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function FindUserByPhone($phone){
        $this->db->query('SELECT * FROM users WHERE phone = :phone');
        $this->db->bind(':phone',$phone);
        $row = $this->db->single();
        if($this->db->rowCount() > 0){
            return true;
        }else{
            return false;
        }
    }

    public function getUserById ($id){
        $this->db->query('SELECT * FROM users WHERE user_id = :id');
        $this->db->bind(':id',$id);
        $row = $this->db->single();
        return $row;
    }

    public function register($data) {
        try {
            // Start a transaction
            $this->db->beginTransaction();
        
            // Insert into the users table
            $this->db->query('INSERT INTO users (name, email, phone, otp_status, user_status, user_type, password) 
                              VALUES (:name, :email, :phone, :otp_status, :user_status, :user_type, :password)');
            $this->db->bind(':name', $data['name']);
            $this->db->bind(':email', $data['email']);
            $this->db->bind(':phone', $data['phone']);
            $this->db->bind(':user_type', $data['user_type']);
            $this->db->bind(':password', $data['password']);
            $this->db->bind(':user_status', 'pending');
            $this->db->bind(':otp_status', 'unverified');
            $this->db->execute();
        
            $userId = $this->db->lastInsertId();
    
            // Insert into specific user table
            switch ($data['user_type']) {
                case 'supplier':
                    $this->db->query('INSERT INTO suppliers (supplier_id, document_path) VALUES (:user_id, :document_path)');
                    $this->db->bind(':user_id', $userId);
                    $this->db->bind(':document_path', $data['document']);
                    $this->db->execute();
                    break;
    
                case 'farmer':
                    $this->db->query('INSERT INTO farmers (user_id, address, district) 
                                      VALUES (:user_id, :address, :district)');
                    $this->db->bind(':user_id', $userId);
                    $this->db->bind(':address', $data['address']);
                    $this->db->bind(':district', $data['district']);
                    $this->db->execute();
                    break;
    
                case 'farmworker':
                    $this->db->query('INSERT INTO farmworkers (user_id, working_area, skills, hourly_rate) 
                                      VALUES (:user_id, :working_area, :skills, :hourly_rate)');
                    $this->db->bind(':user_id', $userId);
                    $this->db->bind(':working_area', $data['working_area']);
                    $this->db->bind(':skills', implode(',', $data['skills']));
                    $this->db->bind(':hourly_rate', $data['hourly_rate']);
                    $this->db->execute();
                    break;
    
                case 'manufacturer':
                    $this->db->query('INSERT INTO manufacturers (user_id, company_name, document_path) 
                                      VALUES (:user_id, :company_name, :document_path)');
                    $this->db->bind(':user_id', $userId);
                    $this->db->bind(':company_name', $data['company_name']);
                    $this->db->bind(':document_path', $data['document']);
                    $this->db->execute();
                    break;
            }
    
            // Create wallet for users who need it
            if (in_array($data['user_type'], ['farmer', 'buyer', 'supplier', 'manufacturer'])) {
                $this->db->query('INSERT INTO wallets (user_id, balance) VALUES (:user_id, 0.00)');
                $this->db->bind(':user_id', $userId);
                $this->db->execute();
            }
    
            // Set verified status for some users
            if (in_array($data['user_type'], ['farmer', 'farmworker', 'buyer'])) {
                $this->db->query('UPDATE users SET user_status = :user_status WHERE user_id = :id');
                $this->db->bind(':user_status', 'verified');
                $this->db->bind(':id', $userId);
                $this->db->execute();
            }
        
            $this->db->commit();
            return true;
    
        } catch (Exception $e) {
            $this->db->rollBack();
            die('Registration failed: ' . $e->getMessage());
        }
    }
    

    public function VerifyUsers($data){
        $this->db->query('UPDATE users SET otp_status = :status WHERE email = :email');
        $this->db->bind(':status','verified');
        $this->db->bind(':email',$data['email']);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }


    public function getAllUsers() {
        // Prepare a query to fetch all users except those with the title 'admin'
        $this->db->query("SELECT * FROM users WHERE user_type != 'admin'");
        
        // Execute the query
        $this->db->execute();
    
        // Fetch all users as an array of objects
        return $this->db->resultSet();
    }
    

    public function getAllModerators(){

        $this->db->query('SELECT * FROM users WHERE user_type = :user_type');
        $this->db->bind(':user_type', 'moderator');
        $this->db->execute(); // Executes the query
        return $this->db->resultSet(); // Returns the result set
    }

    public function deleteuser($id){
        $this->db->query('DELETE FROM users WHERE id = :id');
        $this->db->bind(':id',$id);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    //login user
    public function login($email,$password){
        $this->db->query('
        SELECT users.*, profile_pictures.file_path 
        FROM users 
        LEFT JOIN profile_pictures 
        ON 
            users.user_id = profile_pictures.user_id
        WHERE 
            users.email = :email
        ');
        $this->db->bind(':email',$email);
        $row = $this->db->single();
        $hashed_password = $row->password;
        if(password_verify($password,$hashed_password)){
            return $row;
        }else{
            return false;
        }
    }
    
    public function getUserCount($title){
        $this->db->query('SELECT * FROM users WHERE user_type = :title');
        $this->db->bind(':title', $title);
        $this->db->execute(); // Executes the query
        return $this->db->rowCount(); // Returns the number of rows
    }

    public function updateUser($data) {
        if (!empty($data['password'])) {
            // Include password in the update query
            $this->db->query('UPDATE users SET name = :name, email = :email, phone = :phone, user_type = :user_type, password = :password WHERE user_id = :user_id');
            $this->db->bind(':password', $data['password']);
        } else {
            // Exclude password from the update query
            $this->db->query('UPDATE users SET name = :name, email = :email, phone = :phone, user_type = :user_type WHERE user_id = :user_id');
        }
    
     
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':user_type', $data['user_type']);
    

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    

    public function AddModerator($data){
        $this->db->query('INSERT INTO users (name,email,phone,user_type,password,user_status) VALUES (:name,:email,:phone,:user_type,:password,:user_staus)');
        $this->db->bind(':name',$data['name']);
        $this->db->bind(':email',$data['email']);
        $this->db->bind(':phone',$data['phone']);
        $this->db->bind(':user_type','moderator');
        $this->db->bind(':password',$data['password']);
        $this->db->bind(':user_staus','verified');
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function searchUsers($search){
        $this->db->query('SELECT * FROM users WHERE name LIKE :search OR email LIKE :search OR phone LIKE :search');
        $this->db->bind(':search', '%' . $search . '%');
        $this->db->execute(); // Executes the query
        return $this->db->resultSet(); // Returns the result set
    }


    public function getPendingUsers(){
        $this->db->query('SELECT * FROM users WHERE (user_type = :type1 OR user_type = :type2) AND user_status = :user_status');
        $this->db->bind(':type1', 'manufacturer');
        $this->db->bind(':type2', 'supplier'); // Corrected binding
        $this->db->bind(':user_status', 'pending');
        $this->db->execute();
        return $this->db->resultSet();
    }
    

    public function getUnrestrictedtUsers() {
        // Prepare a query to fetch all users except those with the title 'admin'
        $this->db->query("SELECT * FROM users WHERE status != 'restricted' AND title != 'admin'");
        
        // Execute the query
        $this->db->execute();
    
        // Fetch all users as an array of objects
        return $this->db->resultSet();
    }

    public function RestrictUser($user_id){
        $this->db->query('UPDATE users SET user_status = :status WHERE user_id = :user_id');
        $this->db->bind(':status','restricted');
        $this->db->bind(':user_id',$user_id);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function ActivateUser($user_id){
        $this->db->query('UPDATE users SET user_status = :status WHERE user_id = :user_id');
        $this->db->bind(':status','verified');
        $this->db->bind(':user_id',$user_id);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function AllowUser($id){
        $this->db->query('UPDATE users SET status = :status WHERE id = :id');
        $this->db->bind(':status','verified');
        $this->db->bind(':id',$id);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    


}

?>
