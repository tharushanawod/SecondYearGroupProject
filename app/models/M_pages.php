<?php
class M_pages {
    private $db;

    public function __construct() {
        $this->db = new Database(); // Assuming Database class exists
    }

    // Fetch all help requests
    public function getHelpRequests() {
        $this->db->query('SELECT * FROM help_requests ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    // Fetch help requests by category
    public function getRequestsByCategory($category) {
        $this->db->query('SELECT * FROM help_requests WHERE category = :category ORDER BY created_at DESC');
        $this->db->bind(':category', $category);
        return $this->db->resultSet();
    }

    // Add a reply to a help request
    public function addReply($requestId, $moderatorId, $reply) {
        $this->db->query('INSERT INTO help_responses (request_id, moderator_id, user_id, reply, created_at) 
                          VALUES (:request_id, :moderator_id, (SELECT user_id FROM help_requests WHERE id = :request_id), :reply, NOW())');
        $this->db->bind(':request_id', $requestId);
        $this->db->bind(':moderator_id', $moderatorId);
        $this->db->bind(':reply', $reply);
        return $this->db->execute();
    }

    // Update the status of a help request
    public function updateRequestStatus($requestId, $moderatorId, $status) {
        $this->db->query('UPDATE help_requests SET status = :status, moderator_id = :moderator_id, updated_at = NOW() 
                          WHERE id = :request_id');
        $this->db->bind(':request_id', $requestId);
        $this->db->bind(':moderator_id', $moderatorId);
        $this->db->bind(':status', $status);
        return $this->db->execute();
    }

    // Get user info by request ID (for notifications)
    public function getUserByRequestId($requestId) {
        $this->db->query('SELECT user_id, user_role FROM help_requests WHERE id = :request_id');
        $this->db->bind(':request_id', $requestId);
        return $this->db->single();
    }

    public function getRequestById($requestId) {
        $this->db->query('SELECT * FROM help_requests WHERE id = :id');
        $this->db->bind(':id', $requestId);
        return $this->db->single();
    }
}
?>