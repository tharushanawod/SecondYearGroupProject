<?php

class Product {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function addProduct($data) {
        $this->db->query('INSERT INTO supplier_products (product_name, category_id, supplier_id, price, stock, description, image) VALUES (:product_name, :category_id, :supplier_id, :price, :stock, :description, :image)');
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':supplier_id', $data['supplier_id']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':stock', $data['stock']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':image', $data['image']);
        
        return $this->db->execute();
    }

    public function getProducts() {
        $this->db->query('SELECT supplier_products.*, categories.name as category_name FROM supplier_products JOIN categories ON supplier_products.category_id = categories.id');
        return $this->db->resultSet();
    }

    public function getProductById($id) {
        $this->db->query('SELECT * FROM supplier_products WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateProduct($data) {
        $this->db->query('UPDATE supplier_products SET product_name = :product_name, category_id = :category_id, price = :price, stock = :stock, description = :description, image = :image WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':stock', $data['stock']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':image', $data['image']);
        
        return $this->db->execute();
    }

    public function deleteProduct($id) {
        $this->db->query('DELETE FROM supplier_products WHERE id = :id');
        $this->db->bind(':id', $id);
        
        return $this->db->execute();
    }

    public function getProductsByCategory($category_id) {
        $this->db->query('SELECT * FROM supplier_products WHERE category_id = :category_id');
        $this->db->bind(':category_id', $category_id);
        return $this->db->resultSet();
    }

    public function getOrders() {
        $this->db->query('SELECT * FROM orders');
        return $this->db->resultSet();
    }

    public function getOrdersBySupplierId($supplierId) {
        $this->db->query('SELECT * FROM orders WHERE supplier_id = :supplier_id');
        $this->db->bind(':supplier_id', $supplierId);
        $results = $this->db->resultSet();
        return $results;
    }

    public function updateOrder($data) {
        $this->db->query('UPDATE orders SET order_status = :order_status WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':order_status', $data['order_status']);
        return $this->db->execute();
    }

    public function deleteOrder($id) {
        $this->db->query('DELETE FROM orders WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function getCart() {
        $this->db->query('SELECT * FROM cart');
        return $this->db->resultSet();
    }

    public function getCartItemById($id) {
        $this->db->query('SELECT * FROM cart WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateCartItem($data) {
        $this->db->query('UPDATE cart SET quantity = :quantity WHERE id = :id');
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':quantity', $data['quantity']);
        return $this->db->execute();
    }

    public function deleteCartItem($id) {
        $this->db->query('DELETE FROM cart WHERE id = :id');
        $this->db->bind(':id', $id);
        return $this->db->execute();
    }

    public function checkout($data) {
        $this->db->query('INSERT INTO orders (product_name, quantity, price, order_status) VALUES(:product_name, :quantity, :price, :order_status)');
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':order_status', $data['order_status']);
        return $this->db->execute();
    }

    public function checkoutConfirmation($data) {
        $this->db->query('INSERT INTO orders (product_name, quantity, price, order_status) VALUES(:product_name, :quantity, :price, :order_status)');
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':order_status', $data['order_status']);
        return $this->db->execute();
    }

    public function requestHelp($data) {
        $this->db->query('INSERT INTO help_requests (name, email, message) VALUES(:name, :email, :message)');
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':message', $data['message']);
        return $this->db->execute();
    }
}
?>