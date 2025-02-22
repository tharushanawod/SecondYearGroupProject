<?php

class Supplier {
    
    private $db;

    public function __construct() {
        $this->db = new Database();
    }    

    public function addProduct($data) {
        $this->db->query('INSERT INTO supplier_products (product_name, category_id, price, stock, description, image, supplier_id) 
                         VALUES (:name, :category_id, :price, :stock, :description, :image, :supplier_id)');
        
        $this->db->bind(':name', $data['product_name']);
        $this->db->bind(':category_id', $data['category_id']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':stock', $data['stock']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':image', $data['image']);
        $this->db->bind(':supplier_id', $_SESSION['user_id']);

        return $this->db->execute();
    }
    
    public function getProductById($id) {
        $this->db->query('SELECT p.*, c.category_name 
                         FROM supplier_products p 
                         LEFT JOIN categories c ON p.category_id = c.category_id 
                         WHERE p.id = :id');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    public function updateProduct($data) {
        $this->db->query('UPDATE supplier_products 
                         SET product_name = :name, 
                             category_id = :category_id,
                             price = :price,
                             stock = :stock,
                             description = :description,
                             image = :image
                         WHERE id = :id AND supplier_id = :supplier_id');
        
        $this->db->bind(':name', $data['product_name']);
        $this->db->bind(':category_id', $data['category_id']);
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

    public function getProducts($supplier_id) {
        $this->db->query("SELECT p.*, c.category_name 
                         FROM supplier_products p 
                         LEFT JOIN categories c ON p.category_id = c.category_id 
                         WHERE p.supplier_id = :supplier_id");
        $this->db->bind(':supplier_id', $supplier_id);
        return $this->db->resultSet();
    }

    public function getProductsByCategory($category_id, $supplier_id) {
        $this->db->query("SELECT p.*, c.category_name 
                         FROM supplier_products p 
                         LEFT JOIN categories c ON p.category_id = c.category_id 
                         WHERE p.category_id = :category_id AND p.supplier_id = :supplier_id");
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':supplier_id', $supplier_id);
        return $this->db->resultSet();
    }

    public function getCategories() {
        $this->db->query('SELECT category_id, category_name FROM categories');
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
    private function view($view, $data = []) {
        if (file_exists("../app/views/" . $view . ".php")) {
            require_once "../app/views/" . $view . ".php";
        } else {
            die("View does not exist.");
        }
    }

    public function updateOrderStatus($orderId, $status, $reason = null) {
        $this->db->query('UPDATE orders SET order_status = :status, rejection_reason = :reason WHERE id = :orderId');
        $this->db->bind(':status', $status);
        $this->db->bind(':reason', $reason);
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

    public function getOrdersByStatus($status) {
        $this->db->query('SELECT * FROM orders WHERE order_status = :status');
        $this->db->bind(':status', $status);
        return $this->db->resultSet();
    }

    public function getOrdersByStatusAndSupplierId($status, $supplierId) {
        $this->db->query('SELECT * FROM orders WHERE order_status = :status AND supplier_id = :supplierId');
        $this->db->bind(':status', $status);
        $this->db->bind(':supplierId', $supplierId);
        return $this->db->resultSet();
    }

    public function getRecentCustomers($supplierId) {
        $this->db->query('
            SELECT DISTINCT farmers.user_id as customer_id, farmers.name as customer_name, farmers.contact, farmers.location
            FROM orders
            JOIN farmers ON orders.farmer_id = farmers.user_id
            WHERE orders.supplier_id = :supplierId
            ORDER BY orders.created_at DESC LIMIT 5
        ');
        $this->db->bind(':supplierId', $supplierId);
        return $this->db->resultSet();
    }

    public function getRecentOrders($supplierId, $limit = 5) {
        $this->db->query('
            SELECT o.*, f.name as customer_name 
            FROM orders o
            JOIN users f ON o.farmer_id = f.user_id
            WHERE o.supplier_id = :supplierId
            ORDER BY o.created_at DESC 
            LIMIT :limit
        ');
        
        $this->db->bind(':supplierId', $supplierId);
        $this->db->bind(':limit', $limit);
        return $this->db->resultSet();
    }
public function addRating($data) {
        $this->db->query('INSERT INTO supplier_ratings (supplier_id, farmer_id, rating, review_text) 
                        VALUES (:supplier_id, :farmer_id, :rating, :review_text)');
        
        $this->db->bind(':supplier_id', $data['supplier_id']);
        $this->db->bind(':farmer_id', $data['farmer_id']);
        $this->db->bind(':rating', $data['rating']);
        $this->db->bind(':review_text', $data['review']);

        return $this->db->execute();
    }

    public function getSupplierRatings($supplier_id) {
        $this->db->query('SELECT sr.*, u.name as farmer_name, pp.file_path as profile_picture 
                        FROM supplier_ratings sr 
                        LEFT JOIN users u ON sr.farmer_id = u.user_id 
                        LEFT JOIN profile_pictures pp ON u.user_id = pp.user_id 
                        WHERE sr.supplier_id = :supplier_id 
                        ORDER BY sr.created_at DESC');
        
        $this->db->bind(':supplier_id', $supplier_id);
        return $this->db->resultSet();
    }

    public function getAverageRating($supplier_id) {
        $this->db->query('SELECT AVG(rating) as avg_rating 
                        FROM supplier_ratings 
                        WHERE supplier_id = :supplier_id');
        
        $this->db->bind(':supplier_id', $supplier_id);
        $result = $this->db->single();
        return $result->avg_rating ?? 0;
    }
}
?>