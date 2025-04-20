<?php
class M_pages {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getHelpRequests() {
        $this->db->query('SELECT * FROM help_requests ORDER BY created_at DESC');
        return $this->db->resultSet();
    }

    public function getRequestsByCategory($category) {
        $this->db->query('SELECT * FROM help_requests WHERE category = :category ORDER BY created_at DESC');
        $this->db->bind(':category', $category);
        return $this->db->resultSet();
    }

    public function addReply($requestId, $moderatorId, $reply) {
        // Validate request_id exists
        $this->db->query('SELECT user_id FROM help_requests WHERE id = :request_id');
        $this->db->bind(':request_id', $requestId);
        $user = $this->db->single();

        if (!$user || !$user->user_id) {
            error_log("Invalid request_id $requestId or missing user_id in addReply");
            return false;
        }

        // Insert reply
        $this->db->query('INSERT INTO help_responses (request_id, moderator_id, user_id, reply, created_at) 
                          VALUES (:request_id, :moderator_id, :user_id, :reply, NOW())');
        $this->db->bind(':request_id', $requestId);
        $this->db->bind(':moderator_id', $moderatorId);
        $this->db->bind(':user_id', $user->user_id);
        $this->db->bind(':reply', $reply);
        try {
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Failed to insert reply for request_id $requestId: " . $e->getMessage());
            return false;
        }
    }

    public function updateRequestStatus($requestId, $moderatorId, $status) {
        $this->db->query('UPDATE help_requests SET status = :status, moderator_id = :moderator_id, updated_at = NOW() 
                          WHERE id = :request_id');
        $this->db->bind(':request_id', $requestId);
        $this->db->bind(':moderator_id', $moderatorId);
        $this->db->bind(':status', $status);
        try {
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Failed to update status for request_id $requestId: " . $e->getMessage());
            return false;
        }
    }

    public function getUserByRequestId($requestId) {
        $this->db->query('SELECT user_id, user_role, category FROM help_requests WHERE id = :request_id');
        $this->db->bind(':request_id', $requestId);
        return $this->db->single();
    }

    public function getRequestsByUserId($userId) {
        $this->db->query('
            SELECT hr.id, hr.category, hr.subject, hr.description, hr.attachment, hr.status, hr.created_at, hres.reply
            FROM help_requests hr
            LEFT JOIN help_responses hres ON hr.id = hres.request_id
            WHERE hr.user_id = :user_id
            ORDER BY hr.created_at DESC
        ');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
    }

    public function getRequestById($requestId) {
        $this->db->query('
            SELECT hr.*, hres.reply
            FROM help_requests hr
            LEFT JOIN help_responses hres ON hr.id = hres.request_id
            WHERE hr.id = :request_id
        ');
        $this->db->bind(':request_id', $requestId);
        return $this->db->single();
    }

    public function saveRequest($data) {
        $this->db->query('
            INSERT INTO help_requests (user_id, category, subject, description, attachment, status, created_at)
            VALUES (:user_id, :category, :subject, :description, :attachment, :status, :created_at)
        ');
        $this->db->bind(':user_id', $data['user_id']);
        $this->db->bind(':category', $data['category']);
        $this->db->bind(':subject', $data['subject']);
        $this->db->bind(':description', $data['description']);
        $this->db->bind(':attachment', $data['attachment']);
        $this->db->bind(':status', $data['status']);
        $this->db->bind(':created_at', $data['created_at']);
        return $this->db->execute();
    }
}