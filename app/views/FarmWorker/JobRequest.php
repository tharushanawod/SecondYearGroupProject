
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
    <h1>Job Requests</h1>
    <div class="requests-container">        
        <div class="request">
            <h3>Job Title: Farm Worker</h3>
            <p><strong>Employer:</strong> John Doe</p>
            <p><strong>Offer:</strong> LKR 2500/hour</p>
            <p><strong>Description:</strong> Looking for a farm worker to help with daily tasks.</p>
            <div class="button-row">
            <button class="accept-btn">Accept</button>
            <button class="reject-btn">Reject</button>
            </div>
        </div>
        <div class="request">
            <h3>Job Title: Farm Worker</h3>
            <p><strong>Employer:</strong> Jane Smith</p>
            <p><strong>Offer:</strong> LKR 1800/hour</p>
            <p><strong>Description:</strong> Seeking a farm worker to assist with planting and harvesting.</p>
            <div class="button-row">
            <button class="accept-btn">Accept</button>
            <button class="reject-btn">Reject</button>
            </div>
        </div>
        <div class="request">
            <h3>Job Title: Farm Worker</h3>
            <p><strong>Employer:</strong> Bob Johnson</p>
            <p><strong>Offer:</strong> LKR 2000/hour</p>
            <p><strong>Description:</strong> Looking for a farm worker to help with apply pesticides.</p>
            <div class="button-row">
            <button class="accept-btn">Accept</button>
            <button class="reject-btn">Reject</button>
            </div>
        </div>
    </div>
</body>
</html>