<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bid Landing Page</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/landing page.css">
</head>
<body>
    <?php require 'header.php';?>

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
                <a href="<?php echo URLROOT;?>/BuyerController/placeBid" target="content-frame" class="action-btn">Place Bid</a>
                <a href="<?php echo URLROOT;?>/BuyerController/viewDetails" target="content-frame" class="action-btn">View Details</a>
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
                <a href="<?php echo URLROOT;?>/BuyerController/placeBid" target="content-frame" class="action-btn">Place Bid</a>
                <a href="<?php echo URLROOT;?>/BuyerController/viewDetails" target="content-frame" class="action-btn">View Details</a>
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
                <a href="<?php echo URLROOT;?>/BuyerController/placeBid" target="content-frame" class="action-btn">Place Bid</a>
                <a href="<?php echo URLROOT;?>/BuyerController/viewDetails" target="content-frame" class="action-btn">View Details</a>
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
                <a href="<?php echo URLROOT;?>/BuyerController/placeBid" target="content-frame" class="action-btn">Place Bid</a>
                <a href="<?php echo URLROOT;?>/BuyerController/viewDetails" target="content-frame" class="action-btn">View Details</a>
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
                <h3>Company A</h3>
                <p>Product: Corn</p>
                <p>Rate: LKR 1200</p>
            </div>
            <div class="rate-card">
                <img src="<?php echo URLROOT;?>/images/images/img66.png" alt="Company Logo">
                <h3>Company B</h3>
                <p>Product: Corn</p>
                <p>Rate: LKR 1150</p>
            </div>
            <div class="rate-card">
                <img src="<?php echo URLROOT;?>/images/images/img67.jpeg" alt="Company Logo">
                <h3>Company C</h3>
                <p>Product: Corn</p>
                <p>Rate: LKR 1180</p>
            </div>
            <div class="rate-card">
                <img src="<?php echo URLROOT;?>/images/images/img65.png" alt="Company Logo">
                <h3>Company D</h3>
                <p>Product: Corn</p>
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
                    <p>Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
                    <div class="reviewer">
                        <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="Mila Kunis">
                        <p>Mila Kunis</p>
                    </div>
                </div>
            </div>
            <div class="review-card">
                <div class="review-content">
                    <div class="rating">★★★★★</div>
                    <p>Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
                    <div class="reviewer">
                        <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="Mila Kunis">
                        <p>Mila Kunis</p>
                    </div>
                </div>
            </div>            
            <div class="review-card">
                <div class="review-content">
                    <div class="rating">★★★★★</div>
                    <p>Click edit button to change this text. Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut elit tellus, luctus nec ullamcorper mattis, pulvinar dapibus leo.</p>
                    <div class="reviewer">
                        <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="Mila Kunis">
                        <p>Mila Kunis</p>
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