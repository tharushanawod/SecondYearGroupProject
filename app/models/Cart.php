<?php
class Cart {
    private $db;

    public function __construct() {
        $this->db = new Database;
    }

    public function getProfileImage($userId) {
        $this->db->query("SELECT file_path FROM profile_pictures WHERE user_id = :userId");
        $this->db->bind(':userId', $userId);
        $row = $this->db->single();

        if($row){
            return $row->file_path;
        } else {
            return false;
        }
       
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

    public function getCartCount($farmer_id) {
        try {
            $this->db->query('SELECT COUNT(*) as count FROM cart WHERE customer_id = :farmer_id');
            $this->db->bind(':farmer_id', $farmer_id);
            $result = $this->db->single();
            return $result->count;
        } catch (Exception $e) {
            error_log("Error getting cart count: " . $e->getMessage());
            return 0;
        }
    }

    public function updateQuantity($cart_id, $quantity) {
        try {
            $this->db->beginTransaction();

            // Get current cart item details
            $this->db->query('SELECT c.quantity as old_quantity, c.product_id, sp.price, sp.stock 
                            FROM cart c
                            INNER JOIN supplier_products sp ON c.product_id = sp.product_id
                            WHERE c.cart_id = :cart_id');
            $this->db->bind(':cart_id', $cart_id);
            $currentItem = $this->db->single();

            if (!$currentItem) {
                throw new Exception("Cart item not found");
            }

            // Calculate quantity difference
            $quantityDifference = $quantity - $currentItem->old_quantity;

            // Check if new quantity is valid
            if ($currentItem->stock + ($currentItem->old_quantity - $quantity) < 0) {
                throw new Exception("Insufficient stock");
            }

            // Update cart quantity and total amount
            $this->db->query('UPDATE cart 
                            SET quantity = :quantity,
                                totalAmount = :price * :quantity 
                            WHERE cart_id = :cart_id');
            $this->db->bind(':cart_id', $cart_id);
            $this->db->bind(':quantity', $quantity);
            $this->db->bind(':price', $currentItem->price);
            
            if (!$this->db->execute()) {
                throw new Exception("Failed to update cart");
            }

            // Update product stock
            $this->db->query('UPDATE supplier_products 
                            SET stock = stock - :quantity_difference 
                            WHERE product_id = :product_id');
            $this->db->bind(':product_id', $currentItem->product_id);
            $this->db->bind(':quantity_difference', $quantityDifference);
            
            if (!$this->db->execute()) {
                throw new Exception("Failed to update stock");
            }

            $this->db->commit();
            return true;

        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Error in updateQuantity: " . $e->getMessage());
            throw $e;
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
            $this->db->query('SELECT p.*, c.category_name, u.name as supplier_name
                             FROM supplier_products p 
                             LEFT JOIN categories c ON p.category_id = c.category_id 
                             LEFT JOIN users u ON p.supplier_id = u.user_id
                             WHERE p.product_id = :product_id');
            
            $this->db->bind(':product_id', $productId);
            return $this->db->single();
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

    public function createOrder($orderData, $cartItems) {
        try {
            $this->db->beginTransaction();
    
            // 1. Insert main order
            $this->db->query('INSERT INTO orders (user_id, first_name, last_name, address, city, postcode, phone, total_amount, order_date, status) 
                              VALUES (:user_id, :first_name, :last_name, :address, :city, :postcode, :phone, :total_amount, NOW(), "pending")');
    
            $this->db->bind(':user_id', $orderData['user_id']);
            $this->db->bind(':first_name', $orderData['first_name']);
            $this->db->bind(':last_name', $orderData['last_name']);
            $this->db->bind(':address', $orderData['address']);
            $this->db->bind(':city', $orderData['city']);
            $this->db->bind(':postcode', $orderData['postcode']);
            $this->db->bind(':phone', $orderData['phone']);
            $this->db->bind(':total_amount', $orderData['total_amount']);
    
            if (!$this->db->execute()) {
                $this->db->rollBack();
                return false;
            }
    
            $order_id = $this->db->lastInsertId();

             // 2. Insert each item
             foreach ($cartItems as $item) {
                $this->db->query('INSERT INTO order_items (order_id, product_id, quantity, price) 
                                  VALUES (:order_id, :product_id, :quantity, :price)');
                $this->db->bind(':order_id', $order_id);
                $this->db->bind(':product_id', $item->product_id);
                $this->db->bind(':quantity', $item->quantity);
                $this->db->bind(':price', $item->price);
    
                if (!$this->db->execute()) {
                    $this->db->rollBack();
                    return false;
                }
            }

    
            // 3. Clear cart
            if (!$this->clearCartAfterOrder($orderData['user_id'])) {
                $this->db->rollBack();
                return false;
            }
    
            // 4. Commit all
            $this->db->commit();
            return $order_id;
    
        } catch (Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    public function clearCartAfterOrder($user_id) {
        $this->db->query("DELETE FROM cart WHERE customer_id = :user_id");
        $this->db->bind(':user_id', $user_id);
        return $this->db->execute();
    }

    public function getOrderDetails($order_id) {
        $this->db->query('SELECT * FROM orders WHERE order_id = :order_id');
        $this->db->bind(':order_id', $order_id);
        return $this->db->single();
    }

    public function getProductDetails($order_id){
        $this->db->query('SELECT order_items.*,supplier_products.product_name
        FROM order_items 
        LEFT JOIN supplier_products ON order_items.product_id = supplier_products.product_id
        WHERE order_id = :order_id');
        $this->db->bind(':order_id', $order_id);
        return $this->db->resultSet();
    }
    
    
}
?>