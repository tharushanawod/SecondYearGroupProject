<?php

class Buyer {
    
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getUserById ($id){
        $this->db->query('SELECT * FROM users WHERE user_id = :id');
        $this->db->bind(':id',$id);
        $row = $this->db->single();
        return $row;
    }

    public function UpdateProfile($data) {
        if (!empty($data['password'])) {
            // Include password in the update query
            $this->db->query('UPDATE users SET name = :name, email = :email, phone = :phone,  password = :password WHERE user_id = :id');
            $this->db->bind(':password', $data['password']);
        } else {
            // Exclude password from the update query
            $this->db->query('UPDATE users SET name = :name, email = :email, phone = :phone WHERE user_id = :id');
        }
    
     
        $this->db->bind(':id', $data['user_id']);
        $this->db->bind(':name', $data['name']);
        $this->db->bind(':email', $data['email']);
        $this->db->bind(':phone', $data['phone']);
       
    

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


     // Get profile image path by user ID
     public function getProfileImage($userId) {
        $this->db->query("SELECT file_path FROM profile_pictures WHERE user_id = :userId");
        $this->db->bind(':userId', $userId);
        $row = $this->db->single();

        if($row){
            return $row->file_path;
        } else {
            return false;
        }
       
    }


     // Update or Insert profile image path in the database
    public function updateProfileImage($userId, $imagePath) {
        // Check if a record already exists for the user
        $this->db->query("SELECT id FROM profile_pictures WHERE user_id = :userId");
        $this->db->bind(':userId', $userId);
        $row = $this->db->single();

        if ($row) {
            // Update existing record
            $this->db->query("UPDATE profile_pictures SET file_path = :imagePath WHERE user_id = :userId");
            $this->db->bind(':imagePath', $imagePath);
            $this->db->bind(':userId', $userId);
        } else {
            // Insert new record
            $this->db->query("INSERT INTO profile_pictures (user_id, file_path) VALUES (:userId, :imagePath)");
            $this->db->bind(':userId', $userId);
            $this->db->bind(':imagePath', $imagePath);
        }

        return $this->db->execute();
    }


    //function to display available corn products
    public function getAvailableProducts() {
        $this->db->query("SELECT corn_products.*, 
            MAX(bids.bid_amount) AS highest_bid, 
            COALESCE(AVG(buyer_reviews_farmer.rating), 0) AS avg_rating
            FROM corn_products
            LEFT JOIN buyer_reviews_farmer 
            ON corn_products.user_id = buyer_reviews_farmer.farmer_id
            LEFT JOIN bids 
            ON corn_products.product_id = bids.product_id
            WHERE closing_date > NOW()
            GROUP BY corn_products.product_id;

");
        $rows = $this->db->resultSet();
        return $rows;
    }

    public function getProductById($id) {
        $this->db->query("
        SELECT corn_products.*, 
       users.name, 
       farmers.district, 
       MAX(bids.bid_amount) AS highest_bid
FROM corn_products
INNER JOIN users 
ON corn_products.user_id = users.user_id
LEFT JOIN farmers 
ON corn_products.user_id = farmers.user_id
LEFT JOIN bids  
ON corn_products.product_id = bids.product_id
WHERE corn_products.product_id = :id
GROUP BY corn_products.product_id, users.name, farmers.district;

        ");
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }

    public function getFarmersById($id) {
        $this->db->query('
        SELECT 
    users.*, 
    farmers.*, 
    profile_pictures.file_path, 
    AVG(buyer_reviews_farmer.rating) AS average_rating
    FROM users
    INNER JOIN farmers ON users.user_id = farmers.user_id
    LEFT JOIN profile_pictures ON farmers.user_id = profile_pictures.user_id
    LEFT JOIN buyer_reviews_farmer ON users.user_id = buyer_reviews_farmer.farmer_id
    WHERE users.user_id = :id
    GROUP BY 
    users.user_id, 
    farmers.user_id, 
    profile_pictures.user_id, 
    profile_pictures.file_path;
    ');
    $this->db->bind(':id', $id);
    $farmer = $this->db->single();
    return $farmer;
    
       

    }

    public function SubmitBid($data) {
        $this->db->query("INSERT INTO bids (product_id, buyer_id, bid_amount,payment_status) VALUES (:product_id, :buyer_id, :bid_amount,:payment_status)");
        $this->db->bind(':product_id', $data['product_id']);
        $this->db->bind(':buyer_id', $data['buyer_id']);
        $this->db->bind(':bid_amount', $data['bid_amount']);
        $this->db->bind(':payment_status', 'Pending');

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function AddReview($data) {
        $this->db->query('INSERT INTO buyer_reviews_farmer (review_text, rating, buyer_id, farmer_id) VALUES (:review_text, :rating, :buyer_id, :farmer_id)');
        $this->db->bind(':review_text', $data['review_text']);
        $this->db->bind(':rating', $data['rating']);
        $this->db->bind(':buyer_id', $data['buyer_id']);
        $this->db->bind(':farmer_id', $data['farmer_id']);
    
        // Execute and return result
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }


    //function to get all reviews
    public function fetchReviews($id){

        $this->db->query('
        SELECT buyer_reviews_farmer.*, users.name,profile_pictures.file_path
        FROM buyer_reviews_farmer
        INNER JOIN users  ON buyer_reviews_farmer.buyer_id = users.user_id
        INNER JOIN profile_pictures  ON users.user_id = profile_pictures.user_id
        WHERE buyer_reviews_farmer.farmer_id = :id
    ');
       
        $this->db->bind(':id', $id);
        $results = $this->db->resultSet();
        return $results;
    }

    public function getAllActiveBidsForBuyer($user_id) {
        $this->db->query('
       SELECT 
    bids.bid_id,
    bids.bid_amount,
    bids.product_id,
    bids.payment_status,
    corn_products.quantity, 
    corn_products.closing_date,
    (SELECT MAX(bids_inner.bid_amount) 
     FROM bids AS bids_inner 
     WHERE bids_inner.product_id = bids.product_id) AS highest_bid
FROM bids
INNER JOIN corn_products ON bids.product_id = corn_products.product_id
WHERE bids.buyer_id = :user_id
AND corn_products.closing_date > NOW();

        ');
        $this->db->bind(':user_id', $user_id);
        $bids = $this->db->resultSet();
        return $bids;
    }

    public function CancelBid($bid_id) {
        $this->db->query('DELETE FROM bids WHERE bid_id = :bid_id');
        $this->db->bind(':bid_id', $bid_id);
    
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getPendingPayments($user_id) {
        $this->db->query('
        SELECT * FROM orders_from_buyers
        WHERE buyer_id = :user_id
        AND payment_status = "Pending";');
        $this->db->bind(':user_id', $user_id);
        $pendingpayments = $this->db->resultSet();

        return $pendingpayments;
    }

    public function getPaymentDetailsForOrder($order_id) {
        $this->db->query('
        SELECT * FROM orders_from_buyers
        WHERE order_id = :order_id;');
        $this->db->bind(':order_id', $order_id);
        $paymentdetails = $this->db->single();

        return $paymentdetails;
    }

    public function updatePaymentStatus($order_id, $payment_status) {
        $this->db->query('UPDATE orders_from_buyers SET payment_status = :payment_status WHERE order_id = :order_id');
        $this->db->bind(':payment_status', $payment_status);
        $this->db->bind(':order_id', (int)$order_id);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
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


    public function TransactionComplete($order_id, $amount, $serviceCharge, $payment_id) {
        try {
            $this->db->beginTransaction(); // Start transaction
    
            // Insert payment
            $this->db->query('
                INSERT INTO buyer_payments (order_id, paid_amount, payment_id)
                VALUES (:order_id, :paid_amount, :payment_id)
            ');
            $this->db->bind(':order_id', $order_id);
            $this->db->bind(':paid_amount', $amount);
            $this->db->bind(':payment_id', $payment_id);
            $this->db->execute();
    
            // Update order status
            $this->db->query('
                            UPDATE wallets 
                            SET balance = balance + :serviceCharge
                            WHERE user_id = :admin_id
                        ');
                        $this->db->bind(':serviceCharge', $serviceCharge);
                        $this->db->bind(':admin_id', 123); // Set this to the admin’s user ID
                        $this->db->execute();

    
            $this->db->commit(); // Commit if all succeed
            return true;
    
        } catch (Exception $e) {
            $this->db->rollback(); // Rollback if any fails
            return false;
        }
    }
    

    public function getPurchaseHistory($user_id) {
        $this->db->query('
            SELECT 
                orders_from_buyers.quantity,
                orders_from_buyers.bid_price,
                orders_from_buyers.farmer_id,
                buyer_payments.transaction_id,
                buyer_payments.paid_amount,
                buyer_payments.order_id,
                buyer_payments.farmer_confirmed,
                buyer_payments.buyer_confirmed
            FROM 
                orders_from_buyers
            INNER JOIN 
                buyer_payments ON orders_from_buyers.order_id = buyer_payments.order_id 
            WHERE 
                orders_from_buyers.buyer_id = :user_id 
        ');
        
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    public function confirmOrder($order_id) {
        $this->db->query('UPDATE buyer_payments SET buyer_confirmed = 1 WHERE order_id = :order_id');
        $this->db->bind(':order_id', $order_id);
        return $this->db->execute();
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

    public function getTotalBids($user_id) {
        $this->db->query('SELECT COUNT(*) as total_bids FROM bids WHERE buyer_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        $results=$this->db->single();  // This will return the user's status (e.g., 'restricted')
        return $results->total_bids; // Return the total number of bids
    }
    public function getTotalSpent($user_id) {
        $this->db->query('SELECT SUM(bid_price * quantity) as total_spent FROM orders_from_buyers WHERE buyer_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        $results = $this->db->single();  // This will return the user's status (e.g., 'restricted')
        return $results->total_spent; // Return the total amount spent
    }
    public function getAuctionsWon($user_id) {
        $this->db->query('SELECT COUNT(*) as auctions_won FROM orders_from_buyers WHERE buyer_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        $results = $this->db->single();  // This will return the user's status (e.g., 'restricted')
        return $results->auctions_won; // Return the total number of auctions won
    }
    public function getRecentBids($user_id) {
        $this->db->query('
            SELECT corn_products.quantity, bids.bid_amount, bids.bid_time,orders_from_buyers.order_id,corn_products.closing_date
            FROM bids
            INNER JOIN corn_products ON bids.product_id = corn_products.product_id
            LEFT JOIN orders_from_buyers ON corn_products.product_id = orders_from_buyers.product_id
            WHERE bids.buyer_id = :user_id
            ORDER BY bids.bid_time DESC
            LIMIT 5
        ');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();  // This will return the user's statu


        }
    
    public function getActiveProducts(){
        $this->db->query('
            SELECT COUNT(*) as active_products
            FROM corn_products
            WHERE corn_products.closing_date > NOW()
        ');
        $results = $this->db->single();  
        return $results->active_products; 
    }
    
    public function getFilteredBids($category, $sortBy, $minPrice, $maxPrice, $minQty, $maxQty) {
        $sql = "SELECT corn_products.*, 
                       MAX(bids.bid_amount) AS highest_bid, 
                       COALESCE(AVG(buyer_reviews_farmer.rating), 0) AS avg_rating
                FROM corn_products
                LEFT JOIN buyer_reviews_farmer 
                    ON corn_products.user_id = buyer_reviews_farmer.farmer_id
                LEFT JOIN bids 
                    ON corn_products.product_id = bids.product_id
                WHERE closing_date > NOW()";
    
        if (!empty($category)) $sql .= " AND category = :category";
        if (!empty($minPrice)) $sql .= " AND starting_price >= :minPrice";
        if (!empty($maxPrice)) $sql .= " AND starting_price <= :maxPrice";
        if (!empty($minQty)) $sql .= " AND quantity >= :minQty";
        if (!empty($maxQty)) $sql .= " AND quantity <= :maxQty";
    
        $sql .= " GROUP BY corn_products.product_id";
    
        switch ($sortBy) {
            case 'price_low': $sql .= " ORDER BY starting_price ASC"; break;
            case 'price_high': $sql .= " ORDER BY starting_price DESC"; break;
            case 'newest': $sql .= " ORDER BY created_at DESC"; break;
            case 'ending_soon': $sql .= " ORDER BY closing_date ASC"; break;
            case 'most_bids': $sql .= " ORDER BY COUNT(bids.bid_id) DESC"; break;
        }
    
        $this->db->query($sql);
    
        if (!empty($category))  $this->db->bind(':category', $category);
        if (!empty($minPrice))  $this->db->bind(':minPrice', $minPrice);
        if (!empty($maxPrice))  $this->db->bind(':maxPrice', $maxPrice);
        if (!empty($minQty))    $this->db->bind(':minQty', $minQty);
        if (!empty($maxQty))    $this->db->bind(':maxQty', $maxQty);
    
        return $this->db->resultSet();
    }
    
    public function getManufacturerPrices() {
        try {
            $this->db->query('
                SELECT 
                    u.user_id,
                    m.company_name,
                    mp.unit_price,
                    IFNULL(pp.file_path, "images/default_company.png") AS profile_image
                FROM manufacturer_prices mp
                INNER JOIN users u ON mp.manufacturer_id = u.user_id
                INNER JOIN manufacturers m ON u.user_id = m.user_id
                LEFT JOIN profile_pictures pp ON u.user_id = pp.user_id
                WHERE u.user_type = "manufacturer"
                AND mp.updated_at = (
                    SELECT MAX(updated_at)
                    FROM manufacturer_prices mp2
                    WHERE mp2.manufacturer_id = mp.manufacturer_id
                )
                ORDER BY mp.unit_price DESC
            ');
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log('Error in getManufacturerPrices: ' . $e->getMessage());
            return [];
        }
    }
 
    
}
?>