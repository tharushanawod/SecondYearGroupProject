<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Orders</title>
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Cart/ToPay.css" />

</head>

<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="container">
        <div class="page-header">
            <h1 class="page-title">Pending Orders</h1>
            <p class="page-description">Review and pay for your pending ingredient orders</p>
        </div>

        <div class="orders-grid">
            <?php if (!empty($data['orders'])) : ?>
            <?php foreach ($data['orders'] as $order) : ?>
                <div class="order-card">
                <div class="order-header">
                    <div class="order-id">
                    <i class="fas fa-shopping-bag"></i>
                    Order #<?php echo $order->order_id; ?>
                    </div>
                    <div class="order-date">
                    <i class="fas fa-calendar-alt"></i>
                    Placed on: <?php echo date("F j, Y", strtotime($order->order_date)); ?>
                    </div>
                    <div class="status-badge">
                    <i class="fas fa-clock"></i>
                    <?php echo $order->status; ?>
                    </div>
                </div>
                <div class="order-body">
                    <div class="order-items">
                    <?php foreach ($order->items as $item) : ?>
                        <div class="item">
                        <div class="item-image">
                            <img src="<?php echo URLROOT.'/uploads/'.$item->image_url; ?>" alt="<?php echo $item->product_name; ?>">
                        </div>
                        <div class="item-details">
                            <h3 class="item-name"><?php echo $item->product_name; ?></h3>
                            <p class="item-description"><?php echo $item->description; ?></p>
                            <div class="item-meta">
                            <?php if (isset($item->weight)) : ?>
                                <span class="meta-item">
                                <i class="fas fa-weight"></i>
                                <?php echo $item->weight; ?>
                                </span>
                            <?php endif; ?>
                            <span class="meta-item">
                                <i class="fas fa-tag"></i>
                                LKR <?php echo number_format($item->price, 2); ?>
                            </span>
                            <span class="meta-item">
                                <i class="fas fa-cubes"></i>
                                Qty: <?php echo $item->quantity; ?>
                            </span>
                            </div>
                        </div>
                        </div>
                    <?php endforeach; ?>
                    </div>
                    <div class="order-summary">
                    <div class="price-details">
                        <div class="subtotal">
                        <span>Subtotal:</span>
                        <span>LKR <?php echo number_format($order->total_amount, 2); ?></span>
                        </div>
                        <div class="total">LKR <?php echo number_format($order->total_amount, 2); ?></div>
                    </div>
                    <div class="order-actions">
                        <a href="<?php echo URLROOT .'/CartController/pay/'.$order->order_id ?>">
                        <button class="btn btn-primary" >
                        <i class="fas fa-credit-card"></i>
                        Pay Now
                        </button>
                        </a>

                        <a href="<?php echo URLROOT .'/CartController/CancelOrder/'.$order->order_id ?>">
                        <button class="btn btn-danger">
                        <i class="fas fa-times"></i>
                        Cancel Order
                        </button>
                        </a>
                        
                       
                    </div>
                    </div>
                </div>
                </div>
            <?php endforeach; ?>
            <?php else : ?>
            <script>
                document.querySelector('.empty-state').style.display = 'flex';
                document.querySelector('.orders-grid').style.display = 'none';
            </script>
            <?php endif; ?>
        </div>

        <!-- Empty state (hidden by default, show when no orders) -->
        <div class="empty-state" style="display: none;">
            <i class="fas fa-shopping-cart"></i>
            <h3>No Pending Orders</h3>
            <p>You don't have any orders waiting for payment at the moment. Browse our catalog to place a new order.</p>
            <a href="#" class="btn btn-primary">Shop Now</a>
        </div>

        <a href="<?php echo URLROOT;?>/FarmerController/orders" class="back-link">
            <i class="fas fa-arrow-left"></i>
            Back to All Orders
        </a>
    </div>
</body>

</html>