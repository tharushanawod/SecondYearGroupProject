<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bid Landing Page</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/LandingPage.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>

</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>

    <div class="content-wrapper">        
        <div class="container-card">
            <img src="<?php echo URLROOT;?>/images/images/img39.png" alt="Product Image" class="large-image">
            <div class="text">
            <h1>Bid on Premium Corn Products!</h1>
            <p>Fresh from the farm</p>
            <a href="<?php echo URLROOT;?>/BuyerController/bidProduct" class="button-link">
                <button class="cta-button">START BIDDING →</button>
            </a>
            </div>
        </div>
    </div>   
    <div class="current-rates">
        <h2>Current Rates</h2>
        <div class="rates-grid">
            <?php if (empty($data['prices'])): ?>
                <p class="no-rates">No manufacturer prices available</p>
            <?php else: ?>
                <?php foreach ($data['prices'] as $price): ?>
                    <div class="rate-card">
                        <img src="<?php echo URLROOT . '/' . htmlspecialchars($price->profile_image ?: 'images/default_company.png'); ?>" alt="<?php echo htmlspecialchars($price->company_name ?: 'Unknown Manufacturer'); ?> Logo">
                        <h3><?php echo htmlspecialchars($price->company_name ?: 'Unknown Manufacturer'); ?></h3>
                        <p>Product: Dry Corn</p>
                        <p>Rate: LKR <?php echo number_format($price->unit_price, 2); ?> (1Kg)</p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>    
</body>
</html>