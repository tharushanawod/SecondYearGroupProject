<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Submit Report to Admin</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Moderator/ReportToAdmin.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet" />
</head>

<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="container">
        <h1>Submit Report to Admin</h1>
        
        <div class="guidelines">
            <h3>Guidelines for Moderator Comments:</h3>
            <p>Please include the following information in your comments:</p>
            <ul>
                <li>Order ID or Transaction ID if applicable</li>
                <li>Date and time of the reported incident</li>
                <li>Type of violation or issue (spam, inappropriate content, fraud, etc.)</li>
                <li>Any actions already taken</li>
                <li>Evidence or screenshots (mention if attached separately)</li>
                <li>Severity level (low, medium, high)</li>
                <li>Any previous history with this user</li>
            </ul>
        </div>
        
        <form action="<?php echo URLROOT ;?>/ModeratorController/ReportToAdmin" method="post">
            <div class="field-container">
                <label for="user_id">User ID:(who sent the report)</label>
                <input type="text" id="user_id" name="user_id" required>
            </div>

            <div class="field-container">
                <label for="moderator_comments">Moderator Comments:</label>
                <textarea id="moderator_comments" name="moderator_comments" rows="4" cols="50" required></textarea>
            </div>
            <span class="success"><?php if(isset($data['report_success']) ){
                echo $data['report_success']; 
               }?></span>

            <input type="submit" value="Send to Admin">
        </form>
        
        
    </div>
</body>

</html>