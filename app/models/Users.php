<?php

class Users {
  
    private $db;

    public function __construct(){
        $this->db = new Database();
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

    public function getUserById ($id){
        $this->db->query('SELECT * FROM users WHERE id = :id');
        $this->db->bind(':id',$id);
        $row = $this->db->single();
        return $row;
    }

    public function register($data){
        $this->db->query('INSERT INTO users (name,email,phone,address,status,title,password) VALUES (:name,:email,:phone,:address,:status,:title,:password)');
        $this->db->bind(':name',$data['name']);
        $this->db->bind(':email',$data['email']);
        $this->db->bind(':phone',$data['phone']);
        $this->db->bind(':address',$data['address']);
        $this->db->bind(':status','verified');
        $this->db->bind(':title',$data['title']);
        $this->db->bind(':password',$data['password']);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function RegisterManufacturer($data){
        $this->db->query('INSERT INTO users (name,email,phone,verification_document,title,password) VALUES (:name,:email,:phone,:verification_document,:title,:password)');
        $this->db->bind(':name',$data['name']);
        $this->db->bind(':email',$data['email']);
        $this->db->bind(':phone',$data['phone']);
        $this->db->bind(':verification_document',$data['document']);
        $this->db->bind(':title','manufacturer');
        $this->db->bind(':password',$data['password']);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function getUsers() {
        // Prepare a query to fetch all users
        $this->db->query('SELECT * FROM users');
        
        // Execute the query
        $this->db->execute();
    
        // Fetch all users as an array of objects
        return $this->db->resultSet();
    }

    public function FindModerators(){

        $this->db->query('SELECT * FROM users WHERE title = :title');
        $this->db->bind(':title', 'moderator');
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
        $this->db->query('SELECT * FROM users WHERE email = :email');
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
        $this->db->query('SELECT * FROM users WHERE title = :title');
        $this->db->bind(':title', $title);
        $this->db->execute(); // Executes the query
        return $this->db->rowCount(); // Returns the number of rows
    }

    public function updateUser($data) {
        if (!empty($data['password'])) {
            // Include password in the update query
            $this->db->query('UPDATE users SET name = :name, email = :email, phone = :phone, title = :title, password = :password WHERE id = :id');
            $this->db->bind(':password', $data['password']);
        } else {
            // Exclude password from the update query
            $this->db->query('UPDATE users SET name = :name, email = :email, phone = :phone, title = :title WHERE id = :id');
        }
    
     
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
        $this->db->bind(':title', $data['title']);
    

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    

    public function AddModerators($data){
        $this->db->query('INSERT INTO users (name,email,phone,title,password) VALUES (:name,:email,:phone,:title,:password)');
        $this->db->bind(':name',$data['name']);
        $this->db->bind(':email',$data['email']);
        $this->db->bind(':phone',$data['phone']);
        $this->db->bind(':title','moderator');
        $this->db->bind(':password',$data['password']);
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

    public function  verifyUser($id){
        $this->db->query('UPDATE users SET status = :status WHERE id = :id');
        $this->db->bind(':status','verified');
        $this->db->bind(':id',$id);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }

    public function getManufacturers(){
        $this->db->query('SELECT * FROM users WHERE title = :title AND status = :status');
        $this->db->bind(':title','manufacturer');
        $this->db->bind(':status','unverified');
        $this->db->execute();
        return $this->db->resultSet();
    }
    

}

?>
