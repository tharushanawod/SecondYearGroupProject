<?php
class Cart {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function addToCart($customer_id, $product_id, $quantity) {
        $this->db->query('SELECT price, category_id FROM supplier_products WHERE product_id = :product_id');
        $this->db->bind(':product_id', $product_id);
        $product = $this->db->single();

        $totalAmount = $product->price * $quantity;

        // Insert into cart table if not exists
        $this->db->query('INSERT INTO cart (customer_id) VALUES (:customer_id) ON DUPLICATE KEY UPDATE customer_id = customer_id');
        $this->db->bind(':customer_id', $customer_id);
        $this->db->execute();

        // Get the cart_id
        $this->db->query('SELECT cart_id FROM cart WHERE customer_id = :customer_id');
        $this->db->bind(':customer_id', $customer_id);
        $cart = $this->db->single();
        $cart_id = $cart->cart_id;

        // Insert into cart_items table
        $this->db->query('INSERT INTO cart_items (cart_id, product_id, quantity, totalAmount) 
                         VALUES (:cart_id, :product_id, :quantity, :totalAmount)');
        
        $this->db->bind(':cart_id', $cart_id);
        $this->db->bind(':product_id', $product_id);
        $this->db->bind(':quantity', $quantity);
        $this->db->bind(':totalAmount', $totalAmount);

        return $this->db->execute();
    }

    public function addCartItem($data) {
        $this->db->query('SELECT price FROM supplier_products WHERE product_id = :product_id');
        $this->db->bind(':product_id', $data['product_id']);
        $product = $this->db->single();

        $totalAmount = $product->price * $data['quantity'];

        // Insert into cart table if not exists
        $this->db->query('INSERT INTO cart (customer_id) VALUES (:customer_id) ON DUPLICATE KEY UPDATE customer_id = customer_id');
        $this->db->bind(':customer_id', $data['user_id']);
        $this->db->execute();

        // Get the cart_id
        $this->db->query('SELECT cart_id FROM cart WHERE customer_id = :customer_id');
        $this->db->bind(':customer_id', $data['user_id']);
        $cart = $this->db->single();
        $cart_id = $cart->cart_id;

        // Insert into cart_items table
        $this->db->query('INSERT INTO cart_items (cart_id, product_id, quantity, totalAmount) 
                         VALUES (:cart_id, :product_id, :quantity, :totalAmount)');
        
        $this->db->bind(':cart_id', $cart_id);
        $this->db->bind(':product_id', $data['product_id']);
        $this->db->bind(':quantity', $data['quantity']);
        $this->db->bind(':totalAmount', $totalAmount);

        return $this->db->execute();
    }

    public function getCartItems($customer_id) {
        $this->db->query('SELECT ci.*, p.name as product_name, p.image, p.price, 
                         cat.name as category_name 
                         FROM cart_items ci 
                         JOIN supplier_products p ON ci.product_id = p.product_id 
                         JOIN categories cat ON p.category_id = cat.category_id 
                         JOIN cart c ON ci.cart_id = c.cart_id 
                         WHERE c.customer_id = :customer_id');
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










