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
                        <td colspan="7" class="empty-cart">Your cart is empty</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($data['cartItems'] as $item): ?>
                    <tr id="item_<?php echo htmlspecialchars($item->cart_item_id); ?>">
                        <td>
                            <form id="removeForm_<?php echo htmlspecialchars($item->cart_item_id); ?>" method="POST" action="<?php echo URLROOT; ?>/FarmerController/removeCartItem/<?php echo htmlspecialchars($item->cart_item_id); ?>">
                                <button type="submit" class="remove-button">×</button>
                            </form>
                        </td>
                        <td>
                            <img src="<?php echo URLROOT; ?>/uploads/<?php echo htmlspecialchars($item->image); ?>" alt="<?php echo htmlspecialchars($item->product_name); ?>" class="product-image">
                        </td>
                        <td><?php echo htmlspecialchars($item->product_name); ?></td>
                        <td><?php echo htmlspecialchars($item->category_name); ?></td>
                        <td>LKR <?php echo number_format($item->price, 2); ?></td>
                        <td>
                            <form id="updateForm_<?php echo htmlspecialchars($item->cart_item_id); ?>" method="POST" action="<?php echo URLROOT; ?>/FarmerController/updateCartItem">
                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($item->cart_item_id); ?>">
                                <input class="quantity-input" type="number" name="quantity" value="<?php echo htmlspecialchars($item->quantity); ?>" min="1" onchange="document.getElementById('updateForm_<?php echo htmlspecialchars($item->cart_item_id); ?>').submit();">
                            </form>
                        </td>
                        <td>LKR <span id="totalPrice_<?php echo htmlspecialchars($item->cart_item_id); ?>"><?php echo number_format($item->price * $item->quantity, 2); ?></span></td>
                    </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
      
        <div class="cart-totals">
            <h2>Cart totals</h2><hr>
            <div class="totals-row">
                <span>Subtotal</span>
                <span>LKR <span id="subTotal"><?php echo number_format($data['subTotal'], 2); ?></span></span>
            </div><hr>
            <div class="totals-row">
                <span>Total</span>
                <span>LKR <span id="finalPrice"><?php echo number_format($data['total'], 2); ?></span></span>
            </div>
            <hr>
            <a href="<?php echo URLROOT;?>/FarmerController/Checkout"><button class="checkout-button">PROCEED TO CHECKOUT</button></a>
        </div>
    </div>
</body>
</html>
