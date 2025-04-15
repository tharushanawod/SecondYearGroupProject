<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Minimum Price</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/Manufacturer/SetMinPrice.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>
    <div class="container">
        <?php require APPROOT . '/views/inc/sidebar.php'; ?>

        <div class="main-content">  
            <div class="main-content-header">
                <h1>Set Minimum Price</h1>
            </div>

            <?php if (isset($_SESSION['success'])): ?>
                <p class="success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></p>
            <?php endif; ?>
            <?php if (isset($_SESSION['error'])): ?>
                <p class="error"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></p>
            <?php endif; ?>

            <div class="pricing-flex-container">
                <div class="market-prices">
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
                        <p>Your Current Minimum Price: LKR <?php echo !empty($data['unit_price']) ? number_format($data['unit_price'], 2) : 'Not Set'; ?>+</p>
                    </div>
                </div>
                
                <div class="set-price-container">
                    <h2>Update Your Minimum Unit Price</h2>
                    <?php if (!empty($data['price_err'])): ?>
                        <p class="error"><?php echo htmlspecialchars($data['price_err']); ?></p>
                    <?php endif; ?>
                    <form action="<?php echo URLROOT; ?>/ManufacturerController/setMinimumPrice" method="POST">
                        <input type="hidden" name="action" value="update">
                        <label for="unit-price">Minimum Price (Must be ≥ LKR <?php echo !empty($data['floor_price']) ? htmlspecialchars($data['floor_price']) : 'Not Available'; ?>)</label>
                        <input type="number" id="unit-price" name="unit_price" min="<?php echo !empty($data['floor_price']) ? htmlspecialchars($data['floor_price']) : 0; ?>" value="<?php echo htmlspecialchars($data['unit_price']); ?>" step="50" required>
                        <p>Suggested Range: LKR <?php echo !empty($data['floor_price']) ? htmlspecialchars($data['floor_price']) : 'Not Available'; ?> – <?php echo !empty($data['floor_price']) ? htmlspecialchars($data['floor_price'] + 150) : 'Not Available'; ?></p>
                        <button type="submit">Update Price</button>
                        
                        <?php if (!empty($data['unit_price'])): ?>
                            <button type="submit" name="action" value="delete" class="reject">Delete Current Price</button>
                        <?php endif; ?>
                    </form>
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
    </div>
</body>
</html>