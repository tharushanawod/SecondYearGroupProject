<?php

class Farmer {
    
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getInventory(){
        $this->db->query('SELECT * FROM inventory');
        $results = $this->db->resultSet();
        return $results;
    }

    public function AddProduct($data) {
        $this->db->query('INSERT INTO corn_products (starting_price,quantity, media, closing_date, user_id) 
        VALUES(:starting_price,:quantity, :media, :closing_date, :user_id)');
        $this->db->bind(':starting_price', $data['price']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':media', $data['media']);
        $this->db->bind(':closing_date', $data['closing_date']); 
        $this->db->bind(':user_id', $data['user_id']);
    
        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function getProducts($id){
        $this->db->query('SELECT * FROM supplier_products WHERE product_id = :id');
        $this->db->bind(':id', $id);
        $result = $this->db->single();
        return $result;
    }

    public function getCornProductDetails($id){
        $this->db->query('SELECT * FROM corn_products WHERE product_id = :id');
        $this->db->bind(':id', $id);
        $result = $this->db->single();
        return $result;
    }

    public function getAllOrders($farmer_id) {
        $this->db->query("SELECT 
        orders_from_buyers.*,
        buyer_payments.farmer_confirmed,
        buyer_payments.buyer_confirmed,
        buyer_payments.refund_status
        FROM orders_from_buyers
        LEFT JOIN buyer_payments ON orders_from_buyers.order_id = buyer_payments.order_id
        WHERE orders_from_buyers.farmer_id = :farmer_id
        ");
        $this->db->bind(':farmer_id', $farmer_id);
        return $this->db->resultSet();  // Returns an array of orders
    }

    public function getRelatedProducts($category_id, $product_id) {
        $this->db->query('SELECT * FROM supplier_products WHERE category_id = :category_id AND product_id != :product_id LIMIT 4');
        $this->db->bind(':category_id', $category_id);
        $this->db->bind(':product_id', $product_id);
        return $this->db->resultSet();
    }

    public function UpdateCornProducts($data) {
        try {
            $this->db->query('
                UPDATE corn_products 
                SET starting_price = :starting_price, 
                    quantity = :quantity, 
                    media = :media, 
                    closing_date = :closing_date
                WHERE product_id = :id
            ');
            
            $this->db->bind(':starting_price', $data['starting_price']);
            $this->db->bind(':quantity', $data['quantity']);
            $this->db->bind(':media', $data['media']);
            $this->db->bind(':closing_date', $data['closing_date']);
            $this->db->bind(':id', $data['id']); // Bind product_id
    
            return $this->db->execute();
            
        } catch (Exception $e) {
            echo "<b>Error:</b> " . $e->getMessage();
            return false;
        }
    }
    
    

    public function editProduct($data) {
        $this->db->query('UPDATE products 
            SET type = :type, 
                price = :price, 
                quantity = :quantity, 
                media = :media, 
                expiry_date = :expiry_date, 
                userid = :userid 
            WHERE productid = :id');
    
        // Bind parameters to query
        $this->db->bind(':type', $data['type']);
        $this->db->bind(':price', $data['price']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':media', $data['media']);
        $this->db->bind(':expiry_date', $data['expiry_date']);
        $this->db->bind(':userid', $data['userid']);
        $this->db->bind(':id', $data['id']); // Bind the product ID to :id
    
        // Execute the query and return the result
        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
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
    
   

    // public function getOrders(){
    //     $this->db->query('SELECT * FROM orders');
    //     $results = $this->db->resultSet();
    //     return $results;
    // }

    public function getWorkers(){
        $this->db->query('SELECT * FROM workers');
        $results = $this->db->resultSet();
        return $results;
    }      

    public function purchaseIngredients($data){
        $this->db->query('INSERT INTO ingredients (ingredient_name, quantity, price) VALUES(:ingredient_name, :quantity, :price)');
        $this->db->bind(':ingredient_name', $data['ingredient_name']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':price', $data['price']);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function getProductsByFarmerId($farmerId) {
        $this->db->query('SELECT 
                        p.*, 
                        MAX(b.bid_amount) AS highest_bid
                    FROM 
                        corn_products p
                    LEFT JOIN 
                        bids b ON p.product_id = b.product_id
                    WHERE 
                        p.user_id = :userid
                    GROUP BY 
                        p.product_id
                    ORDER BY 
                        p.closing_date DESC;
                    ');
        $this->db->bind(':userid', $farmerId);
        return $this->db->resultSet(); // Fetch all products
    }

    public function deleteProduct($id){
        $this->db->query('DELETE FROM corn_products WHERE product_id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function getFarmworkers() {
   
           

            // Query the database to fetch all farmworkers
            $this->db->query(' SELECT users.name,farmworkers.*, profile_pictures.file_path
                                FROM users
                                INNER JOIN farmworkers ON users.user_id = farmworkers.user_id
                                LEFT JOIN profile_pictures ON farmworkers.user_id = profile_pictures.user_id
                                WHERE users.otp_status = :otp_status AND users.user_status = :user_status AND users.user_type = :user_type;
                                ');
            // Bind parameters
            $this->db->bind(':otp_status', 'verified');
            $this->db->bind(':user_status', 'verified');
            $this->db->bind(':user_type', 'farmworker');

            $workers = $this->db->resultSet();
            return $workers;
       
    }

        public function getFarmworkerById($id) {
            $this->db->query('
            SELECT 
        users.*, 
        farmworkers.*, 
        profile_pictures.file_path, 
        AVG(farmer_reviews_worker.rating) AS average_rating
    FROM users
    INNER JOIN farmworkers ON users.user_id = farmworkers.user_id
    LEFT JOIN profile_pictures ON farmworkers.user_id = profile_pictures.user_id
    LEFT JOIN farmer_reviews_worker ON users.user_id = farmer_reviews_worker.worker_id
    WHERE users.user_id = :id AND is_verified = 1
    GROUP BY 
        users.user_id, 
        farmworkers.user_id, 
        profile_pictures.user_id, 
        profile_pictures.file_path;
        ');
        $this->db->bind(':id', $id);
        $worker = $this->db->single();
        return $worker;
        
        

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


    public function getUserById ($id){
        $this->db->query('SELECT * FROM users
        LEFT JOIN farmers ON users.user_id = farmers.user_id
         WHERE users.user_id = :id');
        $this->db->bind(':id',$id);
        $row = $this->db->single();
        return $row;
    }

    public function AddReview($data) {
        $this->db->query('INSERT INTO farmer_reviews_worker (review_text, rating, farmer_id, worker_id) VALUES (:review_text, :rating, :farmer_id, :worker_id)');
        $this->db->bind(':review_text', $data['review_text']);
        $this->db->bind(':rating', $data['rating']);
        $this->db->bind(':farmer_id', $data['farmer_id']);
        $this->db->bind(':worker_id', $data['worker_id']);
    
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
        SELECT farmer_reviews_worker.*, users.name,profile_pictures.file_path
        FROM farmer_reviews_worker
        INNER JOIN users  ON farmer_reviews_worker.farmer_id = users.user_id
        INNER JOIN profile_pictures  ON users.user_id = profile_pictures.user_id
        WHERE farmer_reviews_worker.worker_id = :id
    ');
       
        $this->db->bind(':id', $id);
        $results = $this->db->resultSet();
        return $results;
    }

    public function getWorkerConfirmedDates($workerId) {
        $this->db->query("SELECT start_date, end_date FROM job_requests 
                          WHERE worker_id = :worker_id AND status = 'Confirmed'");
        $this->db->bind(':worker_id', $workerId);
        $results = $this->db->resultSet();
        
        $bookedDates = [];
        foreach ($results as $row) {
            $startDate = new DateTime($row->start_date);
            $endDate = new DateTime($row->end_date);
            
            $currentDate = clone $startDate;
            while ($currentDate <= $endDate) {
                $bookedDates[] = $currentDate->format('Y-m-d');
                $currentDate->modify('+1 day');
            }
        }
        
        return $bookedDates;
    }

    public function HireWorker($data) {
        $this->db->query('INSERT INTO job_requests (farmer_id,worker_id, job_type, work_duration, start_date, end_date, skills, location, accommodation, food) 
                          VALUES (:farmer_id,:worker_id, :job_type, :work_duration, :start_date, :end_date, :skills, :location, :accommodation, :food)');
        $this->db->bind(':farmer_id', $data['farmerid']);
        $this->db->bind(':worker_id', $data['workerid']);
        $this->db->bind(':job_type', $data['job_type']);
        $this->db->bind(':work_duration', $data['work_duration']);
        $this->db->bind(':start_date', $data['start_date']);
        $this->db->bind(':end_date', $data['end_date']);
        $this->db->bind(':skills', implode(',', $data['skills']));
        $this->db->bind(':location', $data['location']);
        $this->db->bind(':accommodation', $data['accommodation']);
        $this->db->bind(':food', $data['food']);

        if ($this->db->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getPendingJobRequests($id) {
        try {
            // Updated query to get worker's name from the same users table
            $this->db->query('SELECT workers.name AS worker_name, job_requests.* ,workers.phone
                              FROM job_requests
                              INNER JOIN users AS farmers 
                              ON farmers.user_id = job_requests.farmer_id 
                              INNER JOIN users AS workers 
                              ON workers.user_id = job_requests.worker_id 
                              WHERE job_requests.farmer_id = :id AND job_requests.status = "Pending"');
            
            $this->db->bind(':id', $id);
            
            // Fetch results
            $results = $this->db->resultSet();
            return $results;
        } catch (Exception $e) {
            // Log the exception message for debugging
            error_log($e->getMessage());
            return false;
        }
    }
    
    public function getSupplierProducts() {
        $this->db->query('SELECT * FROM supplier_products');
        return $this->db->resultSet();
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

    public function getBuyerDetails($buyer_id){
        $this->db->query('SELECT name,phone FROM users WHERE user_id = :buyer_id');
        $this->db->bind(':buyer_id', $buyer_id);
        $result = $this->db->single();
        return $result;
    }

    public function confirmOrder($order_id){
        $this->db->query('UPDATE buyer_payments SET farmer_confirmed = 1 WHERE order_id = :order_id');
        $this->db->bind(':order_id', $order_id);
        return $this->db->execute();
    }
    
    public function getWalletDetails($farmer_id) {
        try {
            // Start transaction
            $this->db->beginTransaction();
    
            // Get wallet balance
            $this->db->query("SELECT balance FROM wallets WHERE user_id = :farmer_id");
            $this->db->bind(':farmer_id', $farmer_id);
            $wallet = $this->db->single();
    
            // Get successful transactions
            $this->db->query("
                SELECT buyer_payments.order_id,buyer_payments.request_date,buyer_payments.paid_amount,buyer_payments.withdraw_status
                FROM orders_from_buyers
                INNER JOIN buyer_payments 
                ON orders_from_buyers.order_id = buyer_payments.order_id
                WHERE orders_from_buyers.farmer_id = :farmer_id 
                AND buyer_payments.farmer_confirmed = 1
                AND buyer_payments.buyer_confirmed = 1
                AND buyer_payments.wallet_status = 'added'
                AND buyer_payments.withdraw_status = 'not_withdrawn'
            ");

            $this->db->bind(':farmer_id', $farmer_id);
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
    
    public function getRecentOrders($farmer_id) {
        $this->db->query("SELECT * FROM orders_from_buyers
        WHERE orders_from_buyers.farmer_id = :farmer_id
        ORDER BY orders_from_buyers.order_date DESC
        LIMIT 5");
        $this->db->bind(':farmer_id', $farmer_id);
        return $this->db->resultSet();  // Returns an array of recent orders
    }
    public function getTotalOrders($farmer_id) {
        $this->db->query("SELECT COUNT(*) as total_orders FROM orders_from_buyers WHERE farmer_id = :farmer_id");
        $this->db->bind(':farmer_id', $farmer_id);
        $result = $this->db->single();
        return $result->total_orders;  // Returns the total number of orders
    }

    public function getTotalEarnings($farmer_id){
        $this->db->query("SELECT SUM(buyer_payments.paid_amount) as total_earnings FROM orders_from_buyers
        INNER JOIN buyer_payments ON orders_from_buyers.order_id = buyer_payments.order_id
        WHERE orders_from_buyers.farmer_id = :farmer_id AND buyer_payments.farmer_confirmed = 1 AND buyer_payments.buyer_confirmed = 1");
        $this->db->bind(':farmer_id', $farmer_id);
        $result = $this->db->single();
        return $result->total_earnings;  // Returns the total earnings amount
    }

    public function getActiveProducts($farmer_id){
        $this->db->query("SELECT COUNT(*) as total_active_products FROM corn_products
        WHERE closing_date > Now() AND user_id = :farmer_id");
        $this->db->bind(':farmer_id', $farmer_id);
        $result = $this->db->single();
        return $result->total_active_products; 
    }

    public function getActiveAuctions($farmer_id){
        $this->db->query("SELECT COUNT(*) as total_active_auctions FROM corn_products
        WHERE closing_date > Now() AND user_id = :farmer_id");
        $this->db->bind(':farmer_id', $farmer_id);
        $result = $this->db->single();
        return $result->total_active_auctions; 
    }

    public function getLatestBid($farmer_id){
        $this->db->query("SELECT bids.bid_amount,corn_products.quantity
        FROM corn_products
        INNER JOIN bids ON corn_products.product_id = bids.product_id
        WHERE corn_products.user_id = :farmer_id AND corn_products.closing_date > Now() ORDER BY closing_date DESC LIMIT 1");
        $this->db->bind(':farmer_id', $farmer_id);
        $result = $this->db->single();
        return $result; 
    }
    

    public function getToReceiveOrders($userId){
        $this->db->query("SELECT orders.order_id,users.name,order_items.quantity,order_items.price,supplier_products.product_name,orders.order_date,order_items.supplier_confirmed,supplier_products.image,order_items.product_id,delivery_codes.code,delivery_codes.company
        FROM orders
        INNER JOIN order_items ON orders.order_id = order_items.order_id
        INNER JOIN supplier_products ON order_items.product_id = supplier_products.product_id
        INNER JOIN users ON supplier_products.supplier_id = users.user_id
        LEFT JOIN delivery_codes ON orders.order_id = delivery_codes.order_id
        WHERE orders.user_id = :userId AND order_items.status = 'paid' AND order_items.supplier_confirmed = 1 AND order_items.delivery_confirmed = 0
        ORDER BY orders.order_date DESC
        ");
        $this->db->bind(':userId', $userId);
        $result = $this->db->resultSet();
        return $result;
       
    }

    public function getToPickupOrders($userId){
        $this->db->query("SELECT orders.order_id,users.name,order_items.quantity,order_items.price,supplier_products.product_name,orders.order_date,order_items.supplier_confirmed,supplier_products.image
        FROM orders
        INNER JOIN order_items ON orders.order_id = order_items.order_id
        INNER JOIN supplier_products ON order_items.product_id = supplier_products.product_id
        INNER JOIN users ON supplier_products.supplier_id = users.user_id
        WHERE orders.user_id = :userId AND orders.status = 'paid' AND order_items.supplier_confirmed = 0
        ORDER BY orders.order_date DESC");
        $this->db->bind(':userId', $userId);
        $result = $this->db->resultSet();
        return $result;
    }

    public function getToPayOrders($userId){
        $this->db->query("SELECT orders.order_id,order_items.quantity,order_items.price,supplier_products.product_name,orders.order_date,supplier_products.image,orders.total_amount
        FROM orders
        INNER JOIN order_items ON orders.order_id = order_items.order_id
        INNER JOIN supplier_products ON order_items.product_id = supplier_products.product_id
        INNER JOIN users ON supplier_products.supplier_id = users.user_id
        WHERE orders.user_id = :userId AND order_items.status = 'pending' AND order_items.supplier_confirmed = 0
        ORDER BY orders.order_date DESC");
        $this->db->bind(':userId', $userId);
        $result = $this->db->resultSet();
        return $result;
    }

    public function ConfirmIngredientOrderReceive($order_id,$product_id){
        $this->db->query('UPDATE order_items SET delivery_confirmed = "1"
         WHERE order_id = :order_id AND  product_id = :product_id');
        $this->db->bind(':order_id', $order_id);
        $this->db->bind(':product_id', $product_id);
        return $this->db->execute();
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

            $this->db->query('UPDATE buyer_payments 
            INNER JOIN orders_from_buyers ON buyer_payments.order_id = orders_from_buyers.order_id
            SET buyer_payments.withdraw_status = :withdraw_status 
            WHERE buyer_payments.withdraw_status = "not_withdrawn"
            AND orders_from_buyers.farmer_id = :user_id
            ');
            $this->db->bind(':withdraw_status', 'withdrawn');
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

