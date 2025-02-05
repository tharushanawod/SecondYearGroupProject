<?php

class Buyer {
    
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getProducts(){
        $this->db->query('SELECT * FROM products');
        $results = $this->db->resultSet();
        return $results;
    }

    public function placeBid($data){
        $this->db->query('INSERT INTO bids (product_id, buyer_id, bid_amount) VALUES(:product_id, :buyer_id, :bid_amount)');
        $this->db->bind(':product_id', $data['product_id']);
        $this->db->bind(':buyer_id', $data['buyer_id']);
        $this->db->bind(':bid_amount', $data['bid_amount']);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function getBids(){
        $this->db->query('SELECT * FROM bids');
        $results = $this->db->resultSet();
        return $results;
    }

    public function deleteBid($id){
        $this->db->query('DELETE FROM bids WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function getFeedbacks(){
        $this->db->query('SELECT * FROM feedbacks');
        $results = $this->db->resultSet();
        return $results;
    }

    public function addFeedback($data){
        $this->db->query('INSERT INTO feedbacks (buyer_id, feedback) VALUES(:buyer_id, :feedback)');
        $this->db->bind(':buyer_id', $data['buyer_id']);
        $this->db->bind(':feedback', $data['feedback']);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function deleteFeedback($id){
        $this->db->query('DELETE FROM feedbacks WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function getUserById ($id){
        $this->db->query('SELECT * FROM users WHERE user_id = :id');
        $this->db->bind(':id',$id);
        $row = $this->db->single();
        return $row;
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

    //model function to add bank account
    public function AddBankAccount($data){


        try {
            // Start a transaction
            $this->db->beginTransaction();
            $this->db->query('SELECT user_id FROM bank_accounts WHERE user_id = :userId');
            $this->db->bind(':userId', $data['user_id']);
            $row = $this->db->single();
            $this->db->execute();
        
            

            if($row){
               // Update bank account details
            $this->db->query('UPDATE bank_accounts 
            SET bank_name = :bank_name, account_number = :account_number
            WHERE user_id = :user_id');
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':bank_name', $data['bank_name']);
            $this->db->bind(':account_number', $data['account_number']);
            $this->db->execute();

            // Update card details
            $this->db->query('UPDATE carddetails 
            SET name_on_card = :name_on_card, card_number = :card_number, expiry_date = :expiry_date, cvv = :cvv
            WHERE user_id = :user_id');
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':name_on_card', $data['name_on_card']);
            $this->db->bind(':card_number', $data['card_number']);
            $this->db->bind(':expiry_date', $data['expiry_date']);
            $this->db->bind(':cvv', $data['cvv']);
            $this->db->execute();

            } else {
                $this->db->query('INSERT INTO bank_accounts (user_id, bank_name, account_number) VALUES(:user_id, :bank_name, :account_number)');
                $this->db->bind(':user_id', $data['user_id']);
                $this->db->bind(':bank_name', $data['bank_name']);
                $this->db->bind(':account_number', $data['account_number']);
                $this->db->execute();
        
                $this->db->query('INSERT INTO carddetails (user_id,name_on_card, card_number, expiry_date, cvv) VALUES(:user_id, :name_on_card,:card_number, :expiry_date, :cvv)');
                $this->db->bind(':user_id', $data['user_id']);
                $this->db->bind(':name_on_card', $data['name_on_card']);
                $this->db->bind(':card_number', $data['card_number']);
                $this->db->bind(':expiry_date', $data['expiry_date']);
                $this->db->bind(':cvv', $data['cvv']);
                $this->db->execute();
            }
        
          
        
            // Commit transaction
            $this->db->commit();
            return true;
        
        } catch (Exception $e) {
            // Rollback if something goes wrong
            $this->db->rollBack();
            die('Registration failed: ' . $e->getMessage());
        }
       
    }

    public function GetBankAndCardDetails($id) {
        // Perform an SQL JOIN to combine the data from both tables
        $this->db->query('
            SELECT bank_accounts.*, carddetails.*
            FROM bank_accounts
            LEFT JOIN carddetails ON bank_accounts.user_id = carddetails.user_id
            WHERE bank_accounts.user_id = :id
        ');
        
        // Bind the user ID
        $this->db->bind(':id', $id);
    
        // Execute the query and get the results
        $result = $this->db->single(); // Get the combined result of the JOIN
        
        return $result; // Return the combined result
    }
    

}
?>