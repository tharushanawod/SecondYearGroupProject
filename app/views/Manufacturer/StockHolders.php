<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Holders</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Manufacturer/StockHolders.css">
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="maincontainer">
<h1> Stock Holders (>1000 Kg)</h1>

<!-- Worker Profile Cards -->
<div class="worker-container">
<div class="worker-card">
        <h3>R.M.M.A Rajapaksha</h3>
        <div class="worker-img">
            <img src="<?php echo URLROOT;?>/images/1.jpg" alt="R.M.M.A Rajapaksha">                
        </div>
        <p><b>Location:</b> Negombo</p>
        <p><b>Availability:</b> Available</p>
        <p><b>Email:</b> rajapaksha@example.com</p>
        <p><b>Stock Size:(kg)</b> 3455</p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('R.M.M.A Rajapaksha')"><b>Contact</b></button>
        </div>
    </div>

    <div class="worker-card">
        <h3>G.J.G Ekanayake</h3>
        <div class="worker-img">
            <img src="<?php echo URLROOT;?>/images/2.jpg" alt="G.J.G Ekanayake">                
        </div>
        <p><b>Location:</b> Negombo</p>
        <p><b>Availability:</b> Available</p>
        <p><b>Email:</b> ekanayake@example.com</p>
        <p><b>Stock Size:(kg)</b> 3200</p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('G.J.G Ekanayake')"><b>Contact</b></button>
        </div>
    </div>

    <div class="worker-card">
        <h3>D.B.N Rathnayaka</h3>
        <div class="worker-img">
            <img src="<?php echo URLROOT;?>/images/3.jpg" alt="D.B.N Rathnayaka">                
        </div>
        <p><b>Location:</b> Negombo</p>
        <p><b>Availability:</b> Available</p>
        <p><b>Email:</b> rathnayaka@example.com</p>
        <p><b>Stock Size:(kg)</b> 2750</p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('D.B.N Rathnayaka')"><b>Contact</b></button>
        </div>
    </div>

    <div class="worker-card">
        <h3>F.H.N Dasanayaka</h3>
        <div class="worker-img">
            <img src="<?php echo URLROOT;?>/images/4.jpg" alt="F.H.N Dasanayaka">                
        </div>
        <p><b>Location:</b> Negombo</p>
        <p><b>Availability:</b> Available</p>
        <p><b>Email:</b> dasanayaka@example.com</p>
        <p><b>Stock Size:(kg)</b> 3050</p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('F.H.N Dasanayaka')"><b>Contact</b></button>
        </div>
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