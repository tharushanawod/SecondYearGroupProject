<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/ViewCart.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
    <title>Cart</title>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
    
    <div class="container">
        <h1>Cart</h1>
        <div class="cart">
        <table class="cart-table">
            <thead>
                <tr>
                    <th></th>
                    <th></th>
                    <th>Product</th>
                    <th>Category</th>  
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
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
                    <tr id="cart_item_<?php echo htmlspecialchars($item->cart_item_id); ?>">
                        <td>
                            <a href="<?php echo URLROOT; ?>/CartController/removeFromCart/<?php echo $item->product_id; ?>" 
                               class="remove-item" 
                               onclick="return confirm('Are you sure you want to remove this item?');">
                                <i class="fas fa-times"></i>
                            </a>
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
                        <td class="price">LKR <?php echo number_format($item->price, 2); ?></td>
                        <td class="quantity">
                            <input type="number" 
                                   value="<?php echo $item->quantity; ?>" 
                                   min="1" 
                                   class="quantity-input"
                                   data-item-id="<?php echo $item->cart_item_id; ?>"
                                   onchange="updateQuantity(this)">
                        </td>
                        <td class="subtotal">LKR <?php echo number_format($item->totalAmount, 2); ?></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        
        <?php if(!empty($data['cartItems'])): ?>
        <div class="cart-totals">
            <h2>Cart Summary</h2>
            <div class="totals-content">
                <div class="totals-row">
                    <span>Subtotal:</span>
                    <span>LKR <?php echo number_format($data['subTotal'], 2); ?></span>
                </div>
                <div class="totals-row total">
                    <span>Total:</span>
                    <span>LKR <?php echo number_format($data['total'], 2); ?></span>
                </div>
                <div class="cart-actions">
                    <a href="<?php echo URLROOT; ?>/FarmerController/BuyIngredients" class="continue-shopping">
                        Continue Shopping
                    </a>
                    <a href="<?php echo URLROOT; ?>/FarmerController/Checkout" class="checkout-button">
                        Proceed to Checkout
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>
</body>
</html>