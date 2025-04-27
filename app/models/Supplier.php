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

    public function getAllOrders($supplierId) {
        $this->db->query('SELECT 
        orders.*,transaction.transaction_id,delivery_codes.code_id,order_items.status as payment_status,order_items.delivery_confirmed
        FROM orders
        LEFT JOIN transaction ON orders.order_id = transaction.order_id
        LEFT JOIN delivery_codes ON orders.order_id = delivery_codes.order_id
        INNER JOIN order_items ON orders.order_id = order_items.order_id
        INNER JOIN supplier_products ON order_items.product_id = supplier_products.product_id
        WHERE supplier_products.supplier_id = :supplierId AND order_items.supplier_confirmed = 1
        ORDER BY orders.order_date DESC');
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

    public function getRecentOrders($supplierId) {
        $this->db->query('
          SELECT orders.*,order_items.status as payment_status,order_items.price,order_items.quantity
FROM orders 
INNER JOIN users ON orders.user_id = users.user_id
INNER JOIN order_items ON orders.order_id = order_items.order_id
INNER JOIN supplier_products ON order_items.product_id = supplier_products.product_id
WHERE supplier_products.supplier_id = :supplierId
ORDER BY orders.order_date DESC
LIMIT 5

        ');
        
        $this->db->bind(':supplierId', $supplierId);
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
        $this->db->query('SELECT AVG(rating) as avg_rating, COUNT(*) as total_ratings 
                        FROM supplier_ratings 
                        WHERE supplier_id = :supplier_id');
        
        $this->db->bind(':supplier_id', $supplier_id);
        return $this->db->single();
    }

    public function getUserStatus($user_id) {
        $this->db->query('SELECT user_status FROM users WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->single();  // This will return the user's status (e.g., 'restricted')
    }

    public function getrestrictedDetails($user_id){
        $this->db->query('SELECT * FROM restriction_logs WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();  // This will return the user's status (e.g., 'restricted')
    }

    public function saveHelpRequest($data) {
        $this->db->query("
            INSERT INTO help_requests (user_id, user_role, category, subject, description, attachment, status, created_at)
            VALUES (:user_id, :user_role, :category, :subject, :description, :attachment, :status, :created_at)
        ");
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':user_role', $data['user_role']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':subject', $data['subject']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':attachment', $data['attachment']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':created_at', $data['created_at']);
        return $this->db->execute();
    } 

    public function getOrderDetails($orderId, $supplierId) {
        $this->db->query('
            SELECT oi.*, sp.product_name, sp.price, o.order_date
            FROM order_items oi
            JOIN supplier_products sp ON oi.product_id = sp.product_id
            JOIN users u ON sp.supplier_id = u.user_id
            JOIN orders o ON oi.order_id = o.order_id
            WHERE oi.order_id = :orderId AND sp.supplier_id = :supplierId
        ');
        $this->db->bind(':orderId', $orderId);
        $this->db->bind(':supplierId', $supplierId);
        return $this->db->resultSet();
    }

    public function getBuyerDetails($orderId) {
        $this->db->query('
            SELECT *
            FROM orders
            WHERE order_id = :order_id
        ');
        $this->db->bind(':order_id', $orderId);
        return $this->db->single();
    }

    public function getDeliveryConfirmationStatus($orderId) {
        $this->db->query('
            SELECT  transaction.delivery_confirmed
            FROM orders
            LEFT JOIN transaction
            ON orders.order_id = transaction.order_id
            WHERE orders.order_id = :order_id
        ');
        $this->db->bind(':order_id', $orderId);
        return $this->db->single();
    }

    public function sendDeliveryCode($data){
        $this->db->query('INSERT INTO delivery_codes (order_id, company, code) 
                         VALUES (:order_id, :delivery_company, :tracking_number)');
        
        $this->db->bind(':order_id', $data['orderId']);
        $this->db->bind(':delivery_company', $data['deliveryCompany']);
        $this->db->bind(':tracking_number', $data['trackingNumber']);

        return $this->db->execute();
    }


    public function getWalletDetails($supplier_id) {
        try {
            // Start transaction
            $this->db->beginTransaction();
    
            // Get wallet balance
            $this->db->query("SELECT balance FROM wallets WHERE user_id = :supplier_id");
            $this->db->bind(':supplier_id', $supplier_id);
            $wallet = $this->db->single();
    
            // Get successful transactions
            $this->db->query('
               SELECT order_items.order_id, 
       transaction.payment_date,
       (SUM(order_items.quantity * order_items.price) / 100 * 98) AS amount, 
       order_items.withdraw_status
FROM order_items
INNER JOIN transaction ON order_items.order_id = transaction.order_id
INNER JOIN supplier_products ON order_items.product_id = supplier_products.product_id
WHERE supplier_products.supplier_id = :supplier_id
  AND wallet_status = "added"
GROUP BY order_items.order_id, transaction.payment_date, order_items.withdraw_status;



               
            ');

            $this->db->bind(':supplier_id', $supplier_id);
            $transactions = $this->db->resultSet();
    
            // Commit transaction
            $this->db->commit();
    
            // Return both
            return [
                'wallet' => $wallet,
                'transactions' => $transactions
            ];
    
        } catch (Exception $e) {
            $this->db->rollBack();
            die('Failed: ' . $e->getMessage());
        }

       
    }

    public function PendingOrderCount($user_id){
        $this->db->query('SELECT COUNT(DISTINCT order_items.order_id) as order_count FROM order_items
        INNER JOIN supplier_products
        ON order_items.product_id = supplier_products.product_id
        WHERE supplier_products.supplier_id = :supplier_id AND order_items.status = "pending"
        ');

$this->db->bind(':supplier_id', $user_id);
$count = $this->db->single();
return $count->order_count;
            
    }

    public function getPendingOrders($supplierId){
        $this->db->query('SELECT 
        orders.*,transaction.transaction_id,delivery_codes.code_id,order_items.status as payment_status,order_items.delivery_confirmed
        FROM orders
        LEFT JOIN transaction ON orders.order_id = transaction.order_id
        LEFT JOIN delivery_codes ON orders.order_id = delivery_codes.order_id
        INNER JOIN order_items ON orders.order_id = order_items.order_id
        INNER JOIN supplier_products ON order_items.product_id = supplier_products.product_id
        WHERE supplier_products.supplier_id = :supplierId AND order_items.supplier_confirmed = 0
        ORDER BY orders.order_date DESC');
        $this->db->bind(':supplierId', $supplierId);
        return $this->db->resultSet();
    }

    public function getCompletedOrderCount($supplierId) {
        $this->db->query('SELECT COUNT(DISTINCT order_items.order_id) as order_count
         FROM order_items
         INNER JOIN supplier_products
         ON order_items.product_id = supplier_products.product_id 
         WHERE supplier_products.supplier_id = :supplierId AND order_items.supplier_confirmed = 1 AND order_items.delivery_confirmed = 1 AND order_items.status ="paid"');
        $this->db->bind(':supplierId', $supplierId);
        return $this->db->single()->order_count;
    }

    public function getActiveorderCount($supplierId) {
        $this->db->query('SELECT COUNT(DISTINCT order_items.order_id) as order_count
         FROM order_items
         INNER JOIN supplier_products
         ON order_items.product_id = supplier_products.product_id 
         WHERE supplier_products.supplier_id = :supplierId AND order_items.supplier_confirmed = 1 AND order_items.delivery_confirmed = 1 AND order_items.status ="paid"');
        $this->db->bind(':supplierId', $supplierId);
        return $this->db->single()->order_count;
    }

    public function getTotalRevenue($supplierId) {
        $this->db->query('SELECT SUM(order_items.price * order_items.quantity) as total_revenue
         FROM order_items
         INNER JOIN supplier_products
         ON order_items.product_id = supplier_products.product_id 
         WHERE supplier_products.supplier_id = :supplierId AND order_items.supplier_confirmed = 1 AND order_items.delivery_confirmed = 1 AND order_items.status ="paid"');
        $this->db->bind(':supplierId', $supplierId);
        return $this->db->single()->total_revenue;
    }

    public function ConfirmOrder($orderId, $supplierId) {
        $this->db->query('UPDATE order_items SET supplier_confirmed = 1 WHERE order_id = :orderId AND product_id IN (SELECT product_id FROM supplier_products WHERE supplier_id = :supplierId)');
        $this->db->bind(':orderId', $orderId);
        $this->db->bind(':supplierId', $supplierId);
        return $this->db->execute();
    }   

    public function processWithdrawal($withdrawalAmount){
    


        try {
            // Start transaction
            $this->db->beginTransaction();
    
           
            $this->db->query('UPDATE wallets 
            SET balance = balance - :withdrawalAmount 
            WHERE user_id = :user_id
            ');
            $this->db->bind(':withdrawalAmount', $withdrawalAmount);
            $this->db->bind(':user_id', $_SESSION['user_id']);
            $this->db->single();

            $this->db->query('UPDATE order_items
            INNER JOIN supplier_products ON order_items.product_id = supplier_products.product_id
            SET order_items.withdraw_status = "withdrawn"
            WHERE supplier_products.supplier_id = :user_id AND order_items.withdraw_status = "not_withdrawn" AND order_items.status = "paid"
            AND order_items.wallet_status = "added"

            ');
                   $this->db->bind(':user_id', $_SESSION['user_id']);
            $this->db->single();
    
            // Commit transaction
            $this->db->commit();
    
            // Return both results as an array
            return true;
        }catch (Exception $e) {
            $this->db->rollback();
            return $e->getMessage(); // This returns the real error
        }

       
        
        
    }


    
}
?>