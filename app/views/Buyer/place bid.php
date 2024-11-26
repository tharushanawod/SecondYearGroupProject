<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Place Bid</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/place bid.css">
</head>
<body>
<?php require 'sidebar.php';?>
    
    <div class="header-content">
        <h1>Place Your Bid</h1>        
    </div>       
    
    <div class="container1">
        <div class="product-card">
            <img src="<?php echo URLROOT;?>/images/images/img7.jpeg" alt="Product Image" class="product-img">
            <div class="product-details">
                <h3>Fresh Corn</h3>
                    <p>Current Bid: LKR 1000</p>
                    <p>Number of Bids: 5</p>
                    <p>Status: Active</p>
                    <p>Remaining time: 1 day</p>                    
                    <p>Quantity: 100 kg</p>
            </div>
        </div>
        <div class="increase-bid">
            <h2>Place Your Bid</h2>
            <p>You are about to bid on this product. Make sure to place a bid higher than the current bid to increase your chances of winning.</p>
            <input type="number" id="newBid" placeholder="Enter your bid">
            <button class="submit-btn">Place Bid</button>
        </div>
    </div>

    <!-- <div class="container2">
        <div class="increase-bid">
            <h2>Place Your Bid</h2>
            <p>You are about to bid on this product. Make sure to place a bid higher than the current bid to increase your chances of winning.</p>
            <input type="number" id="newBid" placeholder="Enter your bid">
            <button class="submit-btn">Place Bid</button>
        </div>
    </div> -->
</body>
</html>