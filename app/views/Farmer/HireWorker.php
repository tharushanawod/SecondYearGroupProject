<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Worker Hiring Form</title>
  <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/HireWorker.css" />
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css" />
  <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
  <div class="container">
    <h2>Worker Hiring Form</h2>
    <form id="hireWorkerForm" action="<?php echo URLROOT.'/FarmerController/HireWorkerConfirmation/'.$data['workerid']; ?>" method="POST">

      <!-- Job Type -->
      <div class="form-group radio-group">
        <label>Job Type:</label>
        <label><input type="radio" name="job_type" value="Irrigation Worker" required> Irrigation Worker</label>
        <label><input type="radio" name="job_type" value="Tractor Operator"> Tractor Operator</label>
        <label><input type="radio" name="job_type" value="Crop Worker"> Crop Worker</label>
        <span class="error"><?php echo $data['job_type_err']; ?></span>
      </div>

      <!-- Work Duration -->
      <div class="form-group radio-group">
        <label>Work Duration:</label>
        <label><input type="radio" name="work_duration" value="Full Time" required> Full Time</label>
        <label><input type="radio" name="work_duration" value="Part Time"> Part Time</label>
        <span class="error"><?php echo $data['work_duration_err']; ?></span>
      </div>

      <!-- Start Date -->
      <div class="form-group">
        <label for="start_date">Start Date:</label>
        <input type="text" id="start_date" name="start_date" placeholder="Select start date" required />
        <span class="error"><?php echo $data['start_date_err']; ?></span>
      </div>

      <!-- End Date -->
      <div class="form-group">
        <label for="end_date">End Date:</label>
        <input type="text" id="end_date" name="end_date" placeholder="Select end date" required />
        <span class="error"><?php echo $data['end_date_err']; ?></span>
      </div>

      <!-- Required Skills -->
      <div class="form-group checkbox-group">
        <label>Required Skills:</label>
        <label><input type="checkbox" name="skills[]" value="Planting" id="skill_planting"> Planting</label>
        <label><input type="checkbox" name="skills[]" value="Harvesting" id="skill_harvesting"> Harvesting</label>
        <label><input type="checkbox" name="skills[]" value="Maintaining Crops" id="skill_maintaining"> Maintaining Crops</label>
        <label><input type="checkbox" name="skills[]" value="Operating Machinery" id="skill_machinery"> Operating Machinery</label>
        <span class="error" id="skillsError" style="color:red;"></span>
      </div>

      <!-- Location -->
      <div class="form-group">
        <label for="location">Location:</label>
        <input type="text" id="location" name="location" placeholder="Enter the location" required />
        <span class="error"><?php echo $data['location_err']; ?></span>
      </div>

      <!-- Accommodation -->
      <div class="form-group radio-group">
        <label>Accommodation:</label>
        <label><input type="radio" name="accommodation" value="Yes" required> Yes</label>
        <label><input type="radio" name="accommodation" value="No"> No</label>
        <span class="error"><?php echo $data['accommodation_err']; ?></span>
      </div>

      <!-- Food -->
      <div class="form-group radio-group">
        <label>Food Provided:</label>
        <label><input type="radio" name="food" value="Yes" required> Yes</label>
        <label><input type="radio" name="food" value="No"> No</label>
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

  <!-- Custom JS for validating skills checkboxes -->
  <!-- <script>
    document.getElementById('hireWorkerForm').addEventListener('submit', function(e) {
      const checkboxes = document.querySelectorAll('input[name="skills[]"]');
      const oneChecked = Array.from(checkboxes).some(cb => cb.checked);
      if (!oneChecked) {
        e.preventDefault();
        document.getElementById('skillsError').innerText = 'Please select at least one skill.';
      } else {
        document.getElementById('skillsError').innerText = '';
      }
    }); -->
  </script>
</body>
</html>
