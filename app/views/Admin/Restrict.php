<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restrict User Access</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Admin/Restrict.css">
</head>

<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?> 
    <div class="container">
        <div class="header">
            <h1>Restrict User Access</h1>
            <p>Document and submit user restriction details</p>
            <div class="icon">
                <i class="fas fa-user-lock"></i>
            </div>
        </div>

        <div class="form-container">
            <form action="<?php echo URLROOT ?>/AdminController/Restriction/<?php echo $data['user_id'];?>" method="POST">
                <div class="form-group">
                    <label for="username">Username:</label>
                    <input type="text" id="username" name="username" placeholder="Enter username to restrict" value="<?php echo $data['name']?>" required disabled>
                </div>

                <div class="form-group">
                    <label for="user_type">User Type:</label>
                    <input type="text" id="username" name="username" placeholder="Enter username to restrict" value="<?php echo $data['user_type']?>"  required disabled>
                </div>

                <div class="form-group">
                    <label>Reason for Restriction:</label>
                    <div class="restriction-reasons">
                        <label class="reason-card">
                            <input type="checkbox" name="reasons[]" value="spam">
                            <div class="checkbox">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="reason-label">Spamming/Excessive Posting</span>
                        </label>

                        <label class="reason-card">
                            <input type="checkbox" name="reasons[]" value="inappropriate">
                            <div class="checkbox">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="reason-label">Inappropriate Content</span>
                        </label>

                        <label class="reason-card">
                            <input type="checkbox" name="reasons[]" value="harassment">
                            <div class="checkbox">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="reason-label">Harassment of Other Users</span>
                        </label>

                        <label class="reason-card">
                            <input type="checkbox" name="reasons[]" value="fake">
                            <div class="checkbox">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="reason-label">Fake Profile Information</span>
                        </label>

                        <label class="reason-card">
                            <input type="checkbox" name="reasons[]" value="scam">
                            <div class="checkbox">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="reason-label">Scam Activities</span>
                        </label>

                        <label class="reason-card">
                            <input type="checkbox" name="reasons[]" value="terms">
                            <div class="checkbox">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="reason-label">Terms of Service Violation</span>
                        </label>

                        <label class="reason-card">
                            <input type="checkbox" name="reasons[]" value="other">
                            <div class="checkbox">
                                <i class="fas fa-check"></i>
                            </div>
                            <span class="reason-label">Other</span>
                        </label>
                    </div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-btn">
                        <i class="fas fa-ban"></i> Submit Restriction
                    </button>
                    <button type="button" class="cancel-btn"
                        onclick="window.location.href='index.php?controller=admin&action=dashboard'">
                        Cancel
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>

</html>