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
INNER JOIN farmworkers
ON users.user_id = farmworkers.user_id');
            $workers = $this->db->resultSet();
            print_r($workers);
    
            // Convert skills from JSON to an array for each worker
            // foreach ($workers as &$worker) {
            //     $worker['skills'] = json_decode($worker['skills'], true); // Decode JSON into an associative array
            // }
            $jsonString = '{"name": "Sarah", "age": 30, "skills": ["PHP", "JavaScript"]}';
            $result = json_decode($jsonString);
            
            print_r($result);
            
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
    
    

    
}
?>

