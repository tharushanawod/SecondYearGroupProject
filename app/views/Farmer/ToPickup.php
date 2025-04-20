<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders To Be Picked Up</title>
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/ToPickup.css" />
   
</head>

<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Orders Awaiting Pickup</h1>
            <a href="orders.html" class="back-button">
                <i class="fas fa-arrow-left"></i>
                Back to Orders
            </a>
        </div>

        <div class="filters">
            <button class="filter active">All (5)</button>
            <button class="filter">Recent (3)</button>
            <button class="filter">Oldest (2)</button>
            <button class="filter">High Value (2)</button>
        </div>

        <div class="cards-grid">
            <?php if(empty($data['orders'])): ?>
            <script>
                document.querySelector('.empty-state').style.display = 'flex';
            </script>
            <?php else: ?>
            <?php foreach($data['orders'] as $order): ?>
                <!-- Product Card -->
                <div class="product-card">
                <div class="product-image">
                    <img src="<?php echo $order->image ? URLROOT.'/uploads/'.$order->image : URLROOT.'/img/default-product.jpg'; ?>"
                    alt="<?php echo $order->product_name; ?>">
                    <div class="status-badge">
                    <i class="fas fa-clock"></i>
                    Awaiting Pickup
                    </div>
                </div>
                <div class="product-details">
                    <h3 class="product-name"><?php echo $order->product_name; ?></h3>
                    <div class="product-info">
                    <div class="info-row">
                        <span class="info-label">Quantity:</span>
                        <span class="info-value"><?php echo $order->quantity; ?> kg</span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Price:</span>
                        <span class="info-value">LKR <?php echo number_format($order->price, 2); ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Order Date:</span>
                        <span class="info-value"><?php echo $order->order_date; ?></span>
                    </div>
                    <div class="info-row">
                        <span class="info-label">Seller:</span>
                        <span class="info-value"><?php echo $order->seller_name; ?></span>
                    </div>
                    </div>
                    <div class="product-action">
                    <span class="order-id">Order #<?php echo $order->order_id; ?></span>
                    <button class="contact-seller" data-phone="<?php echo $order->seller_phone; ?>">
                        <i class="fas fa-phone-alt"></i>
                        Contact Seller
                    </button>
                    </div>
                </div>
                </div>
            <?php endforeach; ?>
            <?php endif; ?>
        </div>

        <!-- Empty State (hidden by default, show when no orders) -->
        <div class="empty-state" style="display: none;">
            <i class="fas fa-box-open"></i>
            <h3>No orders awaiting pickup</h3>
            <p>All your orders have been picked up by sellers or you haven't placed any orders yet.</p>
        </div>
    </div>
</body>

</html>