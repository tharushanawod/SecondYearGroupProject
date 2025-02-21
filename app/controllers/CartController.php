<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

class CartController extends Controller {
    private $cartModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }
        $this->cartModel = $this->model('Cart');
    }

    public function browseProducts($categoryId = null) {
        try {
            $products = $this->cartModel->getProducts($categoryId);
            $categories = $this->cartModel->getCategories();
            
            $data = [
                'products' => $products,
                'categories' => $categories
            ];

            $this->view('Cart/BuyIngredients', $data);
        } catch (Exception $e) {
            error_log("Error in browseProducts: " . $e->getMessage());
            redirect('pages/error');
        }
    }

    public function viewDetails($productId) {
        try {
            $product = $this->cartModel->getProductById($productId);
            if ($product) {
                // Get related products by category
                $relatedProducts = $this->cartModel->getRelatedProducts($product->category_id, $productId);
                
                $data = [
                    'product' => $product,
                    'relatedProducts' => $relatedProducts
                ];
                // Update view path to Cart folder
                $this->view('Cart/ViewDetails', $data);
            } else {
                redirect('CartController/browseProducts');
            }
        } catch (Exception $e) {
            error_log("Error in viewDetails: " . $e->getMessage());
            redirect('pages/error');
        }
    }

    public function addToCart() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST') {
            redirect('pages/error');
            return;
        }

        try {
            $product_id = $_POST['product_id'];
            $quantity = intval($_POST['quantity']);
            
            // Get product info to check stock and get category_id
            $product = $this->cartModel->getProductById($product_id);
            if (!$product || $quantity < 1 || $quantity > $product->stock) {
                throw new Exception('Invalid quantity or product not found');
            }

            $cartData = [
                'user_id' => $_SESSION['user_id'],
                'product_id' => $product_id,
                'category_id' => $product->category_id,
                'quantity' => $quantity,
                'totalAmount' => $product->price * $quantity
            ];

            if ($this->cartModel->addToCart($cartData)) {
                $_SESSION['cart_count'] = $this->cartModel->getCartCount($_SESSION['user_id']);
                $_SESSION['message'] = 'Item added to cart successfully';
                $_SESSION['message_type'] = 'success';
            }
        } catch (Exception $e) {
            $_SESSION['message'] = $e->getMessage();
            $_SESSION['message_type'] = 'error';
        }

        redirect("CartController/viewDetails/$product_id");
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
        try {
            $cartItems = $this->cartModel->getCartItems($_SESSION['user_id']);
            $subTotal = $this->cartModel->calculateSubTotal($cartItems);

            $data = [
                'cartItems' => $cartItems,
                'subTotal' => $subTotal,
                'title' => 'Shopping Cart'
            ];
            
            $this->view('Cart/ViewCart', $data);
        } catch (Exception $e) {
            error_log("Error in viewCart: " . $e->getMessage());
            redirect('pages/error');
        }
    }

    public function removeFromCart($cart_id) {
        if ($this->cartModel->removeCartItem($cart_id, $_SESSION['user_id'])) {
            $_SESSION['message'] = 'Item removed from cart successfully';
            $_SESSION['message_type'] = 'success';
            $_SESSION['cart_count'] = $this->cartModel->getCartCount($_SESSION['user_id']);
        }
        redirect('CartController/viewCart');
    }

    public function clearCart() {
        if ($this->cartModel->clearCart($_SESSION['user_id'])) {
            $_SESSION['message'] = 'Cart cleared successfully';
            $_SESSION['message_type'] = 'success';
            $_SESSION['cart_count'] = 0;
        }
        redirect('CartController/viewCart');
    }

    private function updateCartCount() {
        $_SESSION['cart_count'] = $this->cartModel->getCartCount($_SESSION['user_id']);
    }

    public function getProfileImage() {
        return isset($_SESSION['profile_image']) ? $_SESSION['profile_image'] : 'default.jpg';
    }

    public function checkout() {
        try {
            $cartItems = $this->cartModel->getCartItems($_SESSION['user_id']);
            $subTotal = $this->cartModel->calculateSubTotal($cartItems);
            
            $data = [
                'cart_items' => $cartItems,
                'subTotal' => $subTotal
            ];
            
            $this->view('Cart/Checkout', $data);
        } catch (Exception $e) {
            error_log("Error in checkout: " . $e->getMessage());
            redirect('pages/error');
        }
    }
    
    public function CheckoutConfirmation() {
        $data = [];
        $this->View('Cart/CheckoutConfirmation', $data);
    }
    public function pay(){
        $data = [];
        $this->View('Cart/Pay', $data);
    }
}