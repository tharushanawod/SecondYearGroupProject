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

    public function updateProductStock($product_id, $quantity) {
        try {
            $this->db->query('UPDATE supplier_products 
                             SET stock = stock - :quantity 
                             WHERE product_id = :product_id');
            $this->db->bind(':product_id', $product_id);
            $this->db->bind(':quantity', $quantity);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Error updating stock: " . $e->getMessage());
            throw $e;
        }
    }

    public function addToCart($data) {
        try {
            $this->db->beginTransaction();

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

            // Add to cart
            $cartResult = $this->db->execute();

            // Update product stock
            if ($cartResult) {
                $stockResult = $this->updateProductStock($data['product_id'], $data['quantity']);
                if ($stockResult) {
                    $this->db->commit();
                    return true;
                }
            }

            $this->db->rollBack();
            return false;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error in addToCart: " . $e->getMessage());
            return false;
        }
    }

    public function getCartItems($userId) {
        try {
            $this->db->query('SELECT c.*, p.product_name, p.price, p.image, p.stock, cat.category_name 
                             FROM cart c 
                             JOIN supplier_products p ON c.product_id = p.product_id 
                             LEFT JOIN categories cat ON c.category_id = cat.category_id
                             WHERE c.customer_id = :user_id');
            $this->db->bind(':user_id', $userId);
            return $this->db->resultSet();
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
            $this->db->query('UPDATE cart c
                             INNER JOIN supplier_products sp ON c.product_id = sp.product_id
                             SET c.quantity = :quantity,
                                 c.totalAmount = sp.price * :quantity 
                             WHERE c.cart_id = :cart_id');
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
            $this->db->beginTransaction();

            // Get cart item details before removal
            $cartItem = $this->getCartItemDetails($cart_id);
            
            if (!$cartItem) {
                throw new Exception("Cart item not found");
            }

            // Remove item from cart
            $this->db->query('DELETE FROM cart 
                             WHERE cart_id = :cart_id 
                             AND customer_id = :user_id');
            $this->db->bind(':cart_id', $cart_id);
            $this->db->bind(':user_id', $user_id);
            
            if ($this->db->execute()) {
                // Restore product stock
                if ($this->restoreProductStock($cartItem->product_id, $cartItem->quantity)) {
                    $this->db->commit();
                    return true;
                }
            }

            $this->db->rollBack();
            return false;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error in removeCartItem: " . $e->getMessage());
            return false;
        }
    }

    public function clearCart($user_id) {
        try {
            $this->db->beginTransaction();

            // Get all cart items before clearing
            $this->db->query('SELECT product_id, quantity FROM cart WHERE customer_id = :user_id');
            $this->db->bind(':user_id', $user_id);
            $cartItems = $this->db->resultSet();

            // Clear the cart
            $this->db->query('DELETE FROM cart WHERE customer_id = :user_id');
            $this->db->bind(':user_id', $user_id);
            
            if ($this->db->execute()) {
                // Restore stock for each item
                foreach ($cartItems as $item) {
                    if (!$this->restoreProductStock($item->product_id, $item->quantity)) {
                        throw new Exception("Failed to restore stock for product " . $item->product_id);
                    }
                }
                
                $this->db->commit();
                return true;
            }

            $this->db->rollBack();
            return false;

        } catch (Exception $e) {
            $this->db->rollBack();
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

    public function addRating($data) {
        try {
            $this->db->query('INSERT INTO product_ratings (product_id, customer_id, rating, review) 
                             VALUES (:product_id, :customer_id, :rating, :review)');
            $this->db->bind(':product_id', $data['product_id']);
            $this->db->bind(':customer_id', $data['customer_id']);
            $this->db->bind(':rating', $data['rating']);
            $this->db->bind(':review', $data['review']);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Error in addRating: " . $e->getMessage());
            return false;
        }
    }

    public function getCartItemDetails($cart_id) {
        try {
            $this->db->query('SELECT product_id, quantity FROM cart WHERE cart_id = :cart_id');
            $this->db->bind(':cart_id', $cart_id);
            return $this->db->single();
        } catch (Exception $e) {
            error_log("Error in getCartItemDetails: " . $e->getMessage());
            return null;
        }
    }

    public function restoreProductStock($product_id, $quantity) {
        try {
            $this->db->query('UPDATE supplier_products 
                             SET stock = stock + :quantity 
                             WHERE product_id = :product_id');
            $this->db->bind(':product_id', $product_id);
            $this->db->bind(':quantity', $quantity);
            return $this->db->execute();
        } catch (Exception $e) {
            error_log("Error restoring stock: " . $e->getMessage());
            throw $e;
        }
    }
}
?>