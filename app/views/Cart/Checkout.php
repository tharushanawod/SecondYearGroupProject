<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Cart/Checkout.css">
</head>
<body>
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>

    <div class="checkout-container">
        <div class="billing-section">
            <div class="checkout-header">
                <h1>Shipping Info</h1>
                <p>Please fill in your details to complete your purchase</p>
            </div>

            <form class="billing-details" action="<?php echo URLROOT;?>/CartController/PlaceOrder" method="POST">
    <h2 class="section-title">Payment Details</h2>

    <div class="form-group">
        <label for="first-name">First name *</label>
        <input type="text" id="first-name" name="first-name" value="<?php echo isset($data['user_details']->first_name) ? $data['user_details']->first_name : ''; ?>" required>
    </div>

    <div class="form-group">
        <label for="last-name">Last name *</label>
        <input type="text" id="last-name" name="last-name" value="<?php echo isset($data['user_details']->last_name) ? $data['user_details']->last_name : ''; ?>" required>
    </div>

    <div class="form-group">
        <label for="address">Street address *</label>
        <input type="text" id="address" name="address" value="<?php echo isset($data['user_details']->address) ? $data['user_details']->address : ''; ?>" required>
    </div>

    <div class="form-group">
        <label for="city">Town / City *</label>
        <input type="text" id="city" name="city" value="<?php echo isset($data['user_details']->city) ? $data['user_details']->city : ''; ?>" required>
    </div>

    <div class="form-group">
        <label for="postcode">Postcode / ZIP *</label>
        <input type="text" id="postcode" name="postcode" value="<?php echo isset($data['user_details']->postcode) ? $data['user_details']->postcode : ''; ?>" required>
    </div>

    <div class="form-group">
        <label for="phone">Phone *</label>
        <input type="tel" id="phone" name="phone" value="<?php echo isset($data['user_details']->phone) ? $data['user_details']->phone : ''; ?>" required>
    </div>

    <button class="place-order-btn" type="submit" name="place_order">
        <i class="fas fa-lock"></i>
        PLACE ORDER
    </button>
</form>


        </div>


    </div>
</body>
</html>