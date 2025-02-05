<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bidding Page</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/bidProduct.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>

<?php require APPROOT . '/views/inc/sidebar.php'; ?>

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
                <?php foreach ($data as $product): ?>
                    <div class="bid-card" data-category="<?php echo $product->category; ?>" data-quantity="<?php echo $product->quantity; ?>">
                        <img src="<?php echo URLROOT.'/'.$product->media;?>" alt="Product Image">
                        <h3><?php echo $product->name; ?></h3>
                        <p>Starting Price(1Kg): LKR <?php echo $product->starting_price; ?></p>
                        <p>Current Highest Bid: LKR <?php echo $product->highest_bid; ?></p>
                        <p>Auction Closes In: <?php
                            $current_time = new DateTime();
                            $expire_time = new DateTime($product->closing_date);
                            $interval = $current_time->diff($expire_time);
                            echo $interval->format('%d days, %h hours, %i minutes');
                        ?></p>
                        <p>Quantity: <?php echo $product->quantity; ?> kg</p>
                        <div class="button-row">
                            <a href="<?php echo URLROOT;?>/BuyerController/placeBid" class="action-btn">Place Bid</a>                        
                        </div>
                    </div>
                <?php endforeach; ?>
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
