<!-- FILE: views/FarmWorker/job_description_form.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Description Form</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/FarmWorker/JobDescription.css">
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <h1>Job Description</h1>
    <button id="changeDescriptionBtn">Change Description</button>
    <div class="job-description">
        <div class="job-image">
            <img src="<?php echo URLROOT;?>/images/images/img68.jpg" alt="Profile picture">
        </div>
        <div class="job-details">
            <h3>Job Title: Farm Worker</h3>
            <p><strong>Location:</strong> Colombo</p>
            <p><strong>Job Type:</strong> Full-time</p>
            <p><strong>Expected Pay:</strong> LKR 2000/hour</p>
            <p><strong>Job Description:</strong> Looking for a farm worker to help with daily tasks.</p>
        </div>
    </div> 

    <!-- Job Description Form Modal -->
    <div id="jobDescriptionModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Job Description</h2>
            <form action="/saveJobDescription" method="POST" enctype="multipart/form-data">
                <label for="worker_image">Image:</label>
                <input type="file" id="worker_image" name="worker_image" accept="image/*">

                <label for="job_title">Job Title:</label>
                <input type="text" id="job_title" name="job_title" required>

                <label for="location">Location:</label>
                <input type="text" id="location" name="location" required>

                <label for="job_type">Job Type:</label>
                <input type="text" id="job_type" name="job_type" required>

                <label for="expected_pay">Expected Pay:</label>
                <input type="text" id="expected_pay" name="expected_pay" required>

                <label for="job_description">Job Description:</label>
                <textarea id="job_description" name="job_description" rows="4" required></textarea>           

                <button type="submit">Submit</button>
            </form>
        </div>
    </div>

    <script>
        // Get the modal
        var modal = document.getElementById("jobDescriptionModal");

        // Get the button that opens the modal
        var btn = document.getElementById("changeDescriptionBtn");

        // Get the <span> element that closes the modal
        var span = document.getElementsByClassName("close")[0];

        // When the user clicks the button, open the modal 
        btn.onclick = function() {
            modal.style.display = "block";
        }

        // When the user clicks on <span> (x), close the modal
        span.onclick = function() {
            modal.style.display = "none";
        }

        // When the user clicks anywhere outside of the modal, close it
        window.onclick = function(event) {
            if (event.target == modal) {
                modal.style.display = "none";
            }
        }
    </script>
</body>
</html>