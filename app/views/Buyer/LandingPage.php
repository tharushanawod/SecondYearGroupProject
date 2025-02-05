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
            <div class="rate-card">
                <img src="<?php echo URLROOT;?>/images/images/img65.png" alt="Company Logo">
                <h3>Prima</h3>
                <p>Product: Dry Corn</p>
                <p>Rate: LKR 1200</p>
            </div>
            <div class="rate-card">
                <img src="<?php echo URLROOT;?>/images/images/img66.png" alt="Company Logo">
                <h3>Munchee</h3>
                <p>Product: Dry Corn</p>
                <p>Rate: LKR 1150</p>
            </div>
            <div class="rate-card">
                <img src="<?php echo URLROOT;?>/images/images/img67.jpeg" alt="Company Logo">
                <h3>Maliban</h3>
                <p>Product: Dry Corn</p>
                <p>Rate: LKR 1180</p>
            </div>
            <div class="rate-card">
                <img src="<?php echo URLROOT;?>/images/images/img70.png" alt="Company Logo">
                <h3>Cargills</h3>
                <p>Product: Dry Corn</p>
                <p>Rate: LKR 1220</p>
            </div>
        </div>
    </div>    
</body>
</html>