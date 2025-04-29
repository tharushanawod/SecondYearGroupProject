<?php
$merchant_id = $_ENV['MERCHANT_ID'];
$merchant_secret = $_ENV['MERCHANT_SECRET'];
$order_id = $data['order_details']->order_id; // Dynamic order ID
$price = number_format((float)$data['order_details']->total_amount, 2, '.', ''); // Only format once
$seller_count = $data['order_details']->seller_count; // Number of sellers
$amount = $price + 350.00 *$seller_count; // Amount to be paid

$currency = "LKR"; // Or USD
// Generate hash
$hash = strtoupper(md5(
    $merchant_id . 
    $order_id . 
    number_format($amount, 2, '.', '') . 
    $currency .  
    strtoupper(md5($merchant_secret)) 
));


//logging the hash and all varibles  for debugging
error_log("testing".var_export($merchant_id, true));
error_log("testing".var_export($order_id, true));
error_log("testing".var_export($amount, true));
error_log("testing".var_export($currency, true));
error_log("testing".var_export($merchant_secret, true));
error_log("testing".var_export($hash, true));

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Summary</title>
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/Cart/Pay.css">
</head>

<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="payment-container">
        <div class="payment-header">
            <h1>Payment Summary</h1>
            <p>Review your order before proceeding to payment</p>
        </div>

        <div class="payment-card">
            <div class="product-list">
                <?php if (!empty($data['cart_items'])): ?>
                <?php foreach ($data['cart_items'] as $item): ?>
                <div class="product-item">
                    <div class="product-details">
                        <h3 class="product-name">
                            <?php echo htmlspecialchars($item->product_name); ?>
                        </h3>
                        <p class="product-quantity">Quantity:
                            <?php echo $item->quantity; ?>
                        </p>
                    </div>
                    <p class="product-price">LKR
                        <?php echo number_format($item->price, 2); ?>
                    </p>
                </div>
                <?php endforeach; ?>
                <?php else: ?>
                <p>Your cart is empty</p>
                <?php endif; ?>
            </div>

            <div class="summary-section">
                <div class="summary-row">
                    <span>Subtotal</span>
                    <span>LKR
                        <?php echo number_format($data['order_details']->total_amount, 2); ?>
                    </span>
                </div>
                <div class="summary-row">
                    <span>Delivery Fee</span>
                    <span>350 x <?php echo $seller_count ?>(Seller Count) = <?php echo 350.00*$seller_count ?></span>
                </div>
                <div class="summary-row">
                    <span>Total</span>
                    <span>LKR
                        <?php echo $amount; ?>
                    </span>
                </div>
            </div>
           

            <form action="https://sandbox.payhere.lk/pay/checkout" method="POST">
                <input type="hidden" name="merchant_id" value="<?php echo $_ENV['MERCHANT_ID']; ?>">
                <input type="hidden" name="return_url" value="<?php echo URLROOT; ?>/CartController/paymentSuccess?amount=<?php echo $amount; ?>">
                <input type="hidden" name="cancel_url" value="<?php echo URLROOT; ?>/CartController/paymentCancel">
                <input type="hidden" name="notify_url" value=https://6afc-192-248-16-125.ngrok-free.app/GroupProject/CartController/paymentNotifylaterPayment">
                <input type="hidden" name="order_id" value="<?php echo $data['order_details']->order_id; ?>">
                <input type="hidden" name="items" value="Order_Items">
                <input type="hidden" name="currency" value="LKR">
                <input type="hidden" name="amount" value="<?php echo $amount; ?>">
                <input type="hidden" name="first_name" value="<?php echo $data['order_details']->first_name; ?>">
                <input type="hidden" name="last_name" value="<?php echo $data['order_details']->last_name; ?>">
                <input  type="hidden" name="email" value="<?php echo $_SESSION['user_email']; ?>">
                <input  type="hidden" name="phone" value="<?php echo $data['order_details']->phone; ?>">
                <input  type="hidden" name="address" value="<?php echo $data['order_details']->address; ?>">
                <input  type="hidden" name="city" value="<?php echo $data['order_details']->city; ?>">
                <input  type="hidden" name="country" value="Sri Lanka">
                <input  type="hidden" name="hash" value="<?php echo $hash; ?>">
                <input  type="hidden" name="custom_1" value="<?php echo $data['order_details']->product_id; ?>">
                <input type="submit" value="Pay Now" class="payment-button">   
                
            </form>
        </div>
    </div>
</body>

</html>