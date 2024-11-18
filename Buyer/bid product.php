<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bidding Page</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/bid product.css">
</head>
<body>
<?php require 'header.php';?>
    <div class="header1">
        <div class="header-content">
            <h1>Bid On Products</h1>
            <p class="header1-subtitle">Explore our active bids and secure your favorite items.</p>
            <div class="search-container">
                <input type="text" id="search" placeholder="Search products..." onkeyup="filterProducts()">
                <button id="searchBtn">Search</button>
            </div>
        </div>        
    </div>
    <div class="main-content">
        <div class="sidebar">
            <h3>Filter Products</h3>
            <div class="filter-section">
                <h4>Breed</h4>
                <label><input type="checkbox" name="breed" value="yellow"> Yellow Corn</label>
                <label><input type="checkbox" name="breed" value="white"> White Corn</label>
                <label><input type="checkbox" name="breed" value="sweet"> Sweet Corn</label>
            </div>
            <div class="filter-section">
                <h4>Category</h4>
                <label><input type="checkbox" name="category" value="fresh"> Fresh</label>
                <label><input type="checkbox" name="category" value="dry"> Dry</label>
                <label><input type="checkbox" name="category" value="processed"> Processed</label>
            </div>
            <div class="filter-section">
                <h4>Quantity</h4>
                <label>Min: <input type="number" id="minQuantity" min="0" step="10"></label>
                <label>Max: <input type="number" id="maxQuantity" min="0" step="10"></label>
            </div>
            <button id="applyFilters">Apply Filters</button>
        </div>
        <div class="active-bids">
            <h2>Active Bids</h2>
            <div class="bids-grid" id="activeBids">
                <div class="bid-card" data-category="fresh" data-quantity="200">
                <img src="<?php echo URLROOT;?>/images/images/img22.jpg" alt="Fresh Corn">
                    <h3>Fresh Corn</h3>
                    <p>Current Bid: LKR 1500</p>
                    <p>Number of Bids: 8</p>
                    <p>Status: Active</p>
                    <p>Specifications: Large, Yellow, Non-Organic</p>
                    <p>Quantity: 200 kg</p>
                    <div class="button-row">
                        <a href="<?php echo URLROOT;?>/BuyerController/placeBid" target="content-frame" class="action-btn">Place Bid</a>
                        <a href="<?php echo URLROOT;?>/BuyerController/viewDetails" target="content-frame" class="action-btn">View Details</a>
                    </div>
                </div>
                <div class="bid-card" data-category="fresh" data-quantity="100">
                <img src="<?php echo URLROOT;?>/images/images/img28.jpg" alt="Fresh Corn">
                    <h3>Fresh Corn</h3>
                    <p>Current Bid: LKR 1000</p>
                    <p>Number of Bids: 5</p>
                    <p>Status: Active</p>
                    <p>Specifications: Large, Yellow, Organic</p>                    
                    <p>Quantity: 100 kg</p>
                    <div class="button-row">
                        <a href="<?php echo URLROOT;?>/BuyerController/placeBid" target="content-frame" class="action-btn">Place Bid</a>
                        <a href="<?php echo URLROOT;?>/BuyerController/viewDetails" target="content-frame" class="action-btn">View Details</a>
                    </div>
                </div>
                <div class="bid-card" data-category="dry" data-quantity="50">
                <img src="<?php echo URLROOT;?>/images/images/img7.jpeg" alt="Dry Corn">
                    <h3>Dry Corn</h3>
                    <p>Current Bid: LKR 500</p>
                    <p>Number of Bids: 3</p>
                    <p>Status: Active</p>
                    <p>Specifications: Small, White, Non-Organic</p>                    
                    <p>Quantity: 50 kg</p>
                    <div class="button-row">
                        <a href="<?php echo URLROOT;?>/BuyerController/placeBid" target="content-frame" class="action-btn">Place Bid</a>
                        <a href="<?php echo URLROOT;?>/BuyerController/viewDetails" target="content-frame" class="action-btn">View Details</a>
                    </div>
                </div>
                <div class="bid-card" data-category="processed" data-quantity="200">
                <img src="<?php echo URLROOT;?>/images/images/img9.jpeg" alt="Processed Corn">                    
                    <h3>Processed Corn</h3>
                    <p>Current Bid: LKR 1500</p>
                    <p>Number of Bids: 7</p>
                    <p>Status: Active</p>
                    <p>Specifications: Medium, Yellow, Organic</p>                    
                    <p>Quantity: 200 kg</p>
                    <div class="button-row">
                        <a href="<?php echo URLROOT;?>/BuyerController/placeBid" target="content-frame" class="action-btn">Place Bid</a>
                        <a href="<?php echo URLROOT;?>/BuyerController/viewDetails" target="content-frame" class="action-btn">View Details</a>
                    </div>
                </div>
                <div class="bid-card" data-category="fresh" data-quantity="150">
                <img src="<?php echo URLROOT;?>/images/images/img8.jpeg" alt="Processed Corn">
                    <h3>Fresh Corn</h3>
                    <p>Current Bid: LKR 1200</p>
                    <p>Number of Bids: 4</p>
                    <p>Status: Active</p>
                    <p>Specifications: Medium, White, Non-Organic</p>                    
                    <p>Quantity: 150 kg</p>
                    <div class="button-row">
                        <a href="<?php echo URLROOT;?>/BuyerController/placeBid" target="content-frame" class="action-btn">Place Bid</a>
                        <a href="<?php echo URLROOT;?>/BuyerController/viewDetails" target="content-frame" class="action-btn">View Details</a>
                    </div>
                </div>
                <div class="bid-card" data-category="processed" data-quantity="100">
                <img src="<?php echo URLROOT;?>/images/images/img12.jpg" alt="Processed Corn">
                    <h3>Processed Corn</h3>
                    <p>Current Bid: LKR 2000</p>
                    <p>Number of Bids: 10</p>
                    <p>Status: Active</p>
                    <p>Specifications: Large, Yellow, Non-Organic</p>                    
                    <p>Quantity: 100 kg</p>
                    <div class="button-row">
                        <a href="<?php echo URLROOT;?>/BuyerController/placeBid" target="content-frame" class="action-btn">Place Bid</a>
                        <a href="<?php echo URLROOT;?>/BuyerController/viewDetails" target="content-frame" class="action-btn">View Details</a>
                    </div>
                </div>
                <div class="bid-card" data-category="dry" data-quantity="75">
                <img src="<?php echo URLROOT;?>/images/images/img9.jpeg" alt="Dry Corn">
                    <h3>Dry Corn</h3>
                    <p>Current Bid: LKR 800</p>
                    <p>Number of Bids: 6</p>
                    <p>Status: Active</p>
                    <p>Specifications: Small, Yellow, Organic</p>                    
                    <p>Quantity: 75 kg</p>
                    <div class="button-row">
                        <a href="<?php echo URLROOT;?>/BuyerController/placeBid" target="content-frame" class="action-btn">Place Bid</a>
                        <a href="<?php echo URLROOT;?>/BuyerController/viewDetails" target="content-frame" class="action-btn">View Details</a>
                    </div>
                </div>             
            </div>
        </div>
    </div>
    <script src="<?php echo URLROOT;?>/js/Buyer/bid product.js"></script>
</body>
</html>