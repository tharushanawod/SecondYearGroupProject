<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Cart/ViewCart.css">
</head>
<body>
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>
    
    <div class="container">
        <?php if (isset($_SESSION['message'])): ?>
            <div class="message-div <?php echo $_SESSION['message_type']; ?>">
                <?php echo $_SESSION['message']; unset($_SESSION['message'], $_SESSION['message_type']); ?>
            </div>
        <?php endif; ?>

        <h1>Cart</h1>
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
                                    <a href="<?php echo URLROOT; ?>/CartController/browseProducts" 
                                       class="continue-shopping-btn">Continue Shopping</a>
                                </div>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($data['cartItems'] as $item): ?>
                            <tr>
                                <td>
                                    <form action="<?php echo URLROOT; ?>/CartController/removeFromCart/<?php echo $item->cart_id; ?>" 
                                          method="POST">
                                        <button type="submit" class="remove-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                                <td class="product-img">
                                    <img src="<?php echo URLROOT; ?>/uploads/<?php echo htmlspecialchars($item->image); ?>" 
                                         alt="<?php echo htmlspecialchars($item->product_name); ?>">
                                </td>
                                <td class="product-name">
                                    <?php echo htmlspecialchars($item->product_name); ?>
                                </td>
                                <td class="category">
                                    <?php echo isset($item->category_name) ? htmlspecialchars($item->category_name) : 'No Category'; ?>
                                </td>
                                <td class="price">
                                    Rs. <?php echo number_format($item->price, 2); ?>
                                </td>
                                <td class="quantity">
                                    <form action="<?php echo URLROOT; ?>/CartController/updateQuantity" 
                                          method="POST" class="quantity-form">
                                        <input type="hidden" name="cart_id" value="<?php echo $item->cart_id; ?>">
                                        <input type="number" 
                                               name="quantity" 
                                               value="<?php echo $item->quantity; ?>" 
                                               min="1" 
                                               max="<?php echo $item->stock; ?>"
                                               onchange="this.form.submit()"
                                               class="quantity-input">
                                    </form>
                                </td>
                                <td class="total">
                                    Rs. <?php echo number_format($item->totalAmount, 2); ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>

            <?php if(!empty($data['cartItems'])): ?>

                <div class="cart-navigation">
                    <a href="<?php echo URLROOT; ?>/CartController/browseProducts" 
                        class="continue-shopping-btn">Continue Shopping</a>
                    <form action="<?php echo URLROOT; ?>/CartController/clearCart" 
                            method="POST" style="display: inline;">
                        <button type="submit" class="clear-cart-btn">Clear Cart</button>
                    </form>
                </div>
                <div class="cart-summary">
                    <h2>Cart Totals</h2>
                    <hr>
                    <div class="summary-content">
                        <div class="subtotal">
                            <span>Subtotal:</span>
                            <span>Rs. <?php echo number_format($data['subTotal'], 2); ?></span>
                    </div>
                    <hr>
                    <div class="cart-actions">
                        
                        <a href="<?php echo URLROOT; ?>/CartController/Checkout" 
                            class="checkout-btn">Proceed to Checkout</a>
                    </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
