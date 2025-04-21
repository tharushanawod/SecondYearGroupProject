<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Ingredient Supplier/Supplier Dashboard.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet" />
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="dashboard-container">
    <div class="welcome-section">
        <h1>Welcome back,
            <?php echo $data['user_name']; ?>!
        </h1>
        <p>Manage your ingredient supply business</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon orders-icon">
                    <i class="fas fa-box"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Completd Orders</h3>
                    <p>
                        <?php echo $data['CompletedOrderCount']; ?>
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
                    <h3>Pending Orders</h3>
                    <p>
                        <?php echo $data['PendingOrderCount']; ?>
                    </p>
                    <div class="stat-date">Updated
                        <?php echo date('M d, Y'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon revenue-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Revenue</h3>
                    <p>Rs.
                        <?php echo number_format($data['total_revenue'], 2); ?>
                    </p>
                    <div class="stat-date">Since
                        <?php echo date('M d, Y'); ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon rating-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-info">
                    <h3>Average Rating</h3>
                    <p>
                        <?php echo number_format($data['average_rating'], 1); ?>/5.0
                    </p>
                    <div class="stat-date">Based on
                        <?php echo $data['total_ratings']; ?> reviews
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="recent-section">
        <div class="section-header">
            <h2>Recent Orders</h2>
            <a href="<?php echo URLROOT; ?>/IngredientSupplierController/orders" class="view-all">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <table class="recent-orders">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer</th>
                    <th>Amount</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
            <?php if (!empty($data['recentOrders'])) : ?>
               <?php foreach($data['recentOrders'] as $order): ?>

                <tr>
                    <td>#
                        <?php echo $order->order_id; ?>
                    </td>
                    <td>
                        <?php echo $order->first_name; ?>
                    </td>
                    <td>Rs.
                        <?php echo number_format($order->price*$order->quantity, 2); ?>
                    </td>
                    <td>
                        <?php echo date('M d, Y', strtotime($order->order_date)); ?>
                    </td>
                    <td>
                        <span class="order-status status-<?php echo strtolower($order->payment_status); ?>">
                            <?php echo $order->payment_status; ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
                <?php else : ?>
                    <tr>
                        <td colspan="5" class="no-orders">No recent orders available.</td>
                    </tr>
<?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>