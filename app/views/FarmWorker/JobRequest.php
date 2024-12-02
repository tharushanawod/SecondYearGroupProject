
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Job Requests</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/FarmWorker/JobRequest.css">
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <h1>Job Requests</h1>
    <div class="requests-container">        
        <div class="request">
        
            <p><strong>Farmer:</strong> Samith Perera</p>
            <p><strong>Start Date:</strong> 2024/12/20</p>
            <p><strong>End Date:</strong> 2024/12/28</p>
            <p><strong>Description:</strong> Looking for a farm worker to help with daily tasks.</p>
            <div class="button-row">
            <button class="accept-btn">Accept</button>
            <button class="reject-btn">Reject</button>
            </div>
        </div>
        <div class="request">
       
            <p><strong>Farmer:</strong> Jane Smith</p>
            <p><strong>Start Date:</strong> 2024/12/25</p>
            <p><strong>End Date:</strong> 2024/12/30</p>
            <p><strong>Description:</strong> Seeking a farm worker to assist with planting and harvesting.</p>
            <div class="button-row">
            <button class="accept-btn">Accept</button>
            <button class="reject-btn">Reject</button>
            </div>
        </div>
        <div class="request">
        
            <p><strong>Farmer:</strong> Aruna Gamage</p>
            <p><strong>Start Date:</strong> 2024/12/15</p>
            <p><strong>End Date:</strong> 2024/12/20</p>
            <p><strong>Description:</strong> Looking for a farm worker to help with apply pesticides.</p>
            <div class="button-row">
            <button class="accept-btn">Accept</button>
            <button class="reject-btn">Reject</button>
            </div>
        </div>
    </div>
</body>
</html>