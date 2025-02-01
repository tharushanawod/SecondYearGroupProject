<?php

class Supplier {
    
    private $db;

    public function __construct() {
        $this->db = new Database();
    }    

    public function addProduct($data) {
        $this->db->query('INSERT INTO supplier_products (product_name, category_id, price, stock, description, image, supplier_id) 
                         VALUES (:name, :category, :price, :stock, :description, :image, :supplier_id)');
        
        $this->db->bind(':name', $data['product_name']);
        $this->db->bind(':category', $data['category_id']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':stock', $data['stock']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':supplier_id', $_SESSION['user_id']);

        return $this->db->execute();
    }
    
    public function getProductById($id) {
        $this->db->query('SELECT * FROM supplier_products WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateProduct($data) {
        $this->db->query('UPDATE supplier_products 
                         SET product_name = :name, 
                             category_id = :category,
                             price = :price,
                             stock = :stock,
                             description = :description,
                             image = :image
                         WHERE id = :id AND supplier_id = :supplier_id');
        
        $this->db->bind(':name', $data['product_name']);
        $this->db->bind(':category', $data['category_id']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':stock', $data['stock']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':supplier_id', $data['supplier_id']);

        return $this->db->execute();
    }

    public function deleteProduct($id) {
        $this->db->query('DELETE FROM supplier_products WHERE id = :id AND supplier_id = :supplier_id');
        $this->db->bind(':id', $id);
        $this->db->bind(':supplier_id', $_SESSION['user_id']);
        return $this->db->execute();
    }

    public function getProducts() {
        $this->db->query('SELECT p.*, c.name as category_name 
                         FROM supplier_products p
                         JOIN categories c ON p.category_id = c.id
                         WHERE p.supplier_id = :supplier_id');
        $this->db->bind(':supplier_id', $_SESSION['user_id']);
        return $this->db->resultSet();
    }

    public function getProductsByCategory($category_id) {
        $this->db->query('SELECT p.*, c.name as category_name 
                         FROM supplier_products p
                         JOIN categories c ON p.category_id = c.id
                         WHERE p.category_id = :category_id');
        $this->db->bind(':category_id', $category_id);
        return $this->db->resultSet();
    }

    public function getCategories() {
        $this->db->query('SELECT * FROM categories');
        return $this->db->resultSet();
    }

    public function updateProfile($data) {
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

        return $this->db->execute();
    }

    public function getProfileImage($userId) {
        $this->db->query("SELECT file_path FROM profile_pictures WHERE user_id = :userId");
        $this->db->bind(':userId', $userId);
        $row = $this->db->single();

        return $row ? $row->file_path : false;
    }

    public function updateProfileImage($userId, $imagePath) {
        $this->db->query("SELECT id FROM profile_pictures WHERE user_id = :userId");
        $this->db->bind(':userId', $userId);
        $row = $this->db->single();

        if ($row) {
            $this->db->query("UPDATE profile_pictures SET file_path = :imagePath WHERE user_id = :userId");
        } else {
            $this->db->query("INSERT INTO profile_pictures (user_id, file_path) VALUES (:userId, :imagePath)");
        }

        $this->db->bind(':userId', $userId);
        $this->db->bind(':imagePath', $imagePath);

        return $this->db->execute();
    }

    public function getUserById($id) {
        $this->db->query('SELECT * FROM users WHERE user_id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }
}
?>