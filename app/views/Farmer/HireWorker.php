<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Hiring Form</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/HireWorker.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="container">
        <h2>Worker Hiring Form</h2>
        <form id="hireWorkerForm" action="<?php echo URLROOT.'/FarmerController/HireWorkerConfirmation/'.$data['workerid']; ?>" method="POST">
            
            <!-- Job Type -->
            <div class="form-group radio-group">
            <label>Job Type:</label>
            <label>
                <input type="radio" id="job_type_irrigation" name="job_type" value="Irrigation Worker"> Irrigation Worker
            </label>
            <label>
                <input type="radio" id="job_type_tractor" name="job_type" value="Tractor Operator"> Tractor Operator
            </label>
            <label>
                <input type="radio" id="job_type_crop" name="job_type" value="Crop Worker"> Crop Worker
            </label>
            <span class="error"><?php echo $data['job_type_err']; ?></span>
            </div>

            <!-- Work Duration -->
            <div class="form-group radio-group">
            <label>Work Duration:</label>
            <label>
                <input type="radio" id="work_duration_full_time" name="work_duration" value="Full Time"> Full Time
            </label>
            <label>
                <input type="radio" id="work_duration_part_time" name="work_duration" value="Part Time"> Part Time
            </label>
            <span class="error"><?php echo $data['work_duration_err']; ?></span>
            </div>

            <!-- Start Date -->
            <div class="form-group">
            <label for="start_date">Start Date:</label>
            <input type="text" id="start_date" name="start_date" placeholder="Select start date" required>
            <span class="error"><?php echo $data['start_date_err']; ?></span>
            </div>

            <!-- End Date -->
            <div class="form-group">
            <label for="end_date">End Date:</label>
            <input type="text" id="end_date" name="end_date" placeholder="Select end date" required>
            <span class="error"><?php echo $data['end_date_err']; ?></span>
            </div>

            <!-- Rest of the form remains unchanged -->
            <!-- Required Skills -->
            <div class="form-group checkbox-group">
            <label>Required Skills:</label>
            <label>
                <input type="checkbox" id="skill_planting" name="skills[]" value="Planting"> Planting
            </label>
            <label>
                <input type="checkbox" id="skill_harvesting" name="skills[]" value="Harvesting"> Harvesting
            </label>
            <label>
                <input type="checkbox" id="skill_maintaining" name="skills[]" value="Maintaining Crops"> Maintaining Crops
            </label>
            <label>
                <input type="checkbox" id="skill_machinery" name="skills[]" value="Operating Machinery"> Operating Machinery
            </label>
            </div>

            <!-- Location -->
            <div class="form-group">
            <label for="location">Location:</label>
            <input type="text" id="location" name="location" placeholder="Enter the location" required>
            <span class="error"><?php echo $data['location_err']; ?></span>
            </div>

            <!-- Accommodation -->
            <div class="form-group radio-group">
            <label>Accommodation:</label>
            <label>
                <input type="radio" id="accommodation_yes" name="accommodation" value="Yes"> Yes
            </label>
            <label>
                <input type="radio" id="accommodation_no" name="accommodation" value="No"> No
            </label>
            <span class="error"><?php echo $data['accommodation_err']; ?></span>
            </div>

            <!-- Food -->
            <div class="form-group radio-group">
            <label>Food Provided:</label>
            <label>
                <input type="radio" id="food_yes" name="food" value="Yes"> Yes
            </label>
            <label>
                <input type="radio" id="food_no" name="food" value="No"> No
            </label>
            <span class="error"><?php echo $data['food_err']; ?></span>
            </div>

            <!-- Submit Button -->
            <div class="form-group">
            <button type="submit" class="submit-btn">Submit</button>
            </div>

        </form>
    </div>

    <div class="popup-message" id="popupMessage">Your request has been successfully sent.</div>

    <!-- Add Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        const bookedDates = <?php echo json_encode($data['confirmedDates'] ?? []); ?>;
    </script>
    <script src="<?php echo URLROOT;?>/js/Farmer/HireWorker.js"></script>
</body>
</html>