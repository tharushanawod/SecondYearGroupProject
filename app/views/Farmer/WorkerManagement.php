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
            <img src="<?php echo URLROOT;?>/images/1.jpg" alt="Kasun Perera">                
        </div>
        <p><b>Skills:</b> Harvesting, Irrigation</p>
        <p><b>Availability:</b> Available</p>
        <p><b>Address:</b> No.123 Main Street, Colombo</p>
        <p><b>Phone Number:</b> 077 7456732</p>
        <p><b>Charging Rate(Day):</b> Rs.2500 </p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('Kasun Perera')"><b>Hire</b></button>
            <button class="rate-btn" onclick="openRatingModal('Kasun Perera')"><b>Rate & Feedback</b></button>
        </div>
    </div>

    <div class="worker-card">
        <h3>Shanika Silva</h3>
        <div class="worker-img">
            <img src="<?php echo URLROOT;?>/images/2.jpg" alt="Shanika Silva">                
        </div>
        <p><b>Skills:</b> Fertilizing, Plowing</p>
        <p><b>Availability:</b> Busy</p>
        <p><b>Address:</b> No.456 Galle Road, Galle</p>
        <p><b>Phone Number:</b> 071 8123456</p>
        <p><b>Charging Rate(Day):</b> Rs.2500 </p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('Shanika Silva')"><b>Hire</b></button>
            <button class="rate-btn" onclick="openRatingModal('Shanika Silva')"><b>Rate & Feedback</b></button>
        </div>
    </div>

    <div class="worker-card">
        <h3>Ruwan Fernando</h3>
        <div class="worker-img">
        <img src="<?php echo URLROOT;?>/images/3.jpg" alt="Ruwan Fernando">
        </div>
        <p><b>Skills:</b> Planting, Weeding</p>
        <p><b>Availability:</b> Available</p>
        <p><b>Address:</b> No.789 Kandy Road, Kandy</p>
        <p><b>Phone Number:</b> 076 9876543</p>
        <p><b>Charging Rate(Day):</b> Rs.2500 </p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('Ruwan Fernando')"><b>Hire</b></button>
            <button class="rate-btn" onclick="openRatingModal('Ruwan Fernando')"><b>Rate & Feedback</b></button>
        </div>
    </div>

    <div class="worker-card">
        <h3>Chandima Wijesinghe</h3>
        <div class="worker-img">
        <img src="<?php echo URLROOT;?>/images/4.jpg" alt="Chandima Wijesinghe">                
        </div>
        <p><b>Skills:</b> Pruning, Harvesting</p>
        <p><b>Availability:</b> Available</p>
        <p><b>Address:</b> No.101 Matara Road, Matara</p>
        <p><b>Phone Number:</b> 078 1234567</p>
        <p><b>Charging Rate(Day):</b> Rs.2500 </p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('Chandima Wijesinghe')"><b>Hire</b></button>
            <button class="rate-btn" onclick="openRatingModal('Chandima Wijesinghe')"><b>Rate & Feedback</b></button>
        </div>
    </div>
    
    <div class="worker-card">
        <h3>Sunil Perera</h3>
        <div class="worker-img">
        <img src="<?php echo URLROOT;?>/images/images/img69.jpg" alt="Sunil Perera">
        </div>
        <p><b>Skills:</b> Planting, Weeding</p>
        <p><b>Availability:</b> Available</p>
        <p><b>Address:</b> No.302 Anuradhapura Road, Anuradhapura</p>
        <p><b>Phone Number:</b> 072 1239876</p>
        <p><b>Charging Rate(Day):</b> Rs.2500 </p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('Sunil Perera')"><b>Hire</b></button>
            <button class="rate-btn" onclick="openRatingModal('Sunil Perera')"><b>Rate & Feedback</b></button>
        </div>
    </div>

    <div class="worker-card">
        <h3>Vimukthi Senanayake</h3>
        <div class="worker-img">
        <img src="<?php echo URLROOT;?>/images/images/img68.jpg" alt="Vimukthi Senanayake">
        </div>
        <p><b>Skills:</b> Fertilizing, Plowing</p>
        <p><b>Availability:</b> Busy</p>
        <p><b>Address:</b> No.505 Jaffna Road, Jaffna</p>
        <p><b>Phone Number:</b> 074 3456789</p>
        <p><b>Charging Rate(Day):</b> Rs.2500 </p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('Vimukthi Senanayake')"><b>Hire</b></button>
            <button class="rate-btn" onclick="openRatingModal('Vimukthi Senanayake')"><b>Rate & Feedback</b></button>
        </div>
    </div>

    <div class="worker-card">
        <h3>Indika Karunaratne</h3>
        <div class="worker-img">
        <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="Indika Karunaratne">
        </div>
        <p><b>Skills:</b> Harvesting, Irrigation</p>
        <p><b>Availability:</b> Available</p>
        <p><b>Address:</b> No.707 Negombo Road, Negombo</p>
        <p><b>Phone Number:</b> 075 7654321</p>
        <p><b>Charging Rate(Day):</b> Rs.2500 </p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('Indika Karunaratne')"><b>Hire</b></button>
            <button class="rate-btn" onclick="openRatingModal('Indika Karunaratne')"><b>Rate & Feedback</b></button>
        </div>
    </div>

    <div class="worker-card">
        <h3>Haritha Nayanajith</h3>
        <div class="worker-img">
        <img src="<?php echo URLROOT;?>/images/images/img25.jpg" alt="Haritha Nayanajith">
        </div>
        <p><b>Skills:</b> Pruning, Weeding</p>
        <p><b>Availability:</b> Available</p>
        <p><b>Address:</b> No.808 Ampara, Ampara</p>
        <p><b>Phone Number:</b> 079 8765432</p>
        <p><b>Charging Rate(Day):</b> Rs.2500 </p>
        <div class="button-group">
            <button class="hire-btn" onclick="openHireModal('Haritha Nayanajith')"><b>Hire</b></button>
            <button class="rate-btn" onclick="openRatingModal('Haritha Nayanajith')"><b>Rate & Feedback</b></button>
        </div>
    </div>
</div>

</div>

<!-- Hire Modal -->
<div id="hireModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeModal('hireModal')">&times;</span>
        <h3>Hire Worker</h3>
        <p id="workerName"></p

>
        <label for="task">Task:</label>
        <input type="text" id="task" placeholder="Task Details">
      <div class="test" style="margin-bottom:10px;">
      <label for="start_date">Start Date:</label>
        <input type="date" id="start_date" name="start_date">
        <label for="end_date">End Date:</label>
        <input type="date" id="end_date" name="end_date">
      </div>

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
