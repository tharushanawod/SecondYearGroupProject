<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Dashboard</title>
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/FarmerDashboard.css">
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="dashboard-container">
    <div class="welcome-section">
        <h1>Welcome back,
            <?php echo $data['user_name']; ?>!
        </h1>
        <p>Manage your products and track your orders</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon products-icon">
                    <i class="fas fa-seedling"></i>
                </div>
                <div class="stat-info">
                    <h3>Active Products</h3>
                    <p>
                        <?php echo $data['active_products']; ?>
                    </p>
                    <div class="stat-date">As of
                        <?php echo date('M d, Y'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon active-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3>Latest Bids on My Products</h3>
                    <p>
                        <?php echo $data['bid_amount']; ?>
                    </p>
                    <div class="stat-date">Quantity
                    <?php echo $data['qunatity']; ?> Kg
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon earnings-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="stat-info">
                    <h3>All-Time Earnings</h3>
                    <p>Rs.
                        <?php echo number_format($data['total_earnings'], 2); ?>
                    </p>
                    <div class="stat-date">Up to Now
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon orders-icon">
                    <i class="fas fa-shopping-cart"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Orders</h3>
                    <p>
                        <?php echo $data['total_orders']; ?>
                    </p>
                    <div class="stat-date">As of
                        <?php echo date('M d, Y'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="recent-section">
        <div class="section-header">
            <h2>Recent Orders</h2>
            <a href="<?php echo URLROOT; ?>/FarmerController/orders" class="view-all">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <table class="recent-orders">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['recent_orders'] as $order): ?>
                <tr>
                    <td>
                        Corn <?php echo $order->quantity; ?> Kg
                    </td>
                    <td>
                        <?php echo $order->bid_price; ?>
                    </td>
                    <td>Rs.
                        <?php 
                        $amount = $order->quantity * $order->bid_price;
                        echo number_format($amount, 2); ?>
                    </td>
                    <td>
                        <?php echo date('M d, Y', strtotime($order->order_date)); ?>
                    </td>
                    <td>
                        <span class="order-status status-<?php echo strtolower($order->payment_status); ?>">
                        <?php 
                            if ($order->payment_status == 'failed') {
                                echo 'Failed';
                            } elseif ($order->payment_status == 'paid') {
                                echo 'Paid';
                            } else {
                                echo 'Pending';
                            }
                        ?>      
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>