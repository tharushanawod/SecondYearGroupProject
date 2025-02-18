<?php
class Cart {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function addToCart($data) {
        try {
            $this->db->beginTransaction();

            // First verify product exists and get its details
            $this->db->query('SELECT price, category_id, stock FROM supplier_products WHERE product_id = :product_id');
            $this->db->bind(':product_id', $data['product_id']);
            $product = $this->db->single();

            if (!$product) {
                throw new Exception("Product not found");
            }

            // Verify stock availability
            if ($product->stock < $data['quantity']) {
                throw new Exception("Insufficient stock");
            }

            $totalAmount = $product->price * $data['quantity'];

            // Check if item exists in cart
            $this->db->query('SELECT cart_id, quantity FROM cart 
                             WHERE customer_id = :customer_id 
                             AND product_id = :product_id');
            $this->db->bind(':customer_id', $data['user_id']);
            $this->db->bind(':product_id', $data['product_id']);
            $existingItem = $this->db->single();

            if ($existingItem) {
                // Verify total quantity doesn't exceed stock
                $newQuantity = $existingItem->quantity + $data['quantity'];
                if ($newQuantity > $product->stock) {
                    throw new Exception("Cannot add more items than available stock");
                }

                // Update existing item
                $this->db->query('UPDATE cart 
                                 SET quantity = :quantity,
                                     totalAmount = :total_amount,
                                     updated_at = CURRENT_TIMESTAMP
                                 WHERE cart_id = :cart_id');
                $this->db->bind(':cart_id', $existingItem->cart_id);
                $this->db->bind(':quantity', $newQuantity);
                $this->db->bind(':total_amount', $product->price * $newQuantity);
            } else {
                // Add new item
                $this->db->query('INSERT INTO cart 
                                 (customer_id, product_id, category_id, quantity, totalAmount) 
                                 VALUES (:customer_id, :product_id, :category_id, :quantity, :total_amount)');
                $this->db->bind(':customer_id', $data['user_id']);
                $this->db->bind(':product_id', $data['product_id']);
                $this->db->bind(':category_id', $product->category_id);
                $this->db->bind(':quantity', $data['quantity']);
                $this->db->bind(':total_amount', $totalAmount);
            }

            $result = $this->db->execute();
            
            if (!$result) {
                throw new Exception("Failed to execute cart operation");
            }
            
            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error in addToCart: " . $e->getMessage());
            return false;
        }
    }

    public function getCartItems($user_id) {
        try {
            $this->db->query('SELECT c.*, p.product_name, p.price, p.image, p.stock, cat.category_name
                             FROM cart c 
                             JOIN supplier_products p ON c.product_id = p.product_id 
                             JOIN categories cat ON c.category_id = cat.category_id
                             WHERE c.customer_id = :user_id');
            $this->db->bind(':user_id', $user_id);
            $result = $this->db->resultSet();
            
            // Debug output
            error_log("Cart items query result: " . json_encode($result));
            
            return $result;
        } catch (Exception $e) {
            error_log("Error in getCartItems: " . $e->getMessage());
            return [];
        }
    }

    public function calculateSubTotal($cartItems) {
        return array_reduce($cartItems, function($total, $item) {
            return $total + $item->totalAmount;
        }, 0);
    }

    public function getCartCount($user_id) {
        $this->db->query('SELECT COUNT(*) as count FROM cart WHERE customer_id = :user_id');
        $this->db->bind(':user_id', $user_id);
        $result = $this->db->single();
        return $result->count;
    }

    public function updateQuantity($cart_id, $quantity) {
        try {
            $this->db->query('UPDATE cart 
                             SET quantity = :quantity,
                                 totalAmount = (SELECT price FROM supplier_products WHERE product_id = cart.product_id) * :quantity 
                             WHERE cart_id = :cart_id');
            $this->db->bind(':cart_id', $cart_id);
            $this->db->bind(':quantity', $quantity);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Error in updateQuantity: " . $e->getMessage());
            return false;
        }
    }

    public function removeCartItem($cart_id, $user_id) {
        try {
            $this->db->query('DELETE FROM cart 
                             WHERE cart_id = :cart_id 
                             AND customer_id = :user_id');
            $this->db->bind(':cart_id', $cart_id);
            $this->db->bind(':user_id', $user_id);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Error in removeCartItem: " . $e->getMessage());
            return false;
        }
    }

    public function clearCart($user_id) {
        try {
            $this->db->query('DELETE FROM cart WHERE customer_id = :user_id');
            $this->db->bind(':user_id', $user_id);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Error in clearCart: " . $e->getMessage());
            return false;
        }
    }

    public function getProductDetails($product_id) {
        try {
            $this->db->query('SELECT p.*, c.category_name 
                             FROM supplier_products p
                             JOIN categories c ON p.category_id = c.category_id
                             WHERE p.product_id = :product_id');
            $this->db->bind(':product_id', $product_id);
            return $this->db->single();
        } catch (Exception $e) {
            error_log("Error in getProductDetails: " . $e->getMessage());
            return false;
        }
    }

    public function getRelatedProducts($category_id, $current_product_id) {
        try {
            $this->db->query('SELECT p.*, c.category_name 
                             FROM supplier_products p
                             JOIN categories c ON p.category_id = c.category_id
                             WHERE p.category_id = :category_id 
                             AND p.product_id != :current_product_id
                             LIMIT 4');
            $this->db->bind(':category_id', $category_id);
            $this->db->bind(':current_product_id', $current_product_id);
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error in getRelatedProducts: " . $e->getMessage());
            return [];
        }
    }
}