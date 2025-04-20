<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My Orders</title>
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/orders.css">
</head>

<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="orders-container">
        <div class="orders-header">
            <h1>My Orders</h1>
            <p>Select a category to manage your orders</p>
        </div>

        <div class="cards-container">
            <!-- To Pay Card -->
            <div class="order-card to-pay">
                <div class="card-header">
                    <i class="fas fa-credit-card card-icon"></i>
                    <div class="card-wave"></div>
                    <div class="card-badge">Pending</div>
                </div>
                <div class="card-content">
                    <div>
                        <h2 class="card-title">To Pay</h2>
                        <p class="card-description">View orders that need payment to process your purchases.</p>
                    </div>
                    <a href="to-pay.html" class="card-button">
                        <i class="fas fa-arrow-right"></i>
                        View Orders
                    </a>
                </div>
            </div>

            <!-- To Pick Up Card -->
            <div class="order-card to-pickup">
                <div class="card-header">
                    <i class="fas fa-box card-icon"></i>
                    <div class="card-wave"></div>
                    <div class="card-badge">Processing</div>
                </div>
                <div class="card-content">
                    <div>
                        <h2 class="card-title">To Pick Up</h2>
                        <p class="card-description">Track orders waiting for pickup by sellers.</p>
                    </div>
                    <a href="<?php echo URLROOT;?>/FarmerController/ToPickup" class="card-button">
                        <i class="fas fa-arrow-right"></i>
                        View Orders
                    </a>
                </div>
            </div>

            <!-- To Receive Card -->
            <div class="order-card to-receive">
                <div class="card-header">
                    <i class="fas fa-truck-loading card-icon"></i>
                    <div class="card-wave"></div>
                    <div class="card-badge">In Transit</div>
                </div>
                <div class="card-content">
                    <div>
                        <h2 class="card-title">To Receive</h2>
                        <p class="card-description">Monitor orders that are on the way to your location.</p>
                    </div>
                    <a href="<?php echo URLROOT;?>/FarmerController/inventory" class="card-button">
                        <i class="fas fa-arrow-right"></i>
                        View Orders
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>