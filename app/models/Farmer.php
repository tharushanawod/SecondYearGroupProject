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

    public function getAllOrders() {
        $this->db->query("SELECT * FROM orders_from_buyers");
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
        $this->db->query('SELECT * FROM corn_products WHERE user_id = :userid');
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
    WHERE users.user_id = :id
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
        $this->db->query('SELECT * FROM users WHERE user_id = :id');
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
            $this->db->query('SELECT workers.name AS worker_name, job_requests.* 
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
    
    
    

    
}




?>

