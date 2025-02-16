<?php
class Cart {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function addToCart($data) {
        try {
            // Get product details first
            $this->db->query('SELECT price, category_id FROM supplier_products WHERE product_id = :product_id');
            $this->db->bind(':product_id', $data['product_id']);
            $product = $this->db->single();

            if (!$product) {
                throw new Exception("Product not found");
            }

            $total_amount = $product->price * $data['quantity'];

            // Check if item already exists in cart
            $this->db->query('SELECT cart_id, quantity FROM cart 
                             WHERE customer_id = :customer_id AND product_id = :product_id');
            $this->db->bind(':customer_id', $data['user_id']);
            $this->db->bind(':product_id', $data['product_id']);
            $existing_item = $this->db->single();

            if ($existing_item) {
                // Update existing cart item
                $this->db->query('UPDATE cart 
                                 SET quantity = quantity + :quantity,
                                     totalAmount = totalAmount + :total_amount 
                                 WHERE customer_id = :customer_id 
                                 AND product_id = :product_id');
            } else {
                // Insert new cart item
                $this->db->query('INSERT INTO cart 
                                (customer_id, product_id, category_id, quantity, totalAmount) 
                                VALUES 
                                (:customer_id, :product_id, :category_id, :quantity, :total_amount)');
                $this->db->bind(':category_id', $product->category_id);
            }

            $this->db->bind(':customer_id', $data['user_id']);
            $this->db->bind(':product_id', $data['product_id']);
            $this->db->bind(':quantity', $data['quantity']);
            $this->db->bind(':total_amount', $total_amount);

            return $this->db->execute();

        } catch (Exception $e) {
            error_log("Error in addToCart: " . $e->getMessage());
            throw $e;
        }
    }

    public function getCartItems($customer_id) {
        $this->db->query(
            'SELECT c.*, sp.product_name, sp.price, sp.image, sp.stock,
                    cat.category_name 
             FROM cart c
             JOIN supplier_products sp ON c.product_id = sp.product_id
             JOIN categories cat ON c.category_id = cat.category_id
             WHERE c.customer_id = :customer_id'
        );
        $this->db->bind(':customer_id', $customer_id);
        return $this->db->resultSet();
    }

    public function updateCartItem($cart_item_id, $quantity) {
        $this->db->query('SELECT p.price 
                         FROM cart_items ci 
                         JOIN supplier_products p ON ci.product_id = p.product_id 
                         WHERE ci.cart_item_id = :cart_item_id');
        $this->db->bind(':cart_item_id', $cart_item_id);
        $product = $this->db->single();

        $totalAmount = $product->price * $quantity;

        $this->db->query('UPDATE cart_items 
                         SET quantity = :quantity, 
                             totalAmount = :totalAmount,
                             updated_at = CURRENT_TIMESTAMP 
                         WHERE cart_item_id = :cart_item_id');
        
        $this->db->bind(':cart_item_id', $cart_item_id);
        $this->db->bind(':quantity', $quantity);
        $this->db->bind(':totalAmount', $totalAmount);

        return $this->db->execute();
    }

    public function removeCartItem($cart_item_id) {
        $this->db->query('DELETE FROM cart_items WHERE cart_item_id = :cart_item_id');
        $this->db->bind(':cart_item_id', $cart_item_id);
        return $this->db->execute();
    }

    public function calculateSubTotal($cartItems) {
        $subTotal = 0;
        foreach ($cartItems as $item) {
            $subTotal += $item->totalAmount;
        }
        return $subTotal;
    }

    public function clearCart($customer_id) {
        $this->db->query('DELETE ci FROM cart_items ci 
                         JOIN cart c ON ci.cart_id = c.cart_id 
                         WHERE c.customer_id = :customer_id');
        $this->db->bind(':customer_id', $customer_id);
        return $this->db->execute();
    }
}
?>










