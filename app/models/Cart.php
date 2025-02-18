<?php
class Cart {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function addToCart($data) {
        try {
            $this->db->beginTransaction();

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
                                     totalAmount = :total_amount 
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

            $result = $this->db->execute();
            $this->db->commit();
            return $result;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error in addToCart: " . $e->getMessage());
            throw $e;
        }
    }

    public function getCartItems($customer_id) {
        try {
            $this->db->query(
                'SELECT c.*, 
                        sp.product_name, 
                        sp.price, 
                        sp.image, 
                        sp.stock,
                        cat.category_name
                 FROM cart c
                 JOIN supplier_products sp ON c.product_id = sp.product_id
                 JOIN categories cat ON c.category_id = cat.category_id
                 WHERE c.customer_id = :customer_id
                 ORDER BY c.createdOn DESC'
            );
            
            $this->db->bind(':customer_id', $customer_id);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("GetCartItems Error: " . $e->getMessage());
            throw $e;
        }
    }

    public function updateCartItem($cart_id, $quantity) {
        try {
            $this->db->beginTransaction();

            $this->db->query('SELECT sp.price 
                             FROM cart c 
                             JOIN supplier_products sp ON c.product_id = sp.product_id 
                             WHERE c.cart_id = :cart_id');
            $this->db->bind(':cart_id', $cart_id);
            $product = $this->db->single();

            if (!$product) {
                throw new Exception("Cart item not found");
            }

            $totalAmount = $product->price * $quantity;

            $this->db->query('UPDATE cart 
                             SET quantity = :quantity, 
                                 totalAmount = :totalAmount
                             WHERE cart_id = :cart_id');
            
            $this->db->bind(':cart_id', $cart_id);
            $this->db->bind(':quantity', $quantity);
            $this->db->bind(':totalAmount', $totalAmount);

            $result = $this->db->execute();
            $this->db->commit();
            return $result;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error in updateCartItem: " . $e->getMessage());
            throw $e;
        }
    }

    public function removeCartItem($cart_id) {
        try {
            $this->db->query('DELETE FROM cart WHERE cart_id = :cart_id');
            $this->db->bind(':cart_id', $cart_id);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Error in removeCartItem: " . $e->getMessage());
            throw $e;
        }
    }

    public function calculateSubTotal($cartItems) {
        return array_reduce($cartItems, function($total, $item) {
            return $total + $item->totalAmount;
        }, 0);
    }

    public function clearCart($customer_id) {
        try {
            $this->db->query('DELETE FROM cart WHERE customer_id = :customer_id');
            $this->db->bind(':customer_id', $customer_id);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Error in clearCart: " . $e->getMessage());
            throw $e;
        }
    }

    public function viewCart($customer_id) {
        try {
            // Fetch cart items with all necessary details
            $cartItems = $this->getCartItems($customer_id);
            
            // Validate cart items
            if (!is_array($cartItems)) {
                throw new Exception("Failed to fetch cart items");
            }

            // Calculate subtotal
            $subTotal = $this->calculateSubTotal($cartItems);

            // Format response
            return [
                'items' => $cartItems,
                'subTotal' => $subTotal,
                'itemCount' => count($cartItems),
                'success' => true
            ];

        } catch (Exception $e) {
            error_log("ViewCart Error: " . $e->getMessage());
            return [
                'items' => [],
                'subTotal' => 0,
                'itemCount' => 0,
                'success' => false,
                'error' => $e->getMessage()
            ];
        }
    }
}
?>
