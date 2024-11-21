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
        $this->db->query('INSERT INTO products (type, price, quantity, media, expiry_date, userid) 
        VALUES(:type, :price, :quantity, :media, :expiry_date, :userid)');
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':media', $data['media']);
        $this->db->bind(':expiry_date', $data['expiry_date']); 
        $this->db->bind(':userid', $data['userid']);
    
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function getProducts($id){
        $this->db->query('SELECT * FROM products WHERE productid = :id');
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
        $this->db->query('SELECT * FROM products WHERE userid = :userid');
        $this->db->bind(':userid', $farmerId);
        return $this->db->resultSet(); // Fetch all products
    }

    public function deleteProduct($id){
        $this->db->query('DELETE FROM products WHERE productid = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }
    

    
}
?>

