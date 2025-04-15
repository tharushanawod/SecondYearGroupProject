<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manufacturer Dashboard</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/Manufacturer/ManufacturerDashboard.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>
    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/sidebar.php'; ?>

        <div class="main-content">
            <div class="main-content-header">
                <h1>Manufacturer Dashboard</h1>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
            <?php endif; ?>
            <?php if (empty($data)): ?>
                <p class="error">Unable to load dashboard data. Please try again later.</p>
            <?php endif; ?>
            
            <!-- New top section with pricing info and history side by side -->
            <div class="top-section">
                <div class="price-info">
                    <h3>Market Prices</h3>
                    <div class="price-item">
                        <p>Current Floor Price: LKR <?php echo !empty($data['floor_price']) ? number_format($data['floor_price'], 2) : 'Not Available'; ?>
                            <?php if (!empty($data['is_default_floor_price']) && $data['is_default_floor_price']): ?>
                                <span class="warning">(Default value, contact support for an updated price)</span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="price-item">
                        <p>Market Average (Last 30 Days): LKR <?php echo !empty($data['market_average']) ? number_format($data['market_average'], 2) : 'Not Available'; ?>
                            <?php if (!empty($data['market_average']) && isset($data['market_average_reliable']) && !$data['market_average_reliable']): ?>
                                <span class="warning">(Based on limited bids)</span>
                            <?php endif; ?>
                        </p>
                    </div>
                    <div class="price-item">
                        <p>Your Minimum Price: LKR <?php echo !empty($data['last_price']) ? number_format($data['last_price'], 2) : 'Not Set'; ?>+</p>
                    </div>
                </div>

                <div class="price-history">
                    <h2>Price History</h2>
                    <table>
                        <thead>
                            <tr>
                                <td>Date</td>
                                <td>Minimum Price</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['price_history'])): ?>
                                <?php foreach ($data['price_history'] as $price): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($price->updated_at); ?></td>
                                        <td>LKR <?php echo number_format($price->unit_price, 2); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="2">No price history available</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- These sections remain unchanged -->
            <div class="details">
                <!-- Recent Auction Bids -->
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Recent Auction Bids</h2>
                        <a href="#" class="btn">View All Bids</a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Farmer</td>
                                <td>Bid Amount</td>
                                <td>Status</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['recent_bids'])): ?>
                                <?php foreach ($data['recent_bids'] as $bid): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($bid->farmer); ?></td>
                                        <td>LKR <?php echo number_format($bid->bid_amount, 2); ?></td>
                                        <td><span class="<?php echo strtolower($bid->status); ?>"><?php echo htmlspecialchars($bid->status); ?></span></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="3">No recent bids available</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>

                <!-- Recent Purchases -->
                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>Recent Purchases</h2>
                        <a href="<?php echo URLROOT; ?>/ManufacturerController/setMinimumPrice" class="btn">Update Minimum Price</a>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Source</td>
                                <td>Amount</td>
                                <td>Type</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($data['recent_purchases'])): ?>
                                <?php foreach ($data['recent_purchases'] as $purchase): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($purchase->source); ?></td>
                                        <td>LKR <?php echo number_format($purchase->amount, 2); ?></td>
                                        <td><?php echo htmlspecialchars($purchase->type); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="3">No recent purchases available</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.querySelector('.toggle-tools')?.addEventListener('click', function(e) {
            e.preventDefault();
            const parent = this.parentElement;
            parent.classList.toggle('active');
        });
    </script>
</body>
</html>