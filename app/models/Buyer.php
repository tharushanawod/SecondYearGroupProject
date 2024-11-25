<?php

class Buyer {
    
    private $db;

    public function __construct(){
        $this->db = new Database();
    }

    public function getProducts(){
        $this->db->query('SELECT * FROM products');
        $results = $this->db->resultSet();
        return $results;
    }

    public function placeBid($data){
        $this->db->query('INSERT INTO bids (product_id, buyer_id, bid_amount) VALUES(:product_id, :buyer_id, :bid_amount)');
        $this->db->bind(':product_id', $data['product_id']);
        $this->db->bind(':buyer_id', $data['buyer_id']);
        $this->db->bind(':bid_amount', $data['bid_amount']);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function getBids(){
        $this->db->query('SELECT * FROM bids');
        $results = $this->db->resultSet();
        return $results;
    }

    public function deleteBid($id){
        $this->db->query('DELETE FROM bids WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function getFeedbacks(){
        $this->db->query('SELECT * FROM feedbacks');
        $results = $this->db->resultSet();
        return $results;
    }

    public function addFeedback($data){
        $this->db->query('INSERT INTO feedbacks (buyer_id, feedback) VALUES(:buyer_id, :feedback)');
        $this->db->bind(':buyer_id', $data['buyer_id']);
        $this->db->bind(':feedback', $data['feedback']);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

    public function deleteFeedback($id){
        $this->db->query('DELETE FROM feedbacks WHERE id = :id');
        $this->db->bind(':id', $id);

        if($this->db->execute()){
            return true;
        } else {
            return false;
        }
    }

}
?>