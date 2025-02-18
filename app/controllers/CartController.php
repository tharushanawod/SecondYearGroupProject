<?php

class CartController extends Controller {
    private $cartModel;
    private $productModel;

    
    public function __construct() {            
        $this->cartModel = $this->model('Cart');
        $this->productModel = $this->model('Product');
    }

    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('pages/error');
            return;
        }

        try {
            if (!isset($_SESSION['user_id'])) {
                throw new Exception('User not logged in');
            }

            $product_id = $_POST['product_id'];
            $quantity = intval($_POST['quantity']);
            $max_stock = intval($_POST['max_stock']);

            // Server-side validation
            if ($quantity < 1) {
                throw new Exception('Quantity must be at least 1');
            }
            
            if ($quantity > $max_stock) {
                throw new Exception('Quantity cannot exceed available stock');
            }

            $cartData = [
                'user_id' => $_SESSION['user_id'],
                'product_id' => $product_id,
                'quantity' => $quantity
            ];

            if ($this->cartModel->addToCart($cartData)) {
                $_SESSION['message'] = 'Item added to cart successfully';
                $_SESSION['message_type'] = 'success';
                $_SESSION['cart_count'] = $this->cartModel->getCartCount($_SESSION['user_id']);
            } else {
                throw new Exception('Failed to add item to cart');
            }

        } catch (Exception $e) {
            $_SESSION['message'] = $e->getMessage();
            $_SESSION['message_type'] = 'error';
            error_log("Cart Error: " . $e->getMessage());
        }

        redirect("FarmerController/viewDetails/$product_id");
    }

    public function updateQuantity() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $cart_id = $_POST['cart_id'];
            $quantity = $_POST['quantity'];
            
            if ($this->cartModel->updateQuantity($cart_id, $quantity)) {
                $_SESSION['message'] = 'Cart updated successfully';
                $_SESSION['message_type'] = 'success';
            }
        }
        redirect('CartController/viewCart');
    }

    public function viewCart() {
        // Basic authentication check
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
            return;
        }

        try {
            // Get cart items with error logging
            error_log("Fetching cart items for user: " . $_SESSION['user_id']);
            
            $cartItems = $this->cartModel->getCartItems($_SESSION['user_id']);
            error_log("Cart items retrieved: " . json_encode($cartItems));
            
            $subTotal = $this->cartModel->calculateSubTotal($cartItems);
            error_log("Subtotal calculated: " . $subTotal);

            $data = [
                'cartItems' => $cartItems,
                'subTotal' => $subTotal,
                'title' => 'Shopping Cart'
            ];

            // Debug view path
            error_log("Attempting to load view: " . APPROOT . '/views/Farmer/ViewCart.php');
            
            $this->view('Farmer/ViewCart', $data);
            
        } catch (Exception $e) {
            error_log("Error in viewCart: " . $e->getMessage());
            $_SESSION['message'] = 'Error loading cart';
            $_SESSION['message_type'] = 'error';
            redirect('FarmerController/BuyIngredients');
        }
    }

    public function removeFromCart($cart_id) {
        if ($this->cartModel->removeCartItem($cart_id, $_SESSION['user_id'])) {
            $_SESSION['message'] = 'Item removed from cart successfully';
            $_SESSION['message_type'] = 'success';
            $_SESSION['cart_count'] = $this->cartModel->getCartCount($_SESSION['user_id']);
        }
        redirect('FarmerController/viewCart');
    }

    public function clearCart() {
        if ($this->cartModel->clearCart($_SESSION['user_id'])) {
            $_SESSION['message'] = 'Cart cleared successfully';
            $_SESSION['message_type'] = 'success';
            $_SESSION['cart_count'] = 0;
        }
        redirect('FarmerController/viewCart');
    }

    private function updateCartCount() {
        $_SESSION['cart_count'] = $this->cartModel->getCartCount($_SESSION['user_id']);
    }
}