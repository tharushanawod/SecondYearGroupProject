<?php
class Product {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getProducts() {
        $this->db->query("SELECT * FROM products");
        return $this->db->resultSet();
    }

    public function getProduct($product_id) {
        $this->db->query("SELECT * FROM products WHERE product_id = :product_id");
        $this->db->bind(':product_id', $product_id);
        return $this->db->single();
    }

    public function addProduct($data) {
        $this->db->query("INSERT INTO products (product_name, category, price, stock, description, image) VALUES (:product_name, :category, :price, :stock, :description, :image)");
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':stock', $data['stock']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':image', $data['image']);
        return $this->db->execute();
    }

    public function updateProduct($data) {
        $this->db->query("UPDATE products SET product_name = :product_name, category = :category, price = :price, stock = :stock, description = :description, image = :image WHERE product_id = :id");
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':stock', $data['stock']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':image', $data['image']);
        return $this->db->execute();
    }

    public function deleteProduct($product_id) {
        $this->db->query("DELETE FROM products WHERE product_id = :product_id");
        $this->db->bind(':product_id', $product_id);
        return $this->db->execute();
    }

    public function getProductsByCategory($category) {
        $this->db->query("SELECT * FROM products WHERE category = :category");
        $this->db->bind(':category', $category);
        return $this->db->resultSet();
    }
}
?>