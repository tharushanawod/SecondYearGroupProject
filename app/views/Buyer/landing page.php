<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bid Landing Page</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/landing page.css">
</head>
<body>
    <?php require 'navbar.php';?>

    <div class="content-wrapper">
        <img src="<?php echo URLROOT;?>/images/images/img39.png" alt="Product Image" class="large-image">
        <div class="container-card">
            <h1>Bid on Premium Corn Products!</h1>
            <p>Fresh from the farm, no hidden fees.</p>
            <a href="<?php echo URLROOT;?>/BuyerController/bidProduct" class="button-link">
                <button class="cta-button">START BIDDING →</button>
            </a>
        </div>
    </div>
    <div class="active-bids">
        <h2>Active Bids</h2>
        <div class="bids-grid" id="activeBids">
            <div class="bid-card">
                <img src="<?php echo URLROOT;?>/images/images/img28.jpg" alt="Product Image">
                <h3>Fresh Corn</h3>
                <p>Current Bid: LKR 1000</p>
                <p>Number of Bids: 5</p>
                <p>Status: Active</p>
                <p>Specifications: Size, Color, Material</p>                
                <p>Buyer: John Doe</p>
                <div class="button-row">
                <a href="<?php echo URLROOT;?>/BuyerController/placeBid"  class="action-btn">Place Bid</a>
                
                </div>
            </div>
            <div class="bid-card">
                <img src="<?php echo URLROOT;?>/images/images/img9.jpeg" alt="Product Image">
                <h3>Dry Corn</h3>
                <p>Current Bid: LKR 1000</p>
                <p>Number of Bids: 5</p>
                <p>Status: Active</p>
                <p>Specifications: Size, Color, Material</p>                
                <p>Buyer: John Doe</p>
                <div class="button-row">
                <a href="<?php echo URLROOT;?>/BuyerController/placeBid"  class="action-btn">Place Bid</a>
                
                </div>
            </div>
            <div class="bid-card">
                <img src="<?php echo URLROOT;?>/images/images/img26.jpg" alt="Product Image">
                <h3>Dry Corn</h3>
                <p>Current Bid: LKR 1000</p>
                <p>Number of Bids: 5</p>
                <p>Status: Active</p>
                <p>Specifications: Size, Color, Material</p>                
                <p>Buyer: John Doe</p>
                <div class="button-row">
                <a href="<?php echo URLROOT;?>/BuyerController/placeBid"  class="action-btn">Place Bid</a>
                
                </div>
            </div>
            <div class="bid-card">
                <img src="<?php echo URLROOT;?>/images/images/img8.jpeg" alt="Product Image">
                <h3>Fresh Corn</h3>
                <p>Current Bid: LKR 1000</p>
                <p>Number of Bids: 5</p>
                <p>Status: Active</p>
                <p>Specifications: Size, Color, Material</p>                
                <p>Buyer: John Doe</p>
                <div class="button-row">
                <a href="<?php echo URLROOT;?>/BuyerController/placeBid" class="action-btn">Place Bid</a>               
                </div>
            </div>
        </div>
    </div>
    <div class="bid-history">
        <h2>Recently Winning Bids</h2>
        <div class="bids-grid" id="bidHistory">
            <div class="bid-card">
                <img src="<?php echo URLROOT;?>/images/images/img28.jpg" alt="Product Image">
                <h3>Fresh Corn</h3>
                <p>Current Bid: LKR 1000</p>
                <p>Number of Bids: 5</p>
                <p>Status: Active</p>
                <p>Specifications: Size, Color, Material</p>                
                <p>Buyer: John Doe</p>
            </div>
            <div class="bid-card">
                <img src="<?php echo URLROOT;?>/images/images/img9.jpeg" alt="Product Image">
                <h3>Dry Corn</h3>
                <p>Current Bid: LKR 1000</p>
                <p>Number of Bids: 5</p>
                <p>Status: Active</p>
                <p>Specifications: Size, Color, Material</p>                
                <p>Buyer: John Doe</p>
            </div>
            <div class="bid-card">
                <img src="<?php echo URLROOT;?>/images/images/img9.jpeg" alt="Product Image">
                <h3>Dry Corn</h3>
                <p>Current Bid: LKR 1000</p>
                <p>Number of Bids: 5</p>
                <p>Status: Active</p>
                <p>Specifications: Size, Color, Material</p>                
                <p>Buyer: John Doe</p>
            </div>
            <div class="bid-card">
                <img src="<?php echo URLROOT;?>/images/images/img8.jpeg" alt="Product Image">
                <h3>Fresh Corn</h3>
                <p>Current Bid: LKR 1000</p>
                <p>Number of Bids: 5</p>
                <p>Status: Active</p>
                <p>Specifications: Size, Color, Material</p>                
                <p>Buyer: John Doe</p>
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
    <div class="feedback">
        <h2>What Our Buyers Say</h2>
        <div class="review-list">
            <div class="review-card">
                <div class="review-content">
                    <div class="rating">★★★★★</div>
                    <p>The farmer was communicative, and the delivery was on time. The corn was well-dried and exactly what I needed for livestock feed.</p>
                    <div class="reviewer">
                        <img src="<?php echo URLROOT;?>/images/images/img69.jpg" alt="Mila Kunis">
                        <p>Bandara Dissanayake</p>
                    </div>
                </div>
            </div>
            <div class="review-card">
                <div class="review-content">
                    <div class="rating">★★★★★</div>
                    <p>The dry corn retained its sweetness and was great for making cornmeal. Highly recommend these farmers for their dedication to quality.</p>
                    <div class="reviewer">
                        <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="Mila Kunis">
                        <p>Samantha Perera</p>
                    </div>
                </div>
            </div>            
            <div class="review-card">
                <div class="review-content">
                    <div class="rating">★★★★★</div>
                    <p>I’ve been buying dry corn for months now, and the quality has been consistent. It's also much cheaper than other farmers.</p>
                    <div class="reviewer">
                        <img src="<?php echo URLROOT;?>/images/images/img68.jpg" alt="Mila Kunis">
                        <p>Niroshan Silva</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <footer>
        <p>&copy; 2024 CornCradle. All rights reserved.</p>
    </footer>
</body>
</html>