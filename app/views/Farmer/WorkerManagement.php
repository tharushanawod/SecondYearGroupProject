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
        <h3>Kasun Perera</h3>
        <div class="worker-img">
            <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="Kasun Perera">                
        </div>
        <p><b>Skills:</b> Harvesting, Irrigation</p>
        <p><b>Availability:</b> Available</p>
        <p><b>Email:</b> kasun.perera@example.com</p>
        <p><b>Address:</b>Anuradhapura</p>
        <p><b>Phone Number:</b> 071 7456732</p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('Kasun Perera')"><b>Hire</b></button>
            <button class="rate-btn" onclick="openRatingModal('Kasun Perera')"><b>Rate & Feedback</b></button>
        </div>
    </div>

    <div class="worker-card">
        <h3>Nimal Fernando</h3>
        <div class="worker-img">
            <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="Nimal Fernando">                
        </div>
        <p><b>Skills:</b> Fertilizing, Plowing</p>
        <p><b>Availability:</b> Busy</p>
        <p><b>Email:</b> nimal.fernando@example.com</p>
        <p><b>Address:</b>Anuradhapura</p>
        <p><b>Phone Number:</b> 077 8425613</p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('Nimal Fernando')"><b>Hire</b></button>
            <button class="rate-btn" onclick="openRatingModal('Nimal Fernando')"><b>Rate & Feedback</b></button>
        </div>
    </div>

    <div class="worker-card">
        <h3>Sarath Wijesinghe</h3>
        <div class="worker-img">
        <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="Sarath Wijesinghe">
        </div>
        <p><b>Skills:</b> Planting, Weeding</p>
        <p><b>Availability:</b> Available</p>
        <p><b>Email:</b> wijesinghe@example.com</p>
        <p><b>Address:</b>Anuradhapura</p>
        <p><b>Phone Number:</b> 070 9453821</p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('Sarath Wijesinghe')"><b>Hire</b></button>
            <button class="rate-btn" onclick="openRatingModal('Sarath Wijesinghe')"><b>Rate & Feedback</b></button>
        </div>
    </div>

    <div class="worker-card">
        <h3>Silva</h3>
        <div class="worker-img">
        <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="Chamari Silva">                
        </div>
        <p><b>Skills:</b> Pruning, Harvesting</p>
        <p><b>Availability:</b> Available</p>
        <p><b>Email:</b> silva@example.com</p>
        <p><b>Address:</b>Anuradhapura</p>
        <p><b>Phone Number:</b> 078 3546729</p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('Chamari Silva')"><b>Hire</b></button>
            <button class="rate-btn" onclick="openRatingModal('Chamari Silva')"><b>Rate & Feedback</b></button>
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
