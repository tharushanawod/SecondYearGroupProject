<?php
class Cart {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getProducts($categoryId = null) {
        try {
            if ($categoryId) {
                $this->db->query('SELECT p.*, c.category_name 
                                FROM supplier_products p 
                                LEFT JOIN categories c ON p.category_id = c.category_id 
                                WHERE p.category_id = :category_id AND p.stock > 0');
                $this->db->bind(':category_id', $categoryId);
            } else {
                $this->db->query('SELECT p.*, c.category_name 
                                FROM supplier_products p 
                                LEFT JOIN categories c ON p.category_id = c.category_id 
                                WHERE p.stock > 0');
            }
            
            return $this->db->resultSet();
        } catch (Exception $e) {
            error_log("Error in Cart Model getProducts: " . $e->getMessage());
            throw $e;
        }
    }

    public function getCategories() {
        $this->db->query('SELECT * FROM categories ORDER BY category_name');
        return $this->db->resultSet();
    }

    public function addToCart($data) {
        try {
            // First check if product already exists in cart
            $this->db->query('SELECT * FROM cart WHERE customer_id = :user_id AND product_id = :product_id');
            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':product_id', $data['product_id']);
            $existing = $this->db->single();

            if ($existing) {
                // Update existing cart item
                $this->db->query('UPDATE cart 
                                 SET quantity = quantity + :quantity,
                                     totalAmount = totalAmount + :total_amount
                                 WHERE customer_id = :user_id 
                                 AND product_id = :product_id');
                
                $this->db->bind(':total_amount', $data['totalAmount']);
            } else {
                // Insert new cart item
                $this->db->query('INSERT INTO cart (customer_id, product_id, category_id, quantity, totalAmount) 
                                 VALUES (:user_id, :product_id, :category_id, :quantity, :total_amount)');
                
                $this->db->bind(':category_id', $data['category_id']);
                $this->db->bind(':total_amount', $data['totalAmount']);
            }

            $this->db->bind(':user_id', $data['user_id']);
            $this->db->bind(':product_id', $data['product_id']);
            $this->db->bind(':quantity', $data['quantity']);

            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Error in addToCart: " . $e->getMessage());
            return false;
        }
    }

    public function getCartItems($userId) {
        $this->db->query('SELECT c.*, p.product_name, p.price, p.image, p.stock, cat.category_name 
                         FROM cart c 
                         JOIN supplier_products p ON c.product_id = p.product_id 
                         LEFT JOIN categories cat ON c.category_id = cat.category_id
                         WHERE c.customer_id = :user_id');
        $this->db->bind(':user_id', $userId);
        return $this->db->resultSet();
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

    public function getProductById($productId) {
        try {
            $this->db->query('SELECT p.*, c.category_name 
                             FROM supplier_products p 
                             LEFT JOIN categories c ON p.category_id = c.category_id 
                             WHERE p.product_id = :product_id');
            $this->db->bind(':product_id', $productId);
            $result = $this->db->single();
            
            if (!$result) {
                error_log("Product not found: " . $productId);
                return null;
            }
            
            return $result;
        } catch (Exception $e) {
            error_log("Error in getProductById: " . $e->getMessage());
            return null;
        }
    }

    public function getRelatedProducts($category_id, $current_product_id) {
        try {
            $this->db->query('SELECT p.*, c.category_name 
                             FROM supplier_products p
                             LEFT JOIN categories c ON p.category_id = c.category_id
                             WHERE p.category_id = :category_id 
                             AND p.product_id != :current_product_id
                             AND p.stock > 0
                             LIMIT 4');
            
            $this->db->bind(':category_id', $category_id);
            $this->db->bind(':current_product_id', $current_product_id);
            
            $result = $this->db->resultSet();
            return $result ? $result : [];
            
        } catch (Exception $e) {
            error_log("Error in getRelatedProducts: " . $e->getMessage());
            return [];
        }
    }
}