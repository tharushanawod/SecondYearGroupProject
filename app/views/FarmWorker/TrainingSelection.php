<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Training Selection</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/FarmWorker/trainingSelection.css">
</head>
<body>
<?php require 'sidebar.php'; ?>
    <div class="training-container">
        <h2>Available Training Programs</h2>
        <div class="training">
            <h3>Program Title: Organic Farming Basics</h3>
            <p><strong>Description:</strong> Learn the basics of organic farming, including soil preparation, planting, and pest control.</p>
            <button class="select-btn">Select</button>
        </div>
        <div class="training">
            <h3>Program Title: Advanced Irrigation Techniques</h3>
            <p><strong>Description:</strong> Master advanced irrigation techniques to optimize water usage and improve crop yields.</p>
            <button class="select-btn">Select</button>
        </div>
        <!-- Repeat the above block for each training program -->
    </div>
</body>
</html>