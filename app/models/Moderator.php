<?php 

class Moderator{

    private $db;

    public function __construct() {
        $this->db = new Database();
    }

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

    public function getUserById ($id){
        $this->db->query('SELECT * FROM users WHERE user_id = :id');
        $this->db->bind(':id',$id);
        $row = $this->db->single();
        return $row;
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

        public function getAccountLog(){
            $this->db->query('SELECT * FROM restriction_logs');
            $rows = $this->db->resultSet();
            return $rows;
        }

        public function getBuyerOrderLog(){
            $this->db->query('SELECT * FROM orders_from_buyers');
            $rows = $this->db->resultSet();
            return $rows;
        }

        public function getBuyerTransactionLog(){
            $this->db->query('SELECT * FROM buyer_payments');
            $rows = $this->db->resultSet();
            return $rows;
        }

        

        public function getFarmerOrderLog(){
            $this->db->query('SELECT o.order_id,
                o.user_id as farmer_id,
                o.first_name,
                o.last_name,
                o.address,
                o.city,
                o.postcode,
                o.phone,
                o.order_date,
                oi.product_id,
                oi.quantity,
                oi.price,
                oi.supplier_confirmed,
                oi.delivery_confirmed,
                oi.withdraw_status,
                oi.wallet_status,
                oi.refund_status,
                oi.status AS status,
                u.name AS supplier_name,
                sp.supplier_id,
                sp.product_name
                FROM orders AS o
            INNER JOIN order_items oi ON o.order_id = oi.order_id
            INNER JOIN supplier_products sp ON oi.product_id = sp.product_id
               INNER JOIN users u  ON sp.supplier_id = u.user_id
           ');

            $rows = $this->db->resultSet();
            return $rows;
        }

        public function getFarmerTransactionLog(){
            $this->db->query('SELECT * FROM transaction');
            $rows = $this->db->resultSet();
            return $rows;
        }

        public function ReportToAdmin($data) {
            $this->db->query('INSERT INTO reports_to_admin (user_id, moderator_comments,moderator_id) VALUES (:user_id,:moderator_comments,:moderator_id)');
            $this->db->bind(':moderator_id', $_SESSION['user_id']);
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':moderator_comments', $data['moderator_comments']);

            if ($this->db->execute()) {
                return true;
            } else {
                return false;
            }
        }

        public function getFarmerOrderDeatails($order_id,$product_id){
            $this->db->query('SELECT order_id,product_id,quantity,price
            FROM order_items WHERE order_id = :order_id AND product_id = :product_id');
            $this->db->bind(':order_id',$order_id);
            $this->db->bind(':product_id',$product_id);
            $row = $this->db->single();

            return $row;
         
        }


}
?>