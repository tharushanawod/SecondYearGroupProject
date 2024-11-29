<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/WorkerManagement.css">
</head>
<body>
 
<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="maincontainer">
<h1> Farm Workers</h1>

<!-- Worker Profile Cards -->
<div class="worker-container">
    <div class="worker-card">
        <h3>John Doe</h3>
        <div class="worker-img">
            <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="John Doe">                
        </div>
        <p><b>Skills:</b> Harvesting, Irrigation</p>
        <p><b>Availability:</b> Available</p>
        <p><b>Email:</b> johndoe@example.com</p>
        <p><b>Phone Number:</b> 071 7456732</p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('John Doe')"><b>Hire</b></button>
            <button class="rate-btn" onclick="openRatingModal('John Doe')"><b>Rate & Feedback</b></button>
        </div>
    </div>

    <div class="worker-card">
        <h3>Jane Smith</h3>
        <div class="worker-img">
            <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="Jane Smith">                
        </div>
        <p><b>Skills:</b> Fertilizing, Plowing</p>
        <p><b>Availability:</b> Busy</p>
        <p><b>Email:</b> johndoe@example.com</p>
        <p><b>Phone Number:</b> 071 7456732</p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('Jane Smith')"><b>Hire</b></button>
            <button class="rate-btn" onclick="openRatingModal('Jane Smith')"><b>Rate & Feedback</b></button>
        </div>
    </div>

    <div class="worker-card">
        <h3>Mike Johnson</h3>
        <div class="worker-img">
        <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="Jane Smith">
        </div>
        <p><b>Skills:</b> Planting, Weeding</p>
        <p><b>Availability:</b> Available</p>
        <p><b>Email:</b> johndoe@example.com</p>
        <p><b>Phone Number:</b> 071 7456732</p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('Mike Johnson')"><b>Hire</b></button>
            <button class="rate-btn" onclick="openRatingModal('Mike Johnson')"><b>Rate & Feedback</b></button>
        </div>
    </div>

    <div class="worker-card">
        <h3>Emily Davis</h3>
        <div class="worker-img">
        <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="Emily Davis">                
        </div>
        <p><b>Skills:</b> Pruning, Harvesting</p>
        <p><b>Availability:</b> Available</p>
        <p><b>Email:</b> johndoe@example.com</p>
        <p><b>Phone Number:</b> 071 7456732</p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('Emily Davis')"><b>Hire</b></button>
            <button class="rate-btn" onclick="openRatingModal('Emily Davis')"><b>Rate & Feedback</b></button>
        </div>
    </div>
    
    <div class="worker-card">
        <h3>Mike Johnson</h3>
        <div class="worker-img">
        <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="Mike Johnson">
        </div>
        <p><b>Skills:</b> Planting, Weeding</p>
        <p><b>Availability:</b> Available</p>
        <p><b>Email:</b> johndoe@example.com</p>
        <p><b>Phone Number:</b> 071 7456732</p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('Mike Johnson')"><b>Hire</b></button>
            <button class="rate-btn" onclick="openRatingModal('Mike Johnson')"><b>Rate & Feedback</b></button>
        </div>
    </div>

    <div class="worker-card">
        <h3>Mike Johnson</h3>
        <div class="worker-img">
        <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="Mike Johnson">
        </div>
        <p><b>Skills:</b> Planting, Weeding</p>
        <p><b>Availability:</b> Available</p>
        <p><b>Email:</b> johndoe@example.com</p>
        <p><b>Phone Number:</b> 071 7456732</p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('Mike Johnson')"><b>Hire</b></button>
            <button class="rate-btn" onclick="openRatingModal('Mike Johnson')"><b>Rate & Feedback</b></button>
        </div>
    </div>

    <div class="worker-card">
        <h3>Jane Smith</h3>
        <div class="worker-img">
        <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="Jane Smith">
        </div>
        <p><b>Skills:</b> Fertilizing, Plowing</p>
        <p><b>Availability:</b> Busy</p>
        <p><b>Email:</b> johndoe@example.com</p>
        <p><b>Phone Number:</b> 071 7456732</p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('Jane Smith')"><b>Hire</b></button>
            <button class="rate-btn" onclick="openRatingModal('Jane Smith')"><b>Rate & Feedback</b></button>
        </div>
    </div>
</div>

</div>

   

    <!-- Hire Modal -->
    <div id="hireModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('hireModal')">&times;</span>
            <h3>Hire Worker</h3>
            <p id="workerName"></p>
            <label for="task">Task:</label>
            <input type="text" id="task" placeholder="Task Details">
            <label for="duration">Duration:</label>
            <input type="text" id="duration" placeholder="e.g: 2 days">
            <button onclick="submitHire()"><b>Submit</b></button>
            <button onclick="cancelHire()"><b>Cancel</b></button>
        </div>
    </div>

    <!-- Rating & Feedback Modal -->
    <div id="ratingModal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal('ratingModal')">&times;</span>
            <h3>Rate & Feedback</h3>
            <p id="ratingWorkerName"></p>
            <label>Rating:</label>
            <div class="star-rating">
                <span onclick="rateWorker(1)">★</span>
                <span onclick="rateWorker(2)">★</span>
                <span onclick="rateWorker(3)">★</span>
                <span onclick="rateWorker(4)">★</span>
                <span onclick="rateWorker(5)">★</span>
            </div>
            <label for="feedback">Feedback:</label>
            <textarea id="feedback" placeholder="Write your feedback here..."></textarea>
            <button onclick="submitRating()"><b>Submit</b></button>
            <button onclick="cancelRating()"><b>Cancel</b></button>
        </div>
    </div>
    <script src="<?php echo URLROOT;?>/js/Farmer/Orders Management.js"></script>
    <script src="<?php echo URLROOT;?>/js/Farmer/Worker Management.js"></script>
</body>
</html>