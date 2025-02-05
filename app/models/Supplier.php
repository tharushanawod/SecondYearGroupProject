<?php

class Supplier {
    
    private $db;

    public function __construct() {
        $this->db = new Database();
    }    

    public function addProduct($data) {
        $this->db->query('INSERT INTO products (product_name, category, price, stock) VALUES(:product_name, :category, :price, :stock)');
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':stock', $data['stock']);
        
        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }
    
    public function getProducts() {
        $this->db->query('SELECT * FROM products');
        return $this->db->resultSet();
    }

    public function getProductById($id) {
        $this->db->query('SELECT * FROM products WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateProduct($data) {
        $this->db->query('UPDATE products SET product_name = :product_name, category = :category, price = :price, stock = :stock WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':stock', $data['stock']);

        return $this->db->execute();
    }

    public function deleteProduct($id) {
        $this->db->query('DELETE FROM products WHERE id = :id');
        $this->db->bind(':id', $id);

        return $this->db->execute();
    }

    public function getProductsByCategory($category) {
        $this->db->query('SELECT * FROM products WHERE category = :category');
        $this->db->bind(':category', $category);
        return $this->db->resultSet();
    }

    public function updateProductDetails($data) {
        $this->db->query('UPDATE products SET product_name = :product_name, category = :category, price = :price, stock = :stock, description = :description, image = :image WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':stock', $data['stock']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':image', $data['image']);

        return $this->db->execute();
    }

    public function getOrders() {
        $this->db->query('SELECT * FROM orders');
        $results = $this->db->resultSet();
        return $results;
    }

    public function getOrderById($id) {
        $this->db->query('SELECT * FROM orders WHERE id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }

    public function updateOrder($data) {
        $this->db->query('UPDATE orders SET order_status = :order_status WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':order_status', $data['order_status']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteOrder($id) {
        $this->db->query('DELETE FROM orders WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getCart() {
        $this->db->query('SELECT * FROM cart');
        $results = $this->db->resultSet();
        return $results;
    }

    public function getCartItemById($id) {
        $this->db->query('SELECT * FROM cart WHERE id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }

    public function updateCartItem($data) {
        $this->db->query('UPDATE cart SET quantity = :quantity WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':quantity', $data['quantity']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function deleteCartItem($id) {
        $this->db->query('DELETE FROM cart WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function checkout($data) {
        $this->db->query('INSERT INTO orders (product_name, quantity, price, order_status) VALUES(:product_name, :quantity, :price, :order_status)');
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':order_status', $data['order_status']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function checkoutConfirmation($data) {
        $this->db->query('INSERT INTO orders (product_name, quantity, price, order_status) VALUES(:product_name, :quantity, :price, :order_status)');
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':order_status', $data['order_status']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function requestHelp($data) {
        $this->db->query('INSERT INTO help_requests (name, email, message) VALUES(:name, :email, :message)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':message', $data['message']);

        if($this->db->execute()) {
            return true;
        } else {
            return false;
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