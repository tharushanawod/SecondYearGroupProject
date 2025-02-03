<?php

class Order {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function placeOrder($data) {
        $this->db->query('INSERT INTO orders (product_name, category, price, stock, supplier_id, order_status, farmer_id, quantity, payment_status) VALUES (:product_name, :category, :price, :stock, :supplier_id, :order_status, :farmer_id, :quantity, :payment_status)');
        $this->db->bind(':product_name', $data['product_name']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':stock', $data['stock']);
        $this->db->bind(':supplier_id', $data['supplier_id']);
        $this->db->bind(':order_status', $data['order_status']);
        $this->db->bind(':farmer_id', $data['farmer_id']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':payment_status', $data['payment_status']);

        if ($this->db->execute()) {
            return $this->db->lastInsertId();
        } else {
            return false;
        }
    }

    public function updateOrderStatus($orderId, $status) {
        $this->db->query('UPDATE orders SET order_status = :status WHERE id = :orderId');
        $this->db->bind(':status', $status);
        $this->db->bind(':orderId', $orderId);

        return $this->db->execute();
    }

    public function getOrdersWithFarmerName() {
        $this->db->query('
            SELECT orders.*, farmers.name as farmer_name
            FROM orders
            JOIN farmers ON orders.farmer_id = farmers.user_id
        ');
        return $this->db->resultSet();
    }

    public function getSupplierIdByOrderId($orderId) {
        $this->db->query('SELECT supplier_id FROM orders WHERE id = :orderId');
        $this->db->bind(':orderId', $orderId);
        return $this->db->single()->supplier_id;
    }

    public function getFarmerIdByOrderId($orderId) {
        $this->db->query('SELECT farmer_id FROM orders WHERE id = :orderId');
        $this->db->bind(':orderId', $orderId);
        return $this->db->single()->farmer_id;
    }

    public function getOrdersBySupplierId($supplierId) {
        $this->db->query('SELECT * FROM orders WHERE supplier_id = :supplierId');
        $this->db->bind(':supplierId', $supplierId);
        return $this->db->resultSet();
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

}