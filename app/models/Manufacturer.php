<?php
// File: models/Manufacturer.php
class Manufacturer {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    // Get user by ID (unchanged)
    public function getUserById($id) {
        $this->db->query('SELECT * FROM users WHERE user_id = :id');
        $this->db->bind(':id', $id);
        $row = $this->db->single();
        return $row;
    }

    public function getFloorPrice() {
        try {
            $this->db->query("SELECT price FROM floor_price WHERE product_type = 'DryCorn' ORDER BY calculated_at DESC LIMIT 1");
            $row = $this->db->single();
            return $row ? $row->price : 1000; // Default to 1000 if no floor price
        } catch (Exception $e) {
            error_log("getFloorPrice error: " . $e->getMessage());
            return 1000; // Fallback
        }
    }

    public function getLastPrice($manufacturer_id) {
        try {
            $this->db->query('SELECT * FROM manufacturer_prices WHERE manufacturer_id = :id ORDER BY updated_at DESC LIMIT 1');
            $this->db->bind(':id', $manufacturer_id);
            return $this->db->single();
        } catch (Exception $e) {
            error_log("getLastPrice error: " . $e->getMessage());
            return null;
        }
    }

    public function getPreviousPrice($manufacturer_id) {
        try {
            $this->db->query('SELECT * FROM manufacturer_prices WHERE manufacturer_id = :id ORDER BY updated_at DESC');
            $this->db->bind(':id', $manufacturer_id);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("getPreviousPrice error: " . $e->getMessage());
            return [];
        }
    }

    public function getPrices($manufacturer_id) {
        try {
            $market_data = $this->getMarketAverage();
            $data = [
                'floor_price' => $this->getFloorPrice(),
                'last_price' => null,
                'market_average' => $market_data['avg_price'],
                'market_average_reliable' => $market_data['is_reliable'],
                'price_history' => $this->getPreviousPrice($manufacturer_id)
            ];
            $lastPrice = $this->getLastPrice($manufacturer_id);
            if ($lastPrice) {
                $data['last_price'] = $lastPrice->unit_price;
            }
            return $data;
        } catch (Exception $e) {
            error_log("getPrices error: " . $e->getMessage());
            return [];
        }
    }

    // File: models/Manufacturer.php
    public function getMarketAverage() {
        try {
            $this->db->query("
                SELECT AVG(b.bid_amount) as avg_price, COUNT(b.bid_id) as bid_count
                FROM bids b
                JOIN corn_products cp ON b.product_id = cp.product_id
                WHERE b.bid_time >= DATE_SUB(NOW(), INTERVAL 30 DAY)
                AND cp.product_type = 'DryCorn'
            ");
            $row = $this->db->single();
            return [
                'avg_price' => $row->avg_price ?? 0,
                'is_reliable' => ($row->bid_count >= 5)
            ];
        } catch (Exception $e) {
            error_log("getMarketAverage error: " . $e->getMessage());
            return ['avg_price' => 0, 'is_reliable' => false];
        }
    }

    public function setMinimumPrice($data) {
        try {
            $existingPrice = $this->getLastPrice($data['manufacturer_id']);
            if ($existingPrice) {
                $this->db->query('UPDATE manufacturer_prices SET unit_price = :unit_price, updated_at = NOW() WHERE id = :id');
                $this->db->bind(':id', $existingPrice->id);
            } else {
                $this->db->query('INSERT INTO manufacturer_prices (manufacturer_id, unit_price, updated_at) VALUES (:manufacturer_id, :unit_price, NOW())');
                $this->db->bind(':manufacturer_id', $data['manufacturer_id']);
            }
            $this->db->bind(':unit_price', $data['unit_price']);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("setMinimumPrice error: " . $e->getMessage());
            return false;
        }
    }

    public function deleteLastPrice($manufacturer_id) {
        try {
            $lastPrice = $this->getLastPrice($manufacturer_id);
            if ($lastPrice) {
                $this->db->query('DELETE FROM manufacturer_prices WHERE id = :id');
                $this->db->bind(':id', $lastPrice->id);
                return $this->db->execute();
            }
            return false;
        } catch (Exception $e) {
            error_log("deleteLastPrice error: " . $e->getMessage());
            return false;
        }
    }

    // Save help request
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

    // Get all Farmers (for StockHolders)
    public function getAllFarmers() {
        $this->db->query("
            SELECT users.user_id, users.name, farmers.district, AVG(buyer_reviews_farmer.rating) AS avg_rating
            FROM users
            INNER JOIN farmers ON users.user_id = farmers.user_id
            LEFT JOIN buyer_reviews_farmer ON users.user_id = buyer_reviews_farmer.farmer_id
            GROUP BY users.user_id
        ");
        return $this->db->resultSet();
    }

    // Get all Buyers (for StockHolders)
    public function getAllBuyers() {
        $this->db->query("
            SELECT users.user_id, users.name
            FROM users
            INNER JOIN buyers ON users.user_id = buyers.user_id
        ");
        return $this->db->resultSet();
    }

    // Get available products for bidding
    public function getAvailableProducts() {
        $this->db->query("
            SELECT corn_products.*, 
                MAX(bids.bid_amount) AS highest_bid, 
                COALESCE(AVG(buyer_reviews_farmer.rating), 0) AS avg_rating
            FROM corn_products
            LEFT JOIN buyer_reviews_farmer 
            ON corn_products.user_id = buyer_reviews_farmer.farmer_id
            LEFT JOIN bids 
            ON corn_products.product_id = bids.product_id
            WHERE closing_date > NOW()
            GROUP BY corn_products.product_id
        ");
        return $this->db->resultSet();
    }

    // Get product by ID
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
            GROUP BY corn_products.product_id, users.name, farmers.district
        ");
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Get Farmer by ID
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
                profile_pictures.file_path
        ');
        $this->db->bind(':id', $id);
        return $this->db->single();
    }

    // Submit a bid
    public function submitBid($data) {
        $this->db->query("INSERT INTO bids (product_id, buyer_id, bid_amount, payment_status) VALUES (:product_id, :buyer_id, :bid_amount, :payment_status)");
        $this->db->bind(':product_id', $data['product_id']);
        $this->db->bind(':buyer_id', $data['buyer_id']);
        $this->db->bind(':bid_amount', $data['bid_amount']);
        $this->db->bind(':payment_status', 'Pending');
        return $this->db->execute();
    }

    // Add a review for a Farmer
    public function AddReview($data) {
        $this->db->query('INSERT INTO buyer_reviews_farmer (review_text, rating, buyer_id, farmer_id) VALUES (:review_text, :rating, :buyer_id, :farmer_id)');
        $this->db->bind(':review_text', $data['review_text']);
        $this->db->bind(':rating', $data['rating']);
        $this->db->bind(':buyer_id', $data['buyer_id']);
        $this->db->bind(':farmer_id', $data['farmer_id']);
        return $this->db->execute();
    }

    // Fetch reviews for a Farmer
    public function fetchReviews($id) {
        $this->db->query('
            SELECT buyer_reviews_farmer.*, users.name, profile_pictures.file_path
            FROM buyer_reviews_farmer
            INNER JOIN users ON buyer_reviews_farmer.buyer_id = users.user_id
            LEFT JOIN profile_pictures ON users.user_id = profile_pictures.user_id
            WHERE buyer_reviews_farmer.farmer_id = :id
        ');
        $this->db->bind(':id', $id);
        return $this->db->resultSet();
    }

    // Get all active bids for the Manufacturer
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
            AND corn_products.closing_date > NOW()
        ');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    // Cancel a bid
    public function cancelBid($bid_id) {
        $this->db->query('DELETE FROM bids WHERE bid_id = :bid_id');
        $this->db->bind(':bid_id', $bid_id);
        return $this->db->execute();
    }

    // Get pending payments
    public function getPendingPayments($user_id) {
        $this->db->query('
            SELECT * FROM orders_from_buyers
            WHERE buyer_id = :user_id
            AND payment_status = "Pending"
        ');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    // Get payment details for an order
    public function getPaymentDetailsForOrder($order_id) {
        $this->db->query('
            SELECT * FROM orders_from_buyers
            WHERE order_id = :order_id
        ');
        $this->db->bind(':order_id', $order_id);
        return $this->db->single();
    }

    // Update payment status
    public function updatePaymentStatus($order_id, $payment_status) {
        $this->db->query('UPDATE orders_from_buyers SET payment_status = :payment_status WHERE order_id = :order_id');
        $this->db->bind(':payment_status', $payment_status);
        $this->db->bind(':order_id', (int)$order_id);
        return $this->db->execute();
    }

    // Get purchase history
    public function getPurchaseHistory($user_id) {
        $this->db->query('
            SELECT orders_from_buyers.*, corn_products.quantity, corn_products.closing_date
            FROM orders_from_buyers
            INNER JOIN corn_products ON orders_from_buyers.product_id = corn_products.product_id
            WHERE orders_from_buyers.buyer_id = :user_id
            ORDER BY orders_from_buyers.order_date DESC
        ');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    // Add bank account details
    public function AddBankAccount($data) {
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
    }

    // Get bank and card details
    public function GetBankAndCardDetails($user_id) {
        $this->db->query('SELECT * FROM bank_details WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->single();
    }

    // Get bank account data
    public function getBankAccountData($user_id) {
        $this->db->query('SELECT * FROM bank_details WHERE user_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        return $this->db->single();
    }

    // File: models/Manufacturer.php
public function getRecentBids($manufacturer_id) {
    try {
        $this->db->query("
            SELECT u.name AS farmer, b.bid_amount, b.status
            FROM bids b
            JOIN corn_products cp ON b.product_id = cp.product_id
            JOIN users u ON cp.user_id = u.user_id
            WHERE b.buyer_id = :manufacturer_id
            ORDER BY b.bid_time DESC
            LIMIT 5
        ");
        $this->db->bind(':manufacturer_id', $manufacturer_id);
        return $this->db->resultSet();
    } catch (Exception $e) {
        error_log("getRecentBids error: " . $e->getMessage());
        return [];
    }
}

public function getRecentPurchases($manufacturer_id) {
    try {
        $this->db->query("
            SELECT u.name AS source, o.bid_price AS amount, 
                   CASE WHEN o.order_type = 'auction' THEN 'Auction' ELSE 'Direct' END AS type
            FROM orders_from_buyers o
            JOIN corn_products cp ON o.product_id = cp.product_id
            JOIN users u ON cp.user_id = u.user_id
            WHERE o.buyer_id = :manufacturer_id
            ORDER BY o.order_date DESC
            LIMIT 5
        ");
        $this->db->bind(':manufacturer_id', $manufacturer_id);
        return $this->db->resultSet();
    } catch (Exception $e) {
        error_log("getRecentPurchases error: " . $e->getMessage());
        return [];
    }
}

}
?>