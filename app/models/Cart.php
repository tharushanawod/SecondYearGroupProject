<?php
class Cart {
    private $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getCartItems($user_id) {
        $this->db->query("SELECT * FROM cart WHERE user_id = :user_id");
        $this->db->bind(':user_id', $user_id);
        return $this->db->resultSet();
    }

    public function addProductToCart($product_id, $user_id) {
        $this->db->query("INSERT INTO cart (product_id, user_id) VALUES (:product_id, :user_id)");
        $this->db->bind(':product_id', $product_id);
        $this->db->bind(':user_id', $user_id);
        return $this->db->execute();
    }

    public function removeProductFromCart($cart_id) {
        $this->db->query("DELETE FROM cart WHERE cart_id = :cart_id");
        $this->db->bind(':cart_id', $cart_id);
        return $this->db->execute();
    }

    public function clearCart($user_id) {
        $this->db->query("DELETE FROM cart WHERE user_id = :user_id");
        $this->db->bind(':user_id', $user_id);
        return $this->db->execute();
    }

    public function getCartTotal($user_id) {
        $this->db->query("SELECT SUM(price) AS total FROM cart WHERE user_id = :user_id");
        $this->db->bind(':user_id', $user_id);
        return $this->db->single();
    }

    public function getCartItem($cart_id) {
        $this->db->query("SELECT * FROM cart WHERE cart_id = :cart_id");
        $this->db->bind(':cart_id', $cart_id);
        return $this->db->single();
    }

    public function updateCartItem($cart_id, $quantity) {
        $this->db->query("UPDATE cart SET quantity = :quantity WHERE cart_id = :cart_id");
        $this->db->bind(':cart_id', $cart_id);
        $this->db->bind(':quantity', $quantity);
        return $this->db->execute();
    }    
}