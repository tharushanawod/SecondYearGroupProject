<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cancel Bid</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/cancel bid.css">
</head>
<body>
    
<?php require APPROOT . '/views/inc/sidebar.php'; ?>

    <div class="header-content">
        <h1>Bid Control</h1>        
    </div>    

    <div class="container">
        <div class="product-card">
            <img src="<?php echo URLROOT;?>/images/images/img26.jpg" alt="Product Image" class="product-img">
            <div class="product-details">
                <h3>Dry Corn</h3>
                <p>Current Bid: LKR 1000</p>
                <p>Current Highest Bid: LKR 1000</p>
                <p>Number of Bids: 5</p>
                <p>Status: Active</p>
                <p>Remaining time: 2 days</p>                    
                <p>Quantity: 100 kg</p>
                <button class="cancel-btn" onclick="showCancelReason()">Cancel Bid</button>
                <a href="<?php echo URLROOT;?>/BuyerController/placeBid">
                <button class="adjust-btn">Adjust Bid</button>
                </a>
            </div>
        </div> 
        <div class="product-card">
            <img src="<?php echo URLROOT;?>/images/images/img7.jpeg" alt="Product Image" class="product-img">
            <div class="product-details">
                <h3>Fresh Corn</h3>
                <p>Current Bid: LKR 1000</p>
                <p>Current Highest Bid: LKR 1000</p>
                <p>Number of Bids: 5</p>
                <p>Status: Active</p>
                <p>Remaining time: 2 days</p>                    
                <p>Quantity: 100 kg</p>
                <button class="cancel-btn" onclick="showCancelReason()">Cancel Bid</button>
                <a href="<?php echo URLROOT;?>/BuyerController/placeBid">
                <button class="adjust-btn">Adjust Bid</button>
                </a>
            </div>
        </div> 
        <div class="product-card">
            <img src="<?php echo URLROOT;?>/images/images/img9.jpeg" alt="Product Image" class="product-img">
            <div class="product-details">
                <h3>Dry Corn</h3>
                <p>Current Bid: LKR 1000</p>
                <p>Current Highest Bid: LKR 1000</p>
                <p>Number of Bids: 5</p>
                <p>Status: Active</p>
                <p>Remaining time: 1 day</p>                    
                <p>Quantity: 100 kg</p>                
                <button class="cancel-btn" onclick="showCancelReason()">Cancel Bid</button>
                <a href="<?php echo URLROOT;?>/BuyerController/placeBid">
                <button class="adjust-btn">Adjust Bid</button>
                </a>
            </div>
        </div>            
    </div>

    
    <div id="cancelModal" class="modal" style="display:none;">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <h2>Cancel Bid</h2>
            <p>Are you sure you want to cancel this bid? This action cannot be undone.</p>
            <label for="reason">Reason For Cancellation</label>
            <select id="reason">
                <option value="">Select a Reason</option>
                <option value="reason1">Entered Incorrect Bid Amount</option>
                <option value="reason2">No Longer Interested in the Product</option>
                <option value="reason3">Accidental Bid Placement</option>
            </select>
            <button class="cancel-btn" onclick="confirmCancel()">Confirm Cancel</button>                        
        </div>
    </div>

    <script>
    function showCancelReason() {
        document.getElementById('cancelModal').style.display = 'block';
    }

    function closeModal() {
        document.getElementById('cancelModal').style.display = 'none';
    }

    function confirmCancel() {        
        alert('Bid has been cancelled.');
        closeModal();
    }
    </script>    
</body>
</html>