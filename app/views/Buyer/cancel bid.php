<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Bid</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/cancel bid.css">
</head>
<body>
    
<?php require 'sidebar.php';?>

    <div class="header-content">
        <h1>Cancel Bid</h1>
        <div class="search-container">
            <input type="text" id="search" placeholder="Search products..." onkeyup="filterProducts()">
            <button id="searchBtn">Search</button>
        </div>
    </div>        
    

    <div class="container">
        <div class="product-card">
            <img src="<?php echo URLROOT;?>/images/images/img7.jpeg" alt="Product Image" class="product-img">
            <div class="product-details">
                <h3>Fresh Corn</h3>
                    <p>Current Bid: LKR 1000</p>
                    <p>Number of Bids: 5</p>
                    <p>Status: Active</p>
                    <p>Specifications: Large, Yellow, Organic</p>                    
                    <p>Quantity: 100 kg</p>
            </div>
        </div>            
    </div>

    <div class="container">
        <div class="cancel-reason">
            <label for="reason">Reason For Cancellation</label>
            <select id="reason">
                <option value="">Select a Reason</option>
                <option value="reason1">Reason 1</option>
                <option value="reason2">Reason 2</option>
                <option value="reason3">Reason 3</option>
            </select>
        </div>
    </div>

    <div class="container">
        <div class="confirmation">
            <p>Are you sure you want to cancel this bid? This action cannot be undone.</p>
            <button class="cancel-btn">Cancel Bid</button>
            <a href="<?php echo URLROOT;?>/BuyerController/placeBid" target="content-frame">
                <button class="adjust-btn">Adjust Bid</button>
            </a>
        </div>
    </div>

    <script src="<?php echo URLROOT;?>/js/Buyer/cancel bid.js"></script>
</body>
</body>
</html>