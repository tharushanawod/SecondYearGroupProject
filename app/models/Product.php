<?php
class Product {
    
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getProducts() {
        $this->db->query("SELECT * FROM products");
        return $this->db->resultSet(); // Return data as objects
    }

    public function getProduct($id) {
        $query = "SELECT * FROM products WHERE id = :id";
        $this->db->query($query);
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function addProduct($data) {
        $query = "INSERT INTO products (product_name, category, price, stock) VALUES (:product_name, :category, :price, :stock)";
        $this->db->query($query);
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':stock', $data['stock']);
        return $this->db->execute();
    }
}