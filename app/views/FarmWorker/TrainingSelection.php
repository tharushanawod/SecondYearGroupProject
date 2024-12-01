<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Selection</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/FarmWorker/TrainingSelection.css">
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
<div class="container">
<h2>Available Training Programs</h2>
    <div class="training-container">        
        <div class="training">
            <img src="<?php echo URLROOT;?>/images/worker/1.png" alt="Training Image">
            <h3>Dpt. of Agriculture Training</h3>
          
            <a href="https://doa.gov.lk/edu-training_main/" target="_blank"><button class="select-btn">Explore ...</button></a>
        </div>
        <div class="training">
            <img src="<?php echo URLROOT;?>/images/images/img72.jpg" alt="Training Image">
            <h3>Climate Smart Farmer Training</h3>
            <a href="https://csiap.lk/farmer_training_school" target="_blank"><button class="select-btn">Explore ...</button></a>
            
        </div>
        <div class="training">
            <img src="<?php echo URLROOT;?>/images/images/img73.jpg" alt="Training Image">
            <h3>Hayleys Agriculture Training</h3>
            <a href="https://www.hayleysagriculture.com/education/" target="_blank"><button class="select-btn">Explore ...</button></a>
       
        </div>
    </div>
</div>
  
</body>
</html>