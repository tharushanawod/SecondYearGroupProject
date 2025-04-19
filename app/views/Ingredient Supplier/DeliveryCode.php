<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Send Delivery Code</title>
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/Ingredient Supplier/DeliveryCode.css">
</head>

<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="delivery-container">
        <div class="delivery-header">
            <h1>Send Delivery Code</h1>
            <p>Enter the delivery details and code for the buyer</p>
        </div>

        <div class="delivery-card">
            <form id="deliveryForm" action="<?php echo URLROOT; ?>/SupplierController/sendDeliveryCode/<?php echo $data['orderId'];?>"
                method="POST" >
                <div class="form-group">
                    <label for="orderId">Order ID *</label>
                    <input type="text" id="orderId" name="orderId" value="<?php echo $data['orderId'];?>" required>
                </div> 
                <div class="form-group">
                    <label for="deliveryCompany">Delivery Company *</label>
                    <input type="text" id="deliveryCompany" name="deliveryCompany" required>
                </div>

                <div class="form-group">
                    <label for="trackingNumber">Tracking Number *</label>
                    <input type="text" id="trackingNumber" name="trackingNumber" required>
                </div>

                <button type="submit" class="submit-btn">
                    <i class="fas fa-paper-plane"></i>
                    Send Delivery Code
                </button>
            </form>
        </div>
    </div>

   
</body>

</html>