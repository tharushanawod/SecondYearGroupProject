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
                <h4>Price Range (LKR per 1Kg)</h4>
                <label>
                    Min: 
                    <input type="number" id="minPrice" min="0" step="50">
                </label>
                <label>
                    Max: 
                    <input type="number" id="maxPrice" min="0" step="50">
                </label>
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
                        <div class="farmer-info">
                            <a href="<?php echo URLROOT;?>/ManufacturerController/FarmerProfile/<?php echo $product->user_id;?>" class="farmer-link">
                            <i class="fa-solid fa-user"></i> View Farmer Profile
                            </a>
                            <div class="rating">
                                <?php
                                $rating = isset($product->avg_rating) ? round((float)$product->avg_rating, 1) : 0;

                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= $rating) {
                                        echo '<i class="fa-solid fa-star"></i>';
                                    } else {
                                        echo '<i class="fa-regular fa-star"></i>';
                                    }
                                }
                                echo ' ('.$rating.')';
                                ?>
                            </div>
                        </div>
                        <p>Starting Price(1Kg): LKR <?php echo $product->starting_price; ?></p>
                        <p>Current Highest Bid: <?php echo isset($product->highest_bid) ? 'LKR'.$product->highest_bid : 'No bids yet'; ?></p>
                        <p>Auction Closes In: <?php
                            $current_time = new DateTime();
                            $expire_time = new DateTime($product->closing_date);
                            $interval = $current_time->diff($expire_time);
                            echo $interval->format('%d days, %h hours, %i minutes');
                        ?></p>
                        <p>Quantity: <?php echo $product->quantity; ?> kg</p>
                        <div class="button-row">
                            <a href="<?php echo URLROOT;?>/ManufacturerController/PlaceBid/<?php echo $product->product_id ;?>" class="action-btn">Place Bid</a>                        
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div> 

</body>
</html>
