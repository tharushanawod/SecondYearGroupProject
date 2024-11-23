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
    <?php require 'sidebar.php'; ?>
    <div class="form-container">
        <h2>Job Description Form</h2>
        <form action="/saveJobDescription" method="POST" enctype="multipart/form-data">
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

            <label for="company_logo">Company Logo:</label>
            <input type="file" id="company_logo" name="company_logo" accept="image/*">

            <button type="submit">Submit</button>
        </form>
    </div>
</body>
</html>