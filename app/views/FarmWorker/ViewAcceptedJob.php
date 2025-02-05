<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Request Details</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/FarmWorker/ViewRequest.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
    <style>

    </style>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
  
<div class="container">
    <h1>Accepted Job Details</h1>
    <table>
        <tr>
            <th>Job ID</th>
            <td><?php echo $data->job_id; ?></td>
        </tr>
        <tr>
            <th>Job Type</th>
            <td><?php echo $data->job_type; ?></td>
        </tr>
        <tr>
            <th>Work Duration</th>
            <td><?php echo $data->work_duration; ?></td>
        </tr>
        <tr>
            <th>Start Date</th>
            <td><?php echo $data->start_date; ?></td>
        </tr>
        <tr>
            <th>End Date</th>
            <td><?php echo $data->end_date; ?></td>
        </tr>
        <tr>
            <th>Skills</th>
            <td><?php echo $data->skills; ?></td>
        </tr>
        <tr>
            <th>Location</th>
            <td><?php echo $data->location; ?></td>
        </tr>
        <tr>
            <th>Accommodation</th>
            <td><?php echo $data->accommodation; ?></td>
        </tr>
        <tr>
            <th>Food</th>
            <td><?php echo $data->food; ?></td>
        </tr>
    </table>
    <div class="buttons">
        <a href="tel:<?php echo '+94788278880' ?>"><button class="accept-btn">Contact The Farmer</button></a>
    </div>
</div>

<script>
function acceptRequest(job_id) {
    // Implement the accept request logic here
    alert('Request accepted for job ID: ' + job_id);
}

function rejectRequest(job_id) {
    // Implement the reject request logic here
    alert('Request rejected for job ID: ' + job_id);
}
</script>
</body>
</html>
