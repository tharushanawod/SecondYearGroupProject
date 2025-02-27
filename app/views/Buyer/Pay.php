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

        <form action="<?php echo URLROOT; ?>/BuyerController/processPayment" method="POST">
            <input type="hidden" name="bid_id" value="<?php echo $data['bid_id']; ?>">
            <input type="hidden" name="amount" value="<?php echo $data['total_advance']; ?>">
            <button type="submit" class="pay-button">
                Proceed to Payment
            </button>
        </form>
    </div>
</body>
</html>
