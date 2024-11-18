<?php

class Users {
    //hama ekema me kalla thiyenna one
    private $db;

    public function __construct(){
        $this->db = new Database();
    }
// methanata
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

    public function register($data){
        $this->db->query('INSERT INTO users (name,email,phone,title,password) VALUES (:name,:email,:phone,:title,:password)');
        $this->db->bind(':name',$data['name']);
        $this->db->bind(':email',$data['email']);
        $this->db->bind(':phone',$data['phone']);
        $this->db->bind(':title',$data['title']);
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

    public function deleteuser($id){
        $this->db->query('DELETE FROM users WHERE id = :id');
        $this->db->bind(':id',$id);
        if($this->db->execute()){
            return true;
        }else{
            return false;
        }
    }
    

}

?>
