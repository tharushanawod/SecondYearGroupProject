<?php
class Product {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function addProduct($data) {
        $query = "INSERT INTO products (name, category, price, description, quantity, image) 
                  VALUES (:name, :category, :price, :description, :quantity, :image)";
        
        return $this->db->query($query, [
            'name' => $data['name'],
            'category' => $data['category'],
            'price' => $data['price'],
            'description' => $data['description'],
            'quantity' => $data['quantity'],
            'image' => $data['image']
        ]);
    }

    public function updateProduct($data) {
        $query = "UPDATE products 
                  SET name = :name, category = :category, price = :price, 
                      description = :description, quantity = :quantity, image = :image 
                  WHERE id = :id";
        
        return $this->db->query($query, [
            'id' => $data['id'],
            'name' => $data['name'],
            'category' => $data['category'],
            'price' => $data['price'],
            'description' => $data['description'],
            'quantity' => $data['quantity'],
            'image' => $data['image']
        ]);
    }

    public function deleteProduct($id) {
        $query = "DELETE FROM products WHERE id = :id";
        return $this->db->query($query, ['id' => $id]);
    }

    public function getProductsByCategory($category) {
        $query = "SELECT * FROM products WHERE category = :category";
        return $this->db->query($query, ['category' => $category])->fetchAll();
    }

    public function getProductById($id) {
        $query = "SELECT * FROM products WHERE id = :id";
        return $this->db->query($query, ['id' => $id])->fetch();
    }
}
?>