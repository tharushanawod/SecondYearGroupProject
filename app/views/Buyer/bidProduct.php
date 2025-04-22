<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bidding Page</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/BidProduct.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
  

</head>
<body>

<?php require APPROOT . '/views/inc/sidebar.php'; ?>

     
<div class="main-container">
<div class="header-content">
    <h1>Bid On Products</h1>
    <p>Explore our active bids and secure your favorite items at competitive prices.</p>        
</div> 
<div class="filter-container">
    <div class="filter-bar">
        <!-- <div class="filter-section">
            <h4>Category</h4>
            <select id="category">
                <option value="">All Categories</option>
                <option value="sweet">Sweet Corn</option>
                <option value="field">Field Corn</option>
                <option value="organic">Organic Corn</option>
                <option value="popcorn">Popcorn</option>
            </select>
        </div> -->

        <div class="filter-section">
            <h4>Sort By</h4>
            <select id="sortBy">
                <option value="ending_soon">Ending Soon</option>
                <option value="newest">Newest Listings</option>
                <option value="price_low">Price: Low to High</option>
                <option value="price_high">Price: High to Low</option>
                <option value="most_bids">Most Bids</option>
            </select>
        </div>

        <div class="filter-section">
            <h4>Price Range (LKR)</h4>
            <div class="price-range">
                <input type="number" id="minPrice" placeholder="Min">
                <span>-</span>
                <input type="number" id="maxPrice" placeholder="Max">
            </div>
        </div>

        <div class="filter-section">
            <h4>Quantity (kg)</h4>
            <div class="price-range">
                <input type="number" id="minQuantity" placeholder="Min">
                <span>-</span>
                <input type="number" id="maxQuantity" placeholder="Max">
            </div>
        </div>

        <a href="<?php echo URLROOT?>/BuyerController/bidProduct"><button class="reset-filters" id="resetFilters">Reset</button></a>
        <button id="applyFilters">Apply Filters</button>
    </div>
</div>

<div class="active-bids">            
    <h2>Active Bids</h2>
    <div class="bids-grid" id="activeBids">
        <?php foreach ($data as $product): ?>
            <div class="bid-card"  data-quantity="<?php echo $product->quantity; ?>">
                <img src="<?php echo URLROOT.'/'.$product->media;?>" alt="Product Image">
                <div class="bid-status">Active</div>
                <div class="card-content">
                    <h3>Corn</h3>
                    
                    <?php
                    $current_time = new DateTime();
                    $expire_time = new DateTime($product->closing_date);
                    $interval = $current_time->diff($expire_time);
                    $days_left = $interval->format('%d');
                    $time_class = ($days_left < 2) ? 'time-remaining urgent' : 'time-remaining';
                    ?>
                    
                    <div class="<?php echo $time_class; ?>">
                        <i class="fa-solid fa-clock"></i>
                        <span><?php echo $interval->format('%d days, %h hours'); ?> remaining</span>
                    </div>
                    
                    <div class="bid-info">
                        <div class="info-row">
                            <span class="info-label">Starting Price:</span>
                            <span class="info-value">LKR <?php echo $product->starting_price; ?>/kg</span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Current Highest:</span>
                            <span class="info-value highlight">
                                <?php echo isset($product->highest_bid) ? 'LKR '.$product->highest_bid : 'No bids yet'; ?>
                            </span>
                        </div>
                        
                        <div class="info-row">
                            <span class="info-label">Quantity:</span>
                            <span class="info-value"><?php echo $product->quantity; ?> kg</span>
                        </div>
                    </div>
                    
                    <div class="farmer-info">
                        <a href="<?php echo URLROOT;?>/BuyerController/FarmerProfile/<?php echo $product->user_id;?>" class="farmer-link">
                            <i class="fa-solid fa-user"></i> Farmer Profile
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
                    
                    <a href="<?php echo URLROOT;?>/BuyerController/PlaceBid/<?php echo $product->product_id ;?>" class="action-btn">
                        <i class="fa-solid fa-gavel"></i> Place Bid
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>

</div>  

<script>
        const URLROOT = "<?php echo URLROOT; ?>";
        const USERID = "<?php echo $_SESSION['user_id']; ?>";
    </script>

<script src="<?php echo URLROOT;?>/js/Buyer/BidProduct.js"></script>


</body>
</html>
