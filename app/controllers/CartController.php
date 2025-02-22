<?php

class CartController extends Controller {
    private $cartModel;
    private $supplierModel;

    public function __construct() {
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }
        $this->cartModel = $this->model('Cart');
        $this->supplierModel = $this->model('Supplier');
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
        // Update cart count before loading the page
        $this->updateCartCount();
        
        try {
            $product = $this->cartModel->getProductById($productId);
            if ($product) {
                // Get related products by category
                $relatedProducts = $this->cartModel->getRelatedProducts($product->category_id, $productId);
                
                // Get supplier ratings
                $supplierRatings = $this->supplierModel->getSupplierRatings($product->supplier_id);
                $averageRating = $this->supplierModel->getAverageRating($product->supplier_id);

                $data = [
                    'product' => $product,
                    'relatedProducts' => $relatedProducts,
                    'reviews' => $supplierRatings,
                    'averageRating' => $averageRating,
                    'totalRatings' => count($supplierRatings)
                ];
                
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
            if (!$product) {
                throw new Exception('Product not found');
            }
            
            // Check if requested quantity is valid
            if ($quantity < 1 || $quantity > $product->stock) {
                throw new Exception('Invalid quantity or insufficient stock');
            }

            $cartData = [
                'user_id' => $_SESSION['user_id'],
                'product_id' => $product_id,
                'category_id' => $product->category_id,
                'quantity' => $quantity,
                'totalAmount' => $product->price * $quantity
            ];

            if ($this->cartModel->addToCart($cartData)) {
                // Update cart count after adding item
                $this->updateCartCount();
                
                $_SESSION['message'] = 'Item added to cart successfully';
                $_SESSION['message_type'] = 'success';
            } else {
                throw new Exception('Failed to add item to cart');
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
        
        // Update cart count after removing item
        $this->updateCartCount();
        
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
        if (isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'farmer') {
            $_SESSION['cart_count'] = $this->cartModel->getCartCount($_SESSION['user_id']);
        }
    }

       // Get profile image URL
       public function getProfileImage($user_id) {
        $imagePath = $this->cartModel->getProfileImage($_SESSION['user_id']);
        return $imagePath ? URLROOT .'/'.$imagePath : URLROOT . '/images/default.jpg';
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
    
    public function rateProduct() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $product_id = $_POST['product_id'];
            $rating = $_POST['rating'];
            $user_id = $_SESSION['user_id'];
            
            if ($this->cartModel->rateProduct($product_id, $user_id, $rating)) {
                $_SESSION['message'] = 'Product rated successfully';
                $_SESSION['message_type'] = 'success';
            } else {
                $_SESSION['message'] = 'Failed to rate product';
                $_SESSION['message_type'] = 'error';
            }
        }
        redirect("CartController/viewDetails/$product_id");
    }
}