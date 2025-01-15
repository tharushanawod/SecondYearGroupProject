<?php

class Farmer {
    
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getInventory(){
        $this->db->query('SELECT * FROM inventory');
        $results = $this->db->resultSet();
        return $results;
    }

    public function AddProduct($data) {
        $this->db->query('INSERT INTO corn_products (starting_price,quantity, media, closing_date, user_id) 
        VALUES(:starting_price,:quantity, :media, :closing_date, :user_id)');
        $this->db->bind(':starting_price', $data['price']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':media', $data['media']);
        $this->db->bind(':closing_date', $data['closing_date']); 
        $this->db->bind(':user_id', $data['user_id']);
    
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function getProducts($id){
        $this->db->query('SELECT * FROM corn_products WHERE product_id = :id');
        $this->db->bind(':id', $id);
        $result = $this->db->single();
        return $result;
    }
    

    public function editProduct($data) {
        $this->db->query('UPDATE products 
            SET type = :type, 
                price = :price, 
                quantity = :quantity, 
                media = :media, 
                expiry_date = :expiry_date, 
                userid = :userid 
            WHERE productid = :id');
    
        // Bind parameters to query
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':media', $data['media']);
        $this->db->bind(':expiry_date', $data['expiry_date']);
        $this->db->bind(':userid', $data['userid']);
        $this->db->bind(':id', $data['id']); // Bind the product ID to :id
    
        // Execute the query and return the result
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }
    
   

    public function getOrders(){
        $this->db->query('SELECT * FROM orders');
        $results = $this->db->resultSet();
        return $results;
    }

    public function getWorkers(){
        $this->db->query('SELECT * FROM workers');
        $results = $this->db->resultSet();
        return $results;
    }      

    public function purchaseIngredients($data){
        $this->db->query('INSERT INTO ingredients (ingredient_name, quantity, price) VALUES(:ingredient_name, :quantity, :price)');
        $this->db->bind(':ingredient_name', $data['ingredient_name']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':price', $data['price']);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function getProductsByFarmerId($farmerId) {
        $this->db->query('SELECT * FROM corn_products WHERE user_id = :userid');
        $this->db->bind(':userid', $farmerId);
        return $this->db->resultSet(); // Fetch all products
    }

    public function deleteProduct($id){
        $this->db->query('DELETE FROM corn_products WHERE product_id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function getFarmworkers() {
        try {
           

            // Query the database to fetch all farmworkers
            $this->db->query(' SELECT *
FROM users
INNER JOIN farmworkers ON users.user_id = farmworkers.user_id
INNER JOIN profile_pictures ON farmworkers.user_id = profile_pictures.user_id


');


            $workers = $this->db->resultSet();
            
    
            // // Convert skills from JSON to an array for each worker
            // foreach ($workers as &$worker) {
            //     $worker['skills'] = json_decode($worker['skills'], true); // Decode JSON into an associative array
            // }
           
            
           
            
            // Set header for JSON response
            header('Content-Type: application/json; charset=utf-8');
    
            // Return the workers as a JSON response
            echo json_encode($workers);
        } catch (Exception $e) {
            // Handle any exceptions and return an error response
            http_response_code(500); // Set HTTP response code to 500 for server error
            echo json_encode(['error' => 'Failed to fetch farmworkers: ' . $e->getMessage()]);
        }
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


    public function getUserById ($id){
        $this->db->query('SELECT * FROM users WHERE user_id = :id');
        $this->db->bind(':id',$id);
        $row = $this->db->single();
        return $row;
    }
    

    
}




?>

