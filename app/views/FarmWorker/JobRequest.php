
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Requests</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/FarmWorker/JobRequest.css">
</head>
<body>
<?php require 'sidebar.php'; ?>
    <div class="requests-container">
        <h2>Job Requests</h2>
        <div class="request">
            <h3>Job Title: Farm Worker</h3>
            <p><strong>Employer:</strong> John Doe</p>
            <p><strong>Offer:</strong> $15/hour</p>
            <p><strong>Description:</strong> Looking for a farm worker to help with daily tasks.</p>
            <button class="accept-btn">Accept</button>
            <button class="reject-btn">Reject</button>
        </div>
        <div class="request">
            <h3>Job Title: Farm Worker</h3>
            <p><strong>Employer:</strong> Jane Smith</p>
            <p><strong>Offer:</strong> $18/hour</p>
            <p><strong>Description:</strong> Seeking a farm worker to assist with planting and harvesting.</p>
            <button class="accept-btn">Accept</button>
            <button class="reject-btn">Reject</button>
        </div>
        <div class="request">
            <h3>Job Title: Farm Worker</h3>
            <p><strong>Employer:</strong> Bob Johnson</p>
            <p><strong>Offer:</strong> $16/hour</p>
            <p><strong>Description:</strong> Looking for a farm worker to help with animal care.</p>
            <button class="accept-btn">Accept</button>
            <button class="reject-btn">Reject</button>
        </div>
    </div>
</body>
</html>