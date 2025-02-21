<?php

class Notification {
    
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getNotifications() {
        $this->db->query('SELECT * FROM farmer_add_products_notifications WHERE is_read = 0');
        return $this->db->resultSet();
    }

    public function getUnreadNotificationsCount() {
        $this->db->query('SELECT COUNT(*) FROM farmer_add_products_notifications WHERE is_read = 0');
        return $this->db->single();
    }

    public function markNotificationAsRead($notificationId) {
        $this->db->query('UPDATE farmer_add_products_notifications SET is_read = 1 WHERE id = :id');
        $this->db->bind(':id', $notificationId);
        return $this->db->execute();
    }
}