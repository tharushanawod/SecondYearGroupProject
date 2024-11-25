<?php 

class PaymentController extends Controller {
    private $Cart;
    private $Product;

    public function __construct() {
        $this->Product = $this->model('Cart');
    }

public function payment() {
        $data = [];
        $this->view('Ingredient Supplier/Payment', $data);
    }

    public function addToCart($productId) {
        // Assuming you have a Cart model to handle cart operations
        $product = $this->Product->getProductById($productId);
        $this->Cart->addProductToCart($product);
    
        // Redirect to the view cart page
        header('Location: ' . URLROOT . '/Ingredient Supplier/View cart');
        exit();
    }
    
    public function viewCart() {
        $cartItems = $this->Product->getCartItems();
        $cartTotal = $this->Cart->getCartTotal();
        $this->view('Ingredient Supplier/View cart', ['cartItems' => $cartItems]);
    }

    public function checkout() {
        $data = [];
        $this->view('Ingredient Supplier/Checkout', $data);
    }

    public function checkoutConfirmation() {
        $data = [];
        $this->view('Ingredient Supplier/Checkout Confirmation', $data);
    }
}