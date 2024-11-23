<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holders</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Manufacturer/StockHolders.css">
</head>
<body>
<?php require 'sidebar.php';?>

<div class="maincontainer">
<h1> Stock Holders (>1000 Kg)</h1>

<!-- Worker Profile Cards -->
<div class="worker-container">
    <div class="worker-card">
        <h3>John Doe</h3>
        <div class="worker-img">
            <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="John Doe">                
        </div>
        <p><b>Location:</b> Negombo</p>
        <p><b>Availability:</b> Available</p>
        <p><b>Email:</b> johndoe@example.com</p>
        <p><b>Stock Size:(kg)</b> 3455</p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('John Doe')"><b>Contact</b></button>
        </div>
    </div>

    <div class="worker-card">
        <h3>John Doe</h3>
        <div class="worker-img">
            <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="John Doe">                
        </div>
        <p><b>Location:</b> Negombo</p>
        <p><b>Availability:</b> Available</p>
        <p><b>Email:</b> johndoe@example.com</p>
        <p><b>Stock Size:(kg)</b> 3455</p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('John Doe')"><b>Contact</b></button>
        </div>
    </div>


    <div class="worker-card">
        <h3>John Doe</h3>
        <div class="worker-img">
            <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="John Doe">                
        </div>
        <p><b>Location:</b> Negombo</p>
        <p><b>Availability:</b> Available</p>
        <p><b>Email:</b> johndoe@example.com</p>
        <p><b>Stock Size:(kg)</b> 3455</p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('John Doe')"><b>Contact</b></button>
        </div>
    </div>


    <div class="worker-card">
        <h3>John Doe</h3>
        <div class="worker-img">
            <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="John Doe">                
        </div>
        <p><b>Location:</b> Negombo</p>
        <p><b>Availability:</b> Available</p>
        <p><b>Email:</b> johndoe@example.com</p>
        <p><b>Stock Size:(kg)</b> 3455</p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('John Doe')"><b>Contact</b></button>
        </div>
    </div>

    
   
    </div>
</div>

</div>

   

   
    <div id="hireModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('hireModal')">&times;</span>
            <h3>Contact</h3>
            <p id="workerName"></p>
             <p>0771346754</p>
            <button onclick="cancelHire()"><b>Cancel</b></button>
        </div>
    </div>
   
    <script src="<?php echo URLROOT;?>/js/Manufacturer/Contact.js"></script>
</body>
</html>