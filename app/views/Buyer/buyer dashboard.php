<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Dashboard</title>
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/buyer dashboard.css">
</head>

<body>
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>

    <div class="dashboard-container">
        <div class="welcome-section">
            <h1>Welcome back,
                <?php echo $data['user_name']; ?>!
            </h1>
            <p>Track your bids and auction activities</p>
        </div>

        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon bids-icon">
                        <i class="fas fa-gavel"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Total Bids</h3>
                        <p>
                            <?php echo $data['total_bids']; ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon active-icon">
                        <i class="fas fa-clock"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Active Bids</h3>
                        <p>
                            <?php echo $data['active_bids']; ?>
                        </p>
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
                        <p>Rs.
                            <?php echo number_format($data['total_spent'], 2); ?>
                        </p>
                    </div>
                </div>
            </div>

            <div class="stat-card">
                <div class="stat-header">
                    <div class="stat-icon win-icon">
                        <i class="fas fa-trophy"></i>
                    </div>
                    <div class="stat-info">
                        <h3>Auctions Won</h3>
                        <p>
                            <?php echo $data['auctions_won']; ?>
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="recent-section">
            <div class="section-header">
                <h2>Recent Bids</h2>
                <a href="<?php echo URLROOT; ?>/BuyerController/bids" class="view-all">
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
                    <?php foreach($data['recent_bids'] as $bid): ?>
                    <tr>
                        <td>
                            <?php echo $bid['product_name']; ?>
                        </td>
                        <td>Rs.
                            <?php echo number_format($bid['amount'], 2); ?>
                        </td>
                        <td>
                            <?php echo date('M d, Y', strtotime($bid['date'])); ?>
                        </td>
                        <td>
                            <span class="bid-status status-<?php echo strtolower($bid['status']); ?>">
                                <?php echo $bid['status']; ?>
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