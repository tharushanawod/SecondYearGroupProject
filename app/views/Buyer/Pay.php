<?php
$merchant_id = "1229660";
$merchant_secret = "ODE5MTYxNzEwODgzMzQ3NDkxNTI5MDMzODIzMzA4Nzg3MTI5MA==";
$order_id = "ItemNo12345"; // Dynamic order ID
$amount = "1000"; // Dynamic amount
$currency = "LKR"; // Or USD

// Generate hash
$hash = strtoupper(md5(
    $merchant_id . 
    $order_id . 
    number_format($amount, 2, '.', '') . 
    $currency .  
    strtoupper(md5($merchant_secret)) 
));

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Details</title>
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/Pay.css">
   
</head>
<body>
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>

    <div class="payment-container">
        <div class="payment-header">
            <h2>Payment Details</h2>
            <p>Complete your advance payment to complete the process</p>
        </div>

        <div class="product-info">
            <h3>Product Information</h3>
            <div class="product-detail">
                <span>Product:</span>
                <span>Fresh Corn</span>
            </div>
            <div class="product-detail">
                <span>Quantity:</span>
                <span><?php echo $data['paymentDetails']->quantity; ?> Kg</span>
            </div>
            <div class="product-detail">
                <span>Unit Price:</span>
                <span>Rs. <?php echo number_format($data['paymentDetails']->bid_price,2); ?>
</span>
            </div>
        </div>

        <div class="payment-details">
            <div class="detail-row">
                <span class="detail-label">Total Amount</span>
                <span class="detail-value">Rs. <?php echo number_format($data['total_amount'], 2); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Advance Payment (20%)</span>
                <span class="detail-value">Rs. <?php echo number_format($data['advance_payment'], 2); ?></span>
            </div>
            <div class="detail-row">
                <span class="detail-label">Site Service Charge (2%)</span>
                <span class="detail-value">Rs. <?php echo number_format($data['service_charge'], 2); ?></span>
            </div>

            <div class="total-section">
                <div class="total-row">
                    <span>Total Advance Payment</span>
                    <span>Rs. <?php echo number_format($data['total_advance'], 2); ?></span>
                </div>
            </div>
        </div>

        <div class="payment-info">
            <h3><i class="fas fa-info-circle"></i> Important Information</h3>
            <p>The advance payment is required to confirm your bid. This amount includes a 20% advance of the total bid amount plus a 2% service charge. The remaining balance will be due upon delivery.</p>
        </div>

        <form method="POST" action="https://sandbox.payhere.lk/pay/checkout" >
            <input type="hidden" name="merchant_id" value="1229660">    <!-- Replace your Merchant ID -->
    <input type="hidden" name="return_url" value="http://sample.com/return">
    <input type="hidden" name="cancel_url" value="http://sample.com/cancel">
    <input type="hidden" name="notify_url" value="http://sample.com/notify">  
    </br></br>Item Details</br>
    <input type="text" name="order_id" value="ItemNo12345">
    <input type="text" name="items" value="Door bell wireless">
    <input type="text" name="currency" value="LKR">
    <input type="text" name="amount" value="1000">  
    </br></br>Customer Details</br>
    <input type="text" name="first_name" value="Saman">
    <input type="text" name="last_name" value="Perera">
    <input type="text" name="email" value="samanp@gmail.com">
    <input type="text" name="phone" value="0771234567">
    <input type="text" name="address" value="No.1, Galle Road">
    <input type="text" name="city" value="Colombo">
    <input type="hidden" name="country" value="Sri Lanka">
    <input type="hidden" name="hash" value="<?php echo $hash;?>">    <!-- Replace with generated hash -->
    <input type="submit" value="Buy Now">   
        </form>
    </div>
</body>
</html>
