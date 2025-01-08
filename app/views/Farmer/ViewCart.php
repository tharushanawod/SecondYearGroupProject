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
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td><button class="remove-button">×</button></td>
                    <td>
                        <img src="<?php echo URLROOT;?>/images/images/img62.png" alt="Nitrogen rich fertilizer" class="product-image">                       
                    </td>
                    <td>Nitrogen Rich Fertilizer</td>
                    <td>LKR 1500.00</td>
                    <td>
                        <input class="quantity-input" type="number" value="1" min="1" class="quantity-input">
                    </td>
                    <td>LKR 1500.00</td>
                </tr>
            </tbody>
        </table>
    </div>
      
        <div class="cart-totals">
            <h2>Cart totals</h2><hr>
            <div class="totals-row">
                <span>Subtotal</span>
                <span>LKR 1500.00</span>
            </div><hr>
            <div class="totals-row">
                <span>Total</span>
                <span>LKR 1500.00</span>
            </div>
            <hr>
            <a href="<?php echo URLROOT;?>/FarmerController/Checkout"><button class="checkout-button">PROCEED TO CHECKOUT</button></a>
        </div>
    </div>
</body>
</html>