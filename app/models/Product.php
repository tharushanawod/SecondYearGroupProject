<?php
class Product {
    
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getAllProducts() {
        $query = "SELECT * FROM products";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        $products = $stmt->fetchAll();
        return $products;
    }

    public function getProduct($id) {
        $query = "SELECT * FROM products WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        $product = $stmt->fetch();
        return $product;
    }

    public function addProduct($data) {
        $query = "INSERT INTO products (product_name, category, price, stock) VALUES (:product_name, :category, :price, :stock)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':product_name', $data['product_name']);
        $stmt->bindParam(':category', $data['category']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->execute();
    }

    public function updateProduct($id, $data) {
        $query = "UPDATE products SET product_name = :product_name, category = :category, price = :price, stock = :stock WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':product_name', $data['product_name']);
        $stmt->bindParam(':category', $data['category']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':stock', $data['stock']);
        $stmt->execute();
    }

    public function deleteProduct($id) {
        $query = "DELETE FROM products WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
    }
}