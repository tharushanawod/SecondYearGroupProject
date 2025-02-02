<?php
class Product {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getProducts($supplier_id) {
        $this->db->query("SELECT p.*, c.name as category_name 
                         FROM supplier_products p 
                         LEFT JOIN categories c ON p.category_id = c.id
                         WHERE p.supplier_id = :supplier_id");
        $this->db->bind(':supplier_id', $supplier_id);
        return $this->db->resultSet();
    }

    public function getProductById($id) {
        $this->db->query('SELECT p.*, c.name as category_name 
                         FROM supplier_products p 
                         LEFT JOIN categories c ON p.category_id = c.id 
                         WHERE p.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
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

    public function updateProduct($data) {
        $query = 'UPDATE supplier_products 
                  SET product_name = :name, 
                      category_id = :category,
                      price = :price,
                      stock = :stock,
                      description = :description';
        if ($data['image']) {
            $query .= ', image = :image';
        }
        $query .= ' WHERE id = :id AND supplier_id = :supplier_id';

        $this->db->query($query);
        
        $this->db->bind(':id', $data['id']);
        $this->db->bind(':name', $data['product_name']);
        $this->db->bind(':category', $data['category_id']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':stock', $data['stock']);
        $this->db->bind(':description', $data['description']);
        if ($data['image']) {
            $this->db->bind(':image', $data['image']);
        }
        $this->db->bind(':supplier_id', $_SESSION['user_id']);

        return $this->db->execute();
    }

    public function deleteProduct($id) {
        $this->db->query('DELETE FROM supplier_products WHERE id = :id AND supplier_id = :supplier_id');
        $this->db->bind(':id', $id);
        $this->db->bind(':supplier_id', $_SESSION['user_id']);
        return $this->db->execute();
    }

    public function getProductsByCategory($category_id, $supplier_id) {
        $this->db->query("SELECT p.*, c.name as category_name 
                         FROM supplier_products p 
                         LEFT JOIN categories c ON p.category_id = c.id 
                         WHERE p.category_id = :category_id AND p.supplier_id = :supplier_id");
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':supplier_id', $supplier_id);
        return $this->db->resultSet();
    }

    public function getCategories() {
        $this->db->query('SELECT * FROM categories');
        return $this->db->resultSet();
    }

    public function getOrderById($order_id) {
        $this->db->query('SELECT o.*, p.product_name, u.name as customer_name 
                         FROM orders o 
                         JOIN supplier_products p ON o.product_id = p.id 
                         JOIN users u ON o.farmer_id = u.user_id 
                         WHERE o.id = :order_id');
        $this->db->bind(':order_id', $order_id);
        return $this->db->single();
    }

    public function updateOrderStatus($order_id, $status) {
        $this->db->query('UPDATE orders SET order_status = :status WHERE id = :order_id');
        $this->db->bind(':status', $status);
        $this->db->bind(':order_id', $order_id);
        return $this->db->execute();
    }

    public function getOrdersBySupplierId($supplier_id) {
        $this->db->query('SELECT o.*, p.product_name, u.name as customer_name 
                         FROM orders o 
                         JOIN supplier_products p ON o.product_id = p.id 
                         JOIN users u ON o.farmer_id = u.user_id 
                         WHERE p.supplier_id = :supplier_id');
        $this->db->bind(':supplier_id', $supplier_id);
        return $this->db->resultSet();
    }
}
?>