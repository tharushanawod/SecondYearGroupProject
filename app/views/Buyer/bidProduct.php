<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bidding Page</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/bidProduct.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
    <style>
        @import url(../components/sidebar.css);
*{
    font-family: sans-serif;
    margin: 0;
    padding: 0;
    box-sizing: border-box;
}
body {
   
    background-color:#f4f4f4;
    background-size: cover;
    background-position: center;
   
}

.header-content {
    align-items: center;    
    color: #034616;
    padding: 10px 20px;
}

.header-content h1 {
    margin-top: 30px;
    margin-left: 700px;
    font-size: 55px;
    text-shadow: 2px 2px 4px #78bb80;
}

.header-content p {
    margin-left: 680px;
    font-size: 20px;
}

.main-content {
    flex: 1;
    display: flex;
    flex-direction: column;
    margin: 20px;
}

.filter-bar {
    display: flex;
    align-items: flex-end;
    justify-content: center;
    gap: 75px;
    background-color: #ecf7f0;
    padding: 16px 24px;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    margin: 0 auto 20px;
    width: 72%;
    margin-left:340px;
}

.filter-section {    
    margin-left: 30px;
}

.filter-section h4 {
    margin: 0;
    font-size: 14px;
    font-weight: 600;
    color: #333;
    margin-bottom: 10px;
}

.filter-section select {
    padding: 8px 12px;
    border-radius: 4px;
    border: 1px solid #ccc;
    background-color: white;
    width: 200px;
    font-size: 14px;
}

.filter-section label {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 14px;    
}

.filter-section input[type="number"] {
    padding: 8px 12px;
    border-radius: 4px;
    border: 1px solid #ccc;
    width: 120px;
    font-size: 14px;
}

#applyFilters {
    padding: 8px 20px;
    background-color: #4CAF50;
    color: white;
    border: none;
    border-radius: 6px;
    cursor: pointer;
    font-size: 14px;
    font-weight: 500;
    height: 36px;
    margin-right: 15px;
}

#applyFilters:hover {
    background-color: #45a049;
}

.active-bids {    
    background-color: #ffffff;
    padding: 40px;    
    width:76%;
    margin-left:300px;

}

.active-bids h2 {
    text-align: center;
    font-size: 45px;
    color: #225428;
    margin-bottom: 30px;
    text-shadow: 2px 2px 4px #78bb80;
}

.bids-grid {
    display: grid;    
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
}

.bid-card {
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 4px #a5d0b0;
    padding: 15px;
    height: auto;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    transition: transform 0.2s;
}

.bid-card h3 {    
    text-align: center;
}

.bid-card:hover {
    transform: translateY(-5px);
}

.bid-card img {
    width: 100%;
    height: 150px;
    object-fit: cover;
    border-radius: 10px;
    margin-bottom: 10px;
}

.bid-card h3 {
    font-size: 18px;
    margin: 0 0 10px;
}

.bid-card p {
    margin: 5px 0;
    font-size: 14px;
}

.action-btn {
    padding: 10px;
    background-color: #299233;
    color: white;    
    border-radius: 5px;
    cursor: pointer;
    text-align: center;
    text-decoration: none;
    font-size: 14px;
    flex: 1;
    margin: 5px;    
}

.action-btn:hover {
    background-color: #5b9162;
}

.button-row {
    display: flex;
    justify-content: space-between;
    gap: 10px;
}

.modal {
    display: none;
    position: fixed;    
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    width: 50%;
    height: auto;
    background-color: #fff;
    border-radius: 10px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    z-index: 1000;
}

.modal-content {
    background-color: #bcc2bc;
    border-radius: 10px;
    padding: 20px;
    box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
}

.modal-content .close {
    color: #000000;
    float: right;
    font-size: 28px;
    font-weight: bold;
    cursor: pointer;
}

.modal-content h2 {
    font-size: 24px;
    color: #000000;
    margin-bottom: 10px;
}

.modal-content p {
    font-size: 16px;
    color: #000000;
    margin-bottom: 20px;
}

.modal-content input[type="number"] {
    padding: 10px;
    width: 300px;
    border: 1px solid #f5f6e8;
    border-radius: 5px;
    margin-right: 10px;
    margin-bottom: 20px;
}

.modal-content .submit-btn {
    padding: 10px 20px;
    border: none;
    border-radius: 5px;    
    color: white;
    cursor: pointer;
    font-size: 16px;
    margin-top: 10px;
    background-color: #1a4f2c;
}

.modal-content .submit-btn:hover {
    background-color: #174b25;
}

@media (max-width: 768px) {
    .filter-bar {
        flex-direction: column;
        align-items: stretch;
    }

    .bids-grid {
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
    }
}

@media (max-width: 480px) {
    .bids-grid {
        grid-template-columns: 1fr;
    }
}

.farmer-info {
    margin: 10px 0;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    gap: 5px;
}

.farmer-link {
    color: #299233;
    text-decoration: none;
    font-size: 14px;
    display: flex;
    align-items: center;
    gap: 5px;
}

.farmer-link:hover {
    color: #5b9162;
}

.rating {
    color: #ffd700;
    font-size: 16px;
}

    </style>
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
                            <a href="<?php echo URLROOT;?>/BuyerController/FarmerProfile/<?php echo $product->user_id;?>" class="farmer-link">
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
                            <a href="<?php echo URLROOT;?>/BuyerController/PlaceBid/<?php echo $product->product_id ;?>" class="action-btn">Place Bid</a>                        
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div> 
    
    
    <script>

    </script>
</body>
</html>
