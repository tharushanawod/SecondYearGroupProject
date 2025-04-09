<?php

class Notification {
    
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getNotifications($buyer_id) {
        $this->db->query('SELECT * FROM notifications_for_buyers 
                          WHERE COALESCE(JSON_CONTAINS(read_buyers, JSON_QUOTE(:buyer_id)), 0) = 0');
        $this->db->bind(':buyer_id', $buyer_id);
        return $this->db->resultSet();
    }    
    

    public function getUnreadNotificationsCount($buyer_id) {
        $this->db->query('SELECT COUNT(*) AS count FROM notifications_for_buyers 
            WHERE COALESCE(JSON_CONTAINS(read_buyers, JSON_QUOTE(:buyer_id)), 0) = 0');
        $this->db->bind(':buyer_id', $buyer_id);
        return $this->db->single();
    }
    

    public function markNotificationAsRead($notification_id, $buyer_id) {
        // Update the 'read_buyers' column by appending the buyer_id to the JSON array, 
        // and handle the case where read_buyers is NULL (initialize as empty array)
        $this->db->query('UPDATE notifications_for_buyers 
                          SET read_buyers = JSON_ARRAY_APPEND(COALESCE(read_buyers, JSON_ARRAY()), "$", :buyer_id)
                          WHERE id = :notification_id 
                          AND NOT JSON_CONTAINS(COALESCE(read_buyers, JSON_ARRAY()), JSON_QUOTE(:buyer_id))');
        
        // Bind the parameters
        $this->db->bind(':buyer_id', $buyer_id);
        $this->db->bind(':notification_id', $notification_id);
        
        // Execute the update query
        $this->db->execute();
    }

    public function getWinningNotifications($buyerId) {
        $this->db->query('SELECT * FROM notifications_for_buyers WHERE buyer_id = :buyer_id');
        $this->db->bind(':buyer_id', $buyerId);
        return $this->db->resultSet();
    }
}