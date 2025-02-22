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
       COALESCE(AVG(buyer_reviews_farmer.rating), 0) AS avg_rating
FROM corn_products
LEFT JOIN buyer_reviews_farmer 
ON corn_products.user_id = buyer_reviews_farmer.farmer_id
WHERE closing_date > NOW()
GROUP BY corn_products.product_id
");
        $rows = $this->db->resultSet();
        return $rows;
    }

    public function getProductById($id) {
        $this->db->query("
        SELECT corn_products.*,users.name,farmers.district 
        FROM corn_products
        INNER JOIN users ON corn_products.user_id = users.user_id
        LEFT JOIN farmers ON corn_products.user_id = farmers.user_id
         WHERE product_id = :id
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
    $worker = $this->db->single();
    return $worker;
    
       

    }

    public function SubmitBid($data) {
        $this->db->query("INSERT INTO bids (product_id, buyer_id, bid_amount) VALUES (:product_id, :buyer_id, :bid_amount)");
        $this->db->bind(':product_id', $data['product_id']);
        $this->db->bind(':buyer_id', $data['buyer_id']);
        $this->db->bind(':bid_amount', $data['bid_amount']);

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

    

  
    

}
?>