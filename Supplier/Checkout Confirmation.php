<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Ingredient Supplier/Checkout Confirmation.css">
    <title>Checkout Confirmation</title>
</head>
<body>
    <?php require 'shop header.php';?>
    
    <div class="container">
        <h1>Checkout</h1>
        <p>Thank you. Your order has been received.</p>
        
        <div class="order-info">
            <p><b>ORDER NUMBER:</b> 7890</p>
            <p><b>DATE:</b> November 11, 2024</p>
            <p><b>TOTAL:</b> LKR 1500.00</p>
            <p><b>PAYMENT METHOD:</b> Card Payments</p>
        </div>

        <h2>Order details</h2>
        <table>
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Nitrogen Rich Fertilizer × 1</td>
                    <td>LKR 1500.00</td>
                </tr>
                <tr>
                    <td>Subtotal:</td>
                    <td>LKR 1500.00</td>
                </tr>
                <tr>
                    <td>Payment method:</td>
                    <td>Card Payments</td>
                </tr>
                <tr>
                    <td>Total:</td>
                    <td>LKR 1500.00</td>
                </tr>
            </tbody>
        </table>

        <h2>Billing address</h2>
        <div class="billing-address">
            <p>anne carolina</p>
            <p>colombo 05</p>
            <p>colombo</p>
            <p>34567</p>
            <p>Sri Lanka</p>
            <p>0712345674</p>
            <p>anna@gmail.com</p>
        </div>
    </div>
</body>
</html>