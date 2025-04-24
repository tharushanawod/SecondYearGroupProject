<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Holders</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Manufacturer/StockHolders.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="maincontainer">
    <h1>Stock Holders (Over 1,000 kg)</h1>

    <!-- Buyer Cards -->
    <div class="worker-container">
        <?php if (empty($data['buyers'])): ?>
            <p>No buyers found with purchases over 1,000 kg.</p>
        <?php else: ?>
            <?php foreach ($data['buyers'] as $buyer): ?>
                <div class="worker-card">
                    <h3><?php echo htmlspecialchars($buyer->name); ?></h3>
                    <div class="worker-img">
                        <img src="<?php echo URLROOT . '/' . htmlspecialchars($buyer->profile_image); ?>" alt="<?php echo htmlspecialchars($buyer->name); ?>">
                    </div>                    
                    <p><b>Availability:</b> Available</p>
                    <p><b>Email:</b> <?php echo htmlspecialchars($buyer->email); ?></p>
                    <p><b>Total Purchased (kg):</b> <?php echo number_format($buyer->total_quantity, 0); ?></p>
                    <div class="button-group">
                        <button class="hire-btn" onclick="openHireModal('<?php echo htmlspecialchars($buyer->name); ?>', '<?php echo htmlspecialchars($buyer->phone); ?>')"><b>Contact</b></button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</div>

<div id="hireModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('hireModal')">&times;</span>
        <h3>Contact</h3>
        <p id="workerName"></p>
        <p id="workerPhone"></p>
        <button onclick="closeModal('hireModal')"><b>Cancel</b></button>
    </div>
</div>

<script src="<?php echo URLROOT;?>/js/Manufacturer/Contact.js"></script>
</body>
</html>