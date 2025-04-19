<?php

class CartController extends Controller {
    private $cartModel;
    private $supplierModel;


    public function __construct() {
        // Get the current method from the URL
        $currentMethod = $this->getCurrentMethodFromURL();
    
        // Bypass authentication if the current method is 'Notify'
        if ($currentMethod !== 'paymentNotify') {
            // Check if user is logged in
            if (!$this->isloggedin()) {
                unset($_SESSION['user_id']);
                unset($_SESSION['user_email']);
                unset($_SESSION['user_name']);
                session_destroy();
                Redirect('LandingController/login');
            } else {

                  // Load models
        $this->cartModel = $this->model('Cart');
        $this->supplierModel = $this->model('Supplier');

                // // User is logged in, now check if they are restricted
                // $user_id = $_SESSION['user_id'];
                // $user = $this->BuyerModel->getUserStatus($user_id);  // Fetch user status from the database
    
                // // If the user is restricted, prevent access to any page except "Manage Profile"
                // if ($user->user_status === 'restricted') {
                //     if ($currentMethod !== 'ManageProfile' && $currentMethod !== 'Resetricted') {
                //         Redirect('BuyerController/Resetricted/' . $user_id);
                //     }
                // }
                
            }
        }
    
      
    }

    private function getCurrentMethodFromURL() {
        // Parse the URL
        if (isset($_GET['url'])) {
            $url = rtrim($_GET['url'], '/');
            $url = filter_var($url, FILTER_SANITIZE_URL);
            $url = explode('/', $url);

            // The second segment of the URL is the method name
            return $url[1] ?? null;
        }
        return null;
    }
 

    public function isloggedin() {
        if (isset($_SESSION['user_id']) && ($_SESSION['user_role'] == 'farmer')) {
            return true;
        } else {
            return false;
        }
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
            // Update cart count before loading the page
            $this->updateCartCount();
            
            $product = $this->cartModel->getProductById($productId);
            if (!$product) {
                throw new Exception('Product not found');
            }

            // Get related products by category
            $relatedProducts = $this->cartModel->getRelatedProducts($product->category_id, $productId);
            
            // Get supplier ratings
            $ratingData = $this->supplierModel->getAverageRating($product->supplier_id);
            $supplierRatings = $this->supplierModel->getSupplierRatings($product->supplier_id);

            $data = [
                'product' => $product,
                'relatedProducts' => $relatedProducts,
                'reviews' => $supplierRatings,
                'averageRating' => $ratingData->avg_rating ?? 0,
                'totalRatings' => $ratingData->total_ratings ?? 0
            ];
            
            $this->view('Cart/ViewDetails', $data);
            
        } catch (Exception $e) {
            error_log("Error in viewDetails: " . $e->getMessage());
            $_SESSION['message'] = 'Error loading product details';
            $_SESSION['message_type'] = 'error';
            redirect('CartController/browseProducts');
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
            try {
                $cart_id = $_POST['cart_id'];
                $quantity = intval($_POST['quantity']);

                if ($quantity < 1) {
                    throw new Exception('Invalid quantity');
                }

                $this->cartModel->updateQuantity($cart_id, $quantity);
                $_SESSION['message'] = 'Cart updated successfully';
                $_SESSION['message_type'] = 'success';

            } catch (Exception $e) {
                $_SESSION['message'] = $e->getMessage();
                $_SESSION['message_type'] = 'error';
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
    public function pay($order_id){

        $order_details = $this->cartModel->getOrderDetails($order_id);
        $product_details = $this->cartModel->getProductDetails($order_id);
     $data =[
        'order_details' => $order_details,
        'cart_items' => $product_details
     ];
      
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

    public function submitReview() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user_id'])) {
            redirect('pages/error');
        }

        $data = [
            'supplier_id' => trim($_POST['supplier_id']),
            'farmer_id' => $_SESSION['user_id'],
            'rating' => trim($_POST['rating']),
            'review_text' => trim($_POST['review_text'])
        ];

        if ($this->supplierModel->addRating($data)) {
            $_SESSION['message'] = 'Thank you for your review!';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Unable to submit review';
            $_SESSION['message_type'] = 'error';
        }

        // Redirect back to the product page
        redirect('CartController/viewDetails/' . $data['supplier_id']);
    }

    public function placeOrder() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            redirect('pages/error');
        }
    
            $user_id = $_SESSION['user_id'];
    
            // Get cart items
            $cartItems = $this->cartModel->getCartItems($user_id);
            if (empty($cartItems)) {
                throw new Exception('Your cart is empty');
            }
    
            // Prepare order data
            $orderData = [
                'user_id' => $user_id,
                'first_name' => trim($_POST['first-name']),
                'last_name' => trim($_POST['last-name']),
                'address' => trim($_POST['address']),
                'city' => trim($_POST['city']),
                'postcode' => trim($_POST['postcode']),
                'phone' => trim($_POST['phone']),
                'total_amount' => $this->cartModel->calculateSubTotal($cartItems)
            ];
           

           
    
            // Create order with items
            $order_id = $this->cartModel->createOrder($orderData, $cartItems);
            if (!$order_id) {
                throw new Exception('Failed to create order');
            }
    
            // Update cart count
            $this->updateCartCount();
    
            Redirect('CartController/Pay/' . $order_id);

    
        
    }

    public function paymentNotify() {
        $this->cartModel = $this->model('Cart');
        
                    $hash = $_POST['md5sig'];
                    $order_id = $_POST['order_id'];
                    $amount = $_POST['payhere_amount'];
                    $payment_id = $_POST['payment_id'];
                    $status_code = $_POST['status_code'];
                    $currency = $_POST['payhere_currency'];


                    // Your merchant secret key
                    $merchant_secret = $_ENV['MERCHANT_SECRET'];

                    // Verify the received hash
                    $generated_hash = strtoupper(md5(
                        $_POST['merchant_id'] .
                        $_POST['order_id'] .
                        $_POST['payhere_amount'] .
                        $_POST['payhere_currency'] .
                        $_POST['status_code'] .
                        strtoupper(md5($merchant_secret))
                    ));
                    if ($hash === $generated_hash) {
                      error_log("tharusha".var_export($_POST, true));
                        // Hash matches, it's a valid notification
                        if ($status_code == 2) {
                            // Payment successful
                            // Update your database, notify the user, etc.
                            $payment_status = 'paid';
                      
                           


                            $this->cartModel->updatePaymentStatus($order_id, $payment_status);
                            $this->cartModel->TransactionComplete($order_id, $amount,$payment_id);
                            $this->cartModel->UpdateInventory($order_id);
                            

                        } else {
                            // Payment failed
                            $payment_status = 'failed';
                            $this->cartModel->updatePaymentStatus($order_id, $payment_status);
                        }
                    } else {
                        // Invalid hash
                        echo "Invalid payment notification.";
                    }
    }

    public function paymentSuccess() {
        // Check if 'order_id' and 'amount' are set in the URL (GET request)
        if (isset($_GET['order_id']) && isset($_GET['amount'])) {
            // Sanitize the input to prevent malicious data
            $order_id = htmlspecialchars($_GET['order_id']);
            $amount = htmlspecialchars($_GET['amount']);
            
            // Prepare the data to pass to the view
            $data = [
                'order_id' => $order_id,
                'amount' => $amount
            ];
    
            // Pass the data to the view
            $this->View('Cart/PaymentSuccess', $data);
        } else {
            // Handle the case where 'order_id' or 'amount' are not present
            // You can show an error message or redirect to another page
            echo "Invalid payment data.";
        }
    }
    

    public function Cancel() {
        echo "Payment was cancelled!";
    }
    
}