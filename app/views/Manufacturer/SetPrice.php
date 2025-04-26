<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Set Minimum Price</title>
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/Manufacturer/SetPrice.css">
</head>
<body>
    <div class="dashboard-container">
        <?php require APPROOT . '/views/inc/sidebar.php'; ?>

        <div class="main-content">
            <div class="welcome-section">
                <h1>Inform Your Price To Farmers</h1>
            </div>

            <?php if (isset($_SESSION['price_success'])): ?>
                <p class="success"><?php echo htmlspecialchars($_SESSION['price_success']); unset($_SESSION['price_success']); ?></p>
            <?php endif; ?>
            <?php if (isset($_SESSION['price_error'])): ?>
                <p class="error"><?php echo htmlspecialchars($_SESSION['price_error']); unset($_SESSION['price_error']); ?></p>
            <?php endif; ?>

            <div class="recent-section">
                <div class="section-header">
                    <h2>Set Your Price</h2>
                </div>
                <form action="<?php echo URLROOT; ?>/ManufacturerController/SetPrice" method="POST" class="price-form">
                    <label for="unit_price">Unit Price (LKR):</label>
                    <input type="number" step="1" name="unit_price" id="unit_price" value="<?php echo htmlspecialchars($data['unit_price']); ?>" required>
                    <?php if (!empty($data['unit_price_err'])): ?>
                        <p class="error"><?php echo htmlspecialchars($data['unit_price_err']); ?></p>
                    <?php endif; ?>
                    <input type="hidden" name="action" value="set">
                    <div class="button-group">
                        <button type="submit" class="btn save-btn" title="<?php echo $data['unit_price'] ? 'Update Price' : 'Add Price'; ?>">
                            <i class="fas fa-save"></i>
                        </button>
                        <?php if ($data['unit_price']): ?>
                            <button type="submit" name="action" value="delete" class="btn delete-btn" onclick="return confirm('Are you sure you want to delete the price?');" title="Delete Price">
                                <i class="fas fa-trash"></i>
                            </button>
                        <?php endif; ?>
                    </div>
                </form>
            </div>

            <div class="recent-section">
                <div class="section-header">
                    <h2>Other Manufacturers' Prices</h2>
                </div>
                <table class="recent-bids">
                    <thead>
                        <tr>
                            <th>Manufacturer</th>
                            <th>Price (LKR)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($data['other_prices'])): ?>
                            <?php foreach ($data['other_prices'] as $price): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($price->company_name ?: 'Unknown Manufacturer'); ?></td>
                                    <td><?php echo number_format($price->unit_price, 2); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="2">No other manufacturer prices available</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
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