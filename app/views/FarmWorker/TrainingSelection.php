<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Selection</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/FarmWorker/TrainingSelection.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
    
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
<div class="container">
    <div class="header">
        <h1>Available Training Programs</h1>
        <p>Enhance your skills with our curated training programs</p>
    </div>
    
    <div class="training-container">
        <div class="training-card">
            <div class="card-image">
                <img src="<?php echo URLROOT;?>/images/worker/1.png" alt="Training Image">
            </div>
            <div class="card-content">
                <h3>Dpt. of Agriculture Training</h3>
                <div class="card-details">
                    <div class="detail-item">
                        <i class="fas fa-clock"></i>
                        <span>Flexible Duration</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-certificate"></i>
                        <span>Government Certified</span>
                    </div>
                </div>
                <a href="https://doa.gov.lk/edu-training_main/" target="_blank" class="select-btn">
                    <i class="fas fa-external-link-alt"></i>
                    Explore Program
                </a>
            </div>
        </div>

        <div class="training-card">
            <div class="card-image">
                <img src="<?php echo URLROOT;?>/images/images/img72.jpg" alt="Training Image">
            </div>
            <div class="card-content">
                <h3> Smart Farmer Training</h3>
                <div class="card-details">
                    <div class="detail-item">
                        <i class="fas fa-clock"></i>
                        <span>6 Weeks Program</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-certificate"></i>
                        <span>Industry Recognized</span>
                    </div>
                </div>
                <a href="https://csiap.lk/farmer_training_school" target="_blank" class="select-btn">
                    <i class="fas fa-external-link-alt"></i>
                    Explore Program
                </a>
            </div>
        </div>

        <div class="training-card">
            <div class="card-image">
                <img src="<?php echo URLROOT;?>/images/images/img73.jpg" alt="Training Image">
            </div>
            <div class="card-content">
                <h3>Hayleys Agriculture Training</h3>
                <div class="card-details">
                    <div class="detail-item">
                        <i class="fas fa-clock"></i>
                        <span>8 Weeks Program</span>
                    </div>
                    <div class="detail-item">
                        <i class="fas fa-certificate"></i>
                        <span>Corporate Certified</span>
                    </div>
                </div>
                <a href="https://www.hayleysagriculture.com/education/" target="_blank" class="select-btn">
                    <i class="fas fa-external-link-alt"></i>
                    Explore Program
                </a>
            </div>
        </div>
    </div>
</div>
</body>
</html>