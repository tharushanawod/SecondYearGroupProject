<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Restricted</title>
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/Buyer/Restricted.css">
</head>

<body>
    <div class="restricted-container">
        <div class="restricted-icon">
            <i class="fas fa-lock"></i>
        </div>

        <h1 class="restricted-title">Account Restricted</h1>
        <p class="restricted-message">Your account has been temporarily restricted. Please review the details below and
            contact the moderator to resolve this issue.</p>

        <div class="reason-box">
            <h3>Restriction Reason</h3>
            <p>
            <?php foreach ($data as $log): ?>
    <p><?php echo $log->reason; ?></p>
<?php endforeach; ?>

            </p>
        </div>

        <div class="moderator-info">
            <div class="moderator-header">
                <i class="fas fa-user-shield"></i>
                <h2>Contact Moderator</h2>
            </div>

            <div class="moderator-details">
                <div class="detail-item">
                    <div class="detail-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="detail-content">
                        <h4>Name</h4>
                        <p>
                          G.M.K Gunarathne
                        </p>
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-icon">
                        <i class="fas fa-envelope"></i>
                    </div>
                    <div class="detail-content">
                        <h4>Email</h4>
                        <p>
                            moderator@gmail.com
                        </p>
                    </div>
                </div>

                <div class="detail-item">
                    <div class="detail-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="detail-content">
                        <h4>Contact Number</h4>
                        <p>
                            +94784563330
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div class="action-buttons">
            <button class="action-btn profile-btn"
                onclick="window.location.href='<?php echo URLROOT; ?>/BuyerController/ManageProfile'">
                <i class="fas fa-user-cog"></i> Manage Profile
            </button>
            <button class="action-btn logout-btn"
                onclick="window.location.href='<?php echo URLROOT; ?>/LandingController/logout'">
                <i class="fas fa-sign-out-alt"></i> Logout
            </button>
        </div>
    </div>
</body>

</html>