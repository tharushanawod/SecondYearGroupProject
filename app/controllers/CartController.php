<?php
class CartController extends Controller {
    protected $productModel;
    protected $cartModel;

    public function __construct() {
        $this->productModel = $this->model('Product');
        $this->cartModel = $this->model('Cart');
    }

    public function addToCart() {
        if (!isset($_SESSION['user_id'])) {
            echo json_encode(['success' => false, 'message' => 'Please login first']);
            return;
        }

        try {
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Get input data
                $contentType = isset($_SERVER["CONTENT_TYPE"]) ? trim($_SERVER["CONTENT_TYPE"]) : '';
                
                if ($contentType === "application/json") {
                    $input = json_decode(file_get_contents('php://input'), true);
                    if (!$input) {
                        throw new Exception("Invalid JSON data");
                    }
                    $product_id = $input['product_id'];
                    $quantity = intval($input['quantity']);
                } else {
                    $product_id = $_POST['product_id'];
                    $quantity = intval($_POST['quantity']);
                }

                // Validate input
                if (!$product_id || $quantity < 1) {
                    throw new Exception("Invalid product or quantity");
                }

                $cartData = [
                    'user_id' => $_SESSION['user_id'],
                    'product_id' => $product_id,
                    'quantity' => $quantity
                ];

                if ($this->cartModel->addToCart($cartData)) {
                    // Update session cart count
                    if (!isset($_SESSION['cart'])) {
                        $_SESSION['cart'] = [];
                    }
                    $_SESSION['cart'][$product_id] = ($_SESSION['cart'][$product_id] ?? 0) + $quantity;
                    $_SESSION['cart_count'] = array_sum($_SESSION['cart']);

                    echo json_encode([
                        'success' => true,
                        'message' => 'Product added to cart successfully',
                        'cartCount' => $_SESSION['cart_count']
                    ]);
                }
            }
        } catch (Exception $e) {
            error_log("Cart Error: " . $e->getMessage());
            echo json_encode([
                'success' => false,
                'message' => $e->getMessage()
            ]);
        }
    }

    public function viewCart() {
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
            return;
        }

        try {
            $cartItems = $this->cartModel->getCartItems($_SESSION['user_id']);
            $subTotal = $this->cartModel->calculateSubTotal($cartItems);
            $total = $subTotal; // Add tax or shipping if needed
            
            $data = [
                'cartItems' => $cartItems,
                'subTotal' => $subTotal,
                'total' => $total
            ];
            
            $this->view('Farmer/ViewCart', $data);
        } catch (Exception $e) {
            error_log("Error in viewCart: " . $e->getMessage());
            $_SESSION['message'] = 'Error loading cart';
            $_SESSION['message_type'] = 'error';
            $this->view('Farmer/ViewCart', [
                'cartItems' => [],
                'subTotal' => 0,
                'total' => 0
            ]);
        }
    }

    public function removeFromCart($product_id) {
        if (!isset($_SESSION['user_id'])) {
            redirect('users/login');
        }

        if ($this->cartModel->removeCartItem($product_id, $_SESSION['user_id'])) {
            if (isset($_SESSION['cart'][$product_id])) {
                unset($_SESSION['cart'][$product_id]);
                $_SESSION['cart_count'] = array_sum($_SESSION['cart']);
            }
            $_SESSION['message'] = 'Item removed from cart successfully!';
            $_SESSION['message_type'] = 'success';
        } else {
            $_SESSION['message'] = 'Failed to remove item from cart!';
            $_SESSION['message_type'] = 'error';
        }

        redirect('CartController/viewCart');
    }

    public function clearCart() {
        unset($_SESSION['cart']);
        unset($_SESSION['cart_count']);
        $_SESSION['message'] = 'Cart cleared successfully!';
        $_SESSION['message_type'] = 'success';

        header('Location: ' . URLROOT . '/CartController/viewCart');
        exit();
    }

    public function viewDetails($id) {
        $product = $this->productModel->getProductById($id);
        $relatedProducts = $this->productModel->getRelatedProducts($product->category_id);
    
        $data = [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ];
    
        $this->view('Farmer/ViewDetails', $data);
    }
}