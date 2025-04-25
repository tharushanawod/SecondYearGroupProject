<?php
class Manufacturer {
    private $db;

    public function __construct() {
        try {
            $this->db = new Database();
        } catch (Exception $e) {
            error_log('Database connection failed in Manufacturer: ' . $e->getMessage());
            throw new Exception('Unable to connect to the database.');
        }
    }
   
    public function getLastPrice($user_id) {
        try {
            $this->db->query('SELECT * FROM manufacturer_prices WHERE manufacturer_id = :user_id ORDER BY updated_at DESC LIMIT 1');
            $this->db->bind(':user_id', $user_id);
            return $this->db->single();
        } catch (Exception $e) {
            error_log('Error in getLastPrice: ' . $e->getMessage());
            return null;
        }
    }

    public function getOtherManufacturersPrices($current_user_id) {
        try {
            $this->db->query('
                SELECT m.company_name, mp.unit_price, mp.updated_at
                FROM manufacturer_prices mp
                INNER JOIN users u ON mp.manufacturer_id = u.user_id
                INNER JOIN manufacturers m ON u.user_id = m.user_id
                WHERE u.user_type = "manufacturer"
                AND mp.manufacturer_id != :current_user_id
                AND mp.updated_at = (
                    SELECT MAX(updated_at)
                    FROM manufacturer_prices mp2
                    WHERE mp2.manufacturer_id = mp.manufacturer_id
                )
                ORDER BY m.company_name ASC
            ');
            $this->db->bind(':current_user_id', $current_user_id);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log('Error in getOtherManufacturersPrices: ' . $e->getMessage());
            return [];
        }
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

    public function setPrice($user_id, $unit_price) {
        try {
            $this->db->beginTransaction();
    
            // Insert or update price
            $this->db->query('
                INSERT INTO manufacturer_prices (manufacturer_id, unit_price, updated_at)
                VALUES (:user_id, :unit_price, NOW())
                ON DUPLICATE KEY UPDATE
                    unit_price = :unit_price,
                    updated_at = NOW()
            ');
            $this->db->bind(':user_id', $user_id);
            $this->db->bind(':unit_price', $unit_price);
            $success = $this->db->execute();
    
            if ($success) {
                $this->db->commit();
                return true;
            } else {
                $this->db->rollBack();
                return false;
            }
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('Error in setPrice: ' . $e->getMessage());
            return false;
        }
    }
    
    public function deletePrice($user_id) {
        try {
            $this->db->beginTransaction();
    
            // Delete current price
            $this->db->query('DELETE FROM manufacturer_prices WHERE manufacturer_id = :user_id');
            $this->db->bind(':user_id', $user_id);
            $success = $this->db->execute() && $this->db->rowCount() > 0;
    
            if ($success) {
                $this->db->commit();
                return true;
            } else {
                $this->db->rollBack();
                return false;
            }
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log('Error in deletePrice: ' . $e->getMessage());
            return false;
        }
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


    public function getAllFarmers() {
        try {
            $this->db->query("
                SELECT users.user_id, users.name, farmers.district, AVG(buyer_reviews_farmer.rating) AS avg_rating
                FROM users
                INNER JOIN farmers ON users.user_id = farmers.user_id
                LEFT JOIN buyer_reviews_farmer ON users.user_id = buyer_reviews_farmer.farmer_id
                GROUP BY users.user_id
            ");
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log('Error in getAllFarmers: ' . $e->getMessage());
            return [];
        }
    }

    public function getAllBuyers() {
        try {
            $this->db->query("
                SELECT users.user_id, users.name
                FROM users
                INNER JOIN buyers ON users.user_id = buyers.user_id
            ");
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log('Error in getAllBuyers: ' . $e->getMessage());
            return [];
        }
    }

    public function AddBankAccount($data) {
        try {
            $this->db->query('
                INSERT INTO bank_details (user_id, bank_name, account_number, name_on_card, card_number, expiry_date, cvv)
                VALUES (:user_id, :bank_name, :account_number, :name_on_card, :card_number, :expiry_date, :cvv)
                ON DUPLICATE KEY UPDATE
                    bank_name = :bank_name,
                    account_number = :account_number,
                    name_on_card = :name_on_card,
                    card_number = :card_number,
                    expiry_date = :expiry_date,
                    cvv = :cvv
            ');
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':bank_name', $data['bank_name']);
            $this->db->bind(':account_number', $data['account_number']);
            $this->db->bind(':name_on_card', $data['name_on_card']);
            $this->db->bind(':card_number', $data['card_number']);
            $this->db->bind(':expiry_date', $data['expiry_date']);
            $this->db->bind(':cvv', $data['cvv']);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log('Error in AddBankAccount: ' . $e->getMessage());
            return false;
        }
    }

    public function GetBankAndCardDetails($user_id) {
        try {
            $this->db->query('SELECT * FROM bank_details WHERE user_id = :user_id');
            $this->db->bind(':user_id', $user_id);
            return $this->db->single();
        } catch (Exception $e) {
            error_log('Error in GetBankAndCardDetails: ' . $e->getMessage());
            return null;
        }
    }

    public function getBankAccountData($user_id) {
        try {
            $this->db->query('SELECT * FROM bank_details WHERE user_id = :user_id');
            $this->db->bind(':user_id', $user_id);
            return $this->db->single();
        } catch (Exception $e) {
            error_log('Error in getBankAccountData: ' . $e->getMessage());
            return null;
        }
    }

    public function getUserById ($id){
        $this->db->query('SELECT * FROM users WHERE user_id = :id');
        $this->db->bind(':id',$id);
        $row = $this->db->single();
        return $row;
    }   
    
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
            GROUP BY corn_products.product_id;");
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

    public function stockHolders() {
        try {
            $this->db->query('
                SELECT 
                    u.user_id,
                    u.name,
                    u.email,
                    u.phone,                    
                    IFNULL(pp.file_path, "images/default.jpg") AS profile_image,
                    SUM(o.quantity) AS total_quantity
                FROM orders_from_buyers o
                INNER JOIN users u ON o.buyer_id = u.user_id
                LEFT JOIN profile_pictures pp ON u.user_id = pp.user_id
                WHERE o.payment_status = "paid"
                AND u.user_type = "buyer"
                GROUP BY u.user_id, u.name, u.email, u.phone,pp.file_path
                HAVING SUM(o.quantity) > 1000
                ORDER BY total_quantity DESC
            ');
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log('Error in stockHolders: ' . $e->getMessage());
            return [];
        }
    }

}
?>