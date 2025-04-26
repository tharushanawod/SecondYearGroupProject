<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manufacturer Dashboard</title>
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/Manufacturer/ManufacturerDashboard.css">
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="dashboard-container">
    <div class="welcome-section">
        <h1>Welcome back, <?php echo $data['user_name']; ?>!</h1>
        <p>Track your bids and manage your minimum price</p>
    </div>

    <?php if (isset($_SESSION['price_success'])): ?>
        <div class="success"><?php echo $_SESSION['price_success']; unset($_SESSION['price_success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['price_error'])): ?>
        <div class="error"><?php echo $_SESSION['price_error']; unset($_SESSION['price_error']); ?></div>
    <?php endif; ?>
    <?php if (!empty($data['error'])): ?>
        <div class="error"><?php echo $data['error']; ?></div>
    <?php endif; ?>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon price-icon">
                    <i class="fas fa-tag"></i>
                </div>
                <div class="stat-info">
                    <h3>Your Price</h3>
                    <p>LKR <?php echo $data['last_price'] ? number_format($data['last_price'], 2) : 'Not Set'; ?></p>
                    <div class="stat-date">
                    <div class="stat-date">As of <?php echo date('M d, Y'); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon bids-icon">
                    <i class="fas fa-gavel"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Bids You Placed</h3>
                    <p><?php echo $data['total_bids']; ?></p>
                    <div class="stat-date">As of <?php echo date('M d, Y'); ?></div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon active-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3>Active Products</h3>
                    <p><?php echo $data['active_products']; ?></p>
                    <div class="stat-date">Updated <?php echo date('M d, Y'); ?></div>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon spent-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="stat-info">
                    <h3>Total Spent</h3>
                    <p>LKR <?php echo number_format($data['total_spent'], 2); ?></p>
                    <div class="stat-date">Since <?php echo date('M d, Y'); ?></div>
                </div>
            </div>
        </div>        
    </div>

    <div class="recent-section">
        <div class="section-header">
            <h2>Recent Bids</h2>
            <a href="<?php echo URLROOT; ?>/ManufacturerController/BidControl" class="view-all">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <table class="recent-bids">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Bid Amount</th>
                    <th>Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['recent_bids'])): ?>
                    <?php foreach($data['recent_bids'] as $bid): ?>
                    <tr>
                        <td>Corn <?php echo htmlspecialchars($bid->quantity); ?> Kg</td>
                        <td>LKR <?php echo number_format($bid->bid_amount, 2); ?></td>
                        <td><?php echo date('M d, Y', strtotime($bid->bid_time)); ?></td>
                        <td>
                            <span class="bid-status <?php
                                if ($bid->closing_date > date('Y-m-d H:i:s') && !is_null($bid->order_id)) {
                                    echo 'status-won';
                                } elseif ($bid->closing_date > date('Y-m-d H:i:s') && is_null($bid->order_id)) {
                                    echo 'status-active';
                                } elseif ($bid->closing_date < date('Y-m-d H:i:s') && is_null($bid->order_id)) {
                                    echo 'status-lost';
                                } else {
                                    echo '';
                                }
                            ?>">
                                <?php
                                if ($bid->closing_date > date('Y-m-d H:i:s') && !is_null($bid->order_id)) {
                                    echo 'Won';
                                } elseif ($bid->closing_date > date('Y-m-d H:i:s') && is_null($bid->order_id)) {
                                    echo 'Active';
                                } elseif ($bid->closing_date < date('Y-m-d H:i:s') && is_null($bid->order_id)) {
                                    echo 'Lost';
                                } else {
                                    echo 'Unknown';
                                }
                                ?>
                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">No recent bids available</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>