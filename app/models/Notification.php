<?php
class Notification {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getNotifications($buyer_id) {
        $this->db->query('SELECT * FROM notifications_for_buyers 
                          WHERE COALESCE(JSON_CONTAINS(read_buyers, JSON_QUOTE(:buyer_id)), 0) = 0');
        $this->db->bind(':buyer_id', $buyer_id);
        return $this->db->resultSet();
    }    

    public function getJobNotifications($worker_id) {
        $this->db->query('SELECT * FROM notifications_for_users 
                          WHERE is_read = 0 AND user_id = :user_id ');
        $this->db->bind(':user_id', $worker_id);
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
        return $this->db->execute();
    }

    public function markJobNotificationAsRead($notification_id, $worker_id) {
        // Update the 'read_buyers' column by appending the buyer_id to the JSON array, 
        // and handle the case where read_buyers is NULL (initialize as empty array)
        $this->db->query('UPDATE notifications_for_users
                          SET is_read = 1
                          WHERE id = :notification_id 
                          AND user_id = :user_id');


        
        // Bind the parameters
        $this->db->bind(':user_id', $worker_id);
        $this->db->bind(':notification_id', $notification_id);
        
        // Execute the update query
        return $this->db->execute();
    }


    public function getWinningNotifications($buyerId) {
        $this->db->query('SELECT * FROM notifications_for_buyers WHERE buyer_id = :buyer_id');
        $this->db->bind(':buyer_id', $buyerId);
        return $this->db->resultSet();
    }
    

    // Create a notification for a help request reply
    public function createHelpRequestNotification($user_id, $user_role, $request_id) {
        $this->db->query('INSERT INTO notifications (user_id, type, message, related_id, is_read, created_at) 
                          VALUES (:user_id, :type, :message, :related_id, 0, NOW())');
        $this->db->bind(':user_id', $user_id);
        $this->db->bind(':type', 'help_request');
        $this->db->bind(':message', 'Your help request has a new reply!');
        $this->db->bind(':related_id', $request_id);
        try {
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Failed to create notification for user_id $user_id, related_id $request_id: " . $e->getMessage());
            return false;
        }
    }



    // Mark a help request notification as read for users
    public function markHelpNotificationAsRead($notification_id, $user_id) {
        try {
            $this->db->query("UPDATE notifications SET is_read = 1 WHERE id = :notification_id AND user_id = :user_id AND related_id IS NOT NULL");
            $this->db->bind(':notification_id', $notification_id);
            $this->db->bind(':user_id', $user_id);
            return $this->db->execute();
        } catch (PDOException $e) {
            error_log("Database error in markHelpNotificationAsRead: " . $e->getMessage());
            return false;
        }
    }

    // Get count of unread help request notifications for users
    public function getUnreadHelpNotificationsCountForUser($user_id) {
        $this->db->query('SELECT COUNT(*) AS count FROM notifications 
                          WHERE user_id = :user_id 
                          AND type = "help_request" 
                          AND is_read = 0');
        $this->db->bind(':user_id', $user_id);
        try {
            return $this->db->single();
        } catch (Exception $e) {
            error_log("Failed to count unread notifications for user_id $user_id: " . $e->getMessage());
            return (object) ['count' => 0];
        }
    }

    public function getHelpRequestsWithResponses($user_id) {
        $this->db->query('
            SELECT 
                hr.id,
                hr.category,
                hr.subject,
                hr.status,
                hr.created_at,
                hres.reply,
                hres.created_at AS response_created_at,
                n.id AS notification_id
            FROM 
                help_requests hr
            LEFT JOIN 
                help_responses hres ON hr.id = hres.request_id
            LEFT JOIN 
                notifications n ON hr.id = n.related_id AND n.type = "help_request" AND n.user_id = hr.user_id
            WHERE 
                hr.user_id = :user_id
            ORDER BY 
                hr.created_at DESC
        ');
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

        // Fetch help request notifications for users
   public function getHelpRequestNotificationsForUser($user_id) {
    $this->db->query('SELECT * FROM notifications 
                      WHERE user_id = :user_id 
                      AND type = "help_request" 
                      AND is_read = 0 
                      ORDER BY created_at DESC');
    $this->db->bind(':user_id', $user_id);
    try {
        return $this->db->resultSet();
    } catch (Exception $e) {
        error_log("Failed to fetch notifications for user_id $user_id: " . $e->getMessage());
        return [];
    }
}


public function getOrdertNotificationsForUser($user_id) {
    $this->db->query('SELECT * FROM notifications_for_users 
                      WHERE user_id = :user_id 
                      AND is_read = 0 
                      ORDER BY created_at DESC');
    $this->db->bind(':user_id', $user_id);
    try {
        return $this->db->resultSet();
    } catch (Exception $e) {
        error_log("Failed to fetch order notifications for user_id $user_id: " . $e->getMessage());
        return [];
    }


    
}


}