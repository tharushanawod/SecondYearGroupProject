<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/ViewCart.css">
    <script src="<?php echo URLROOT; ?>/js/Farmer/Cart.js" defer></script>
</head>
<body>
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>
    
    <div class="container">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message-div <?php echo $_SESSION['message_type']; ?>">
                <?php echo $_SESSION['message']; unset($_SESSION['message'], $_SESSION['message_type']); ?>
            </div>
        <?php endif; ?>

        <h1>Shopping Cart</h1>
        <div class="cart">
            <table class="cart-table">
                <thead>
                    <tr>
                        <th>Action</th>
                        <th>Image</th>
                        <th>Product</th>
                        <th>Category</th>  
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Total</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($data['cartItems'])): ?>
                        <tr>
                            <td colspan="7" class="empty-cart">
                                <div class="empty-cart-message">
                                    <i class="fas fa-shopping-cart"></i>
                                    <p>Your cart is empty</p>
                                    <a href="<?php echo URLROOT; ?>/FarmerController/BuyIngredients" class="continue-shopping">Continue Shopping</a>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($data['cartItems'] as $item): ?>
                            <tr id="cart-item-<?php echo $item->cart_id; ?>">
                                <td>
                                    <button onclick="removeCartItem(<?php echo $item->cart_id; ?>)" class="remove-item">
                                        <i class="fas fa-times"></i>
                                    </button>
                                </td>
                                <td>
                                    <img src="<?php echo URLROOT; ?>/uploads/<?php echo htmlspecialchars($item->image); ?>" 
                                         alt="<?php echo htmlspecialchars($item->product_name); ?>" 
                                         class="product-image">
                                </td>
                                <td>
                                    <a href="<?php echo URLROOT; ?>/FarmerController/viewDetails/<?php echo $item->product_id; ?>">
                                        <?php echo htmlspecialchars($item->product_name); ?>
                                    </a>
                                </td>
                                <td><?php echo htmlspecialchars($item->category_name); ?></td>
                                <td class="price">Rs. <?php echo number_format($item->price, 2); ?></td>
                                <td class="quantity">
                                    <input type="number" 
                                           value="<?php echo $item->quantity; ?>" 
                                           min="1" 
                                           max="<?php echo $item->stock; ?>"
                                           class="quantity-input"
                                           data-cart-id="<?php echo $item->cart_id; ?>"
                                           onchange="updateCartQuantity(this)">
                                </td>
                                <td class="total">Rs. <?php echo number_format($item->totalAmount, 2); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
            
            <?php if(!empty($data['cartItems'])): ?>
                <div class="cart-summary">
                    <h2>Cart Summary</h2>
                    <div class="summary-content">
                        <div class="summary-row">
                            <span>Subtotal:</span>
                            <span>Rs. <?php echo number_format($data['subTotal'], 2); ?></span>
                        </div>
                        <div class="cart-actions">
                            <a href="<?php echo URLROOT; ?>/FarmerController/BuyIngredients" class="continue-shopping">
                                Continue Shopping
                            </a>
                            <button onclick="clearCart()" class="clear-cart-btn">
                                Clear Cart
                            </button>
                            <a href="<?php echo URLROOT; ?>/CheckoutController" class="checkout-btn">
                                Proceed to Checkout
                            </a>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

</body>
</html>