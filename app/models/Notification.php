<?php

class Notification {
    
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getNotifications() {
        $this->db->query('SELECT * FROM notifications_for_buyers WHERE is_read = 0 AND buyer_id IS NULL');
        return $this->db->resultSet();
    }

    public function getUnreadNotificationsCount() {
        $this->db->query('SELECT COUNT(*) FROM notifications_for_buyers WHERE is_read = 0');
        return $this->db->single();
    }

    public function markNotificationAsRead($notificationId) {
        $this->db->query('UPDATE notifications_for_buyers SET is_read = 1 WHERE id = :id');
        $this->db->bind(':id', $notificationId);
        return $this->db->execute();
    }

    public function getWinningNotifications($buyerId) {
        $this->db->query('SELECT * FROM notifications_for_buyers WHERE buyer_id = :buyer_id');
        $this->db->bind(':buyer_id', $buyerId);
        return $this->db->resultSet();
    }
}