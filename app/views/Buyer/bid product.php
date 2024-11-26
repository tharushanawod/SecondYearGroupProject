<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bidding Page</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/bid product.css">
</head>
<body>

<?php require 'sidebar.php';?>

    <div class="header-content">
        <h1>Bid On Products</h1>
        <p>Explore our active bids and secure your favorite items.</p>        
    </div>        
    
    <div class="main-content">
            <div class="filter-bar">                
                <div class="filter-section">
                    <h4 id="category-label">Category</h4>
                    <select name="category" aria-labelledby="category-label">
                        <option value="fresh">Fresh</option>
                        <option value="dry">Dry</option>                        
                    </select>
                </div>
                <div class="filter-section">
                    <h4>Quantity</h4>                    
                        <label>
                            Min: 
                            <input type="number" id="minQuantity" min="0" step="10">
                        </label>
                        <label>
                            Max: 
                            <input type="number" id="maxQuantity" min="0" step="10">
                        </label>
                    
                </div>            
                <button id="applyFilters">Apply Filters</button>
           </div>
        <div class="active-bids">            
            <div class="bids-grid" id="activeBids">
                <div class="bid-card" data-category="fresh" data-quantity="200">
                <img src="<?php echo URLROOT;?>/images/images/img22.jpg" alt="Fresh Corn">
                    <h3>Fresh Corn</h3>
                    <p>Current Bid: LKR 800</p>
                    <p>Current Highest Bid: LKR 1500</p>                    
                    <p>Number of Bids: 8</p>
                    <p>Status: Active</p>
                    <p>Remaining time: 1 day</p>
                    <p>Quantity: 200 kg</p>
                    <div class="button-row">
                       <a href="<?php echo URLROOT;?>/BuyerController/placeBid" class="action-btn">Place Bid</a>                        
                    </div>
                </div>
                <div class="bid-card" data-category="fresh" data-quantity="100">
                <img src="<?php echo URLROOT;?>/images/images/img28.jpg" alt="Fresh Corn">
                    <h3>Fresh Corn</h3>
                    <p>Current Bid: LKR 800</p>
                    <p>Current Highest Bid: LKR 1000</p>
                    <p>Number of Bids: 5</p>
                    <p>Status: Active</p>
                    <p>Remaining time: 1 day</p>                    
                    <p>Quantity: 100 kg</p>
                    <div class="button-row">
                        <a href="<?php echo URLROOT;?>/BuyerController/placeBid"  class="action-btn"><b>Place Bid</b></a>                       
                    </div>
                </div>
                <div class="bid-card" data-category="dry" data-quantity="50">
                <img src="<?php echo URLROOT;?>/images/images/img7.jpeg" alt="Dry Corn">
                    <h3>Dry Corn</h3>
                    <p>Current Bid: LKR 800</p>
                    <p>Current Highest Bid: LKR 500</p>
                    <p>Number of Bids: 3</p>
                    <p>Status: Active</p>
                    <p>Remaining time: 1 day</p>                    
                    <p>Quantity: 50 kg</p>
                    <div class="button-row">
                        <a href="<?php echo URLROOT;?>/BuyerController/placeBid" class="action-btn"><b>Place Bid</b></a>                       
                    </div>
                </div>
                <div class="bid-card" data-category="processed" data-quantity="200">
                <img src="<?php echo URLROOT;?>/images/images/img9.jpeg" alt="Processed Corn">                    
                    <h3>Dry Corn</h3>
                    <p>Current Bid: LKR 800</p>
                    <p>Current Highest Bid: LKR 1500</p>
                    <p>Number of Bids: 7</p>
                    <p>Status: Active</p>
                    <p>Remaining time: 1 day</p>                    
                    <p>Quantity: 200 kg</p>
                    <div class="button-row">
                        <a href="<?php echo URLROOT;?>/BuyerController/placeBid"class="action-btn"><b>Place Bid</b></a>                        
                    </div>
                </div>
                <div class="bid-card" data-category="fresh" data-quantity="150">
                <img src="<?php echo URLROOT;?>/images/images/img8.jpeg" alt="Processed Corn">
                    <h3>Fresh Corn</h3>
                    <p>Current Bid: LKR 800</p>
                    <p>Current Highest Bid: LKR 1200</p>
                    <p>Number of Bids: 4</p>
                    <p>Status: Active</p>
                    <p>Remaining time: 1 day</p>                    
                    <p>Quantity: 150 kg</p>
                    <div class="button-row">
                        <a href="<?php echo URLROOT;?>/BuyerController/placeBid" class="action-btn"><b>Place Bid</b></a>                        
                    </div>
                </div>
                <div class="bid-card" data-category="processed" data-quantity="100">
                <img src="<?php echo URLROOT;?>/images/images/img12.jpg" alt="Processed Corn">
                    <h3>Dry Corn</h3>
                    <p>Current Bid: LKR 800</p>
                    <p>Current Highest Bid: LKR 2000</p>
                    <p>Number of Bids: 10</p>
                    <p>Status: Active</p>
                    <p>Remaining time: 1 day</p>                    
                    <p>Quantity: 100 kg</p>
                    <div class="button-row">
                        <a href="<?php echo URLROOT;?>/BuyerController/placeBid"  class="action-btn"><b>Place Bid</b></a>                       
                    </div>
                </div>
                <div class="bid-card" data-category="dry" data-quantity="75">
                <img src="<?php echo URLROOT;?>/images/images/img9.jpeg" alt="Dry Corn">
                    <h3>Dry Corn</h3>
                    <p>Current Bid: LKR 800</p>
                    <p>Current Highest Bid: LKR 1000</p>
                    <p>Number of Bids: 6</p>
                    <p>Status: Active</p>
                    <p>Remaining time: 1 day</p>                    
                    <p>Quantity: 75 kg</p>
                    <div class="button-row">
                        <a href="<?php echo URLROOT;?>/BuyerController/placeBid"  class="action-btn"><b>Place Bid</b></a>                       
                    </div>
                </div>             
            </div>
        </div>
    </div> 
    
    <div id="bidModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Place Your Bid</h2>
            <p id="modalProduct">Dry Corn</p>
            <p id="modalCurrentBid">LKR 1000</p>
            <p id="yourBid">Your Bid: LKR 800</p>
            <p>You are about to bid on this product. Make sure to place a bid higher than the current bid to increase your chances of winning.</p>
            <input type="number" id="newBid" placeholder="Enter your bid">
            <button class="submit-btn" onclick="placeBid()">Place Bid</button>
        </div>
    </div>
    <script src="<?php echo URLROOT;?>/js/Buyer/bid product.js"></script> 
</body>
</html>