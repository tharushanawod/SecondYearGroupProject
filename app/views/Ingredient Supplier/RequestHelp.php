<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Need Support?</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Ingredient Supplier/RequestHelp.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>
    
    <div class="help-container">
        <h1>Need Support?</h1>
        <p>Please select a category that best describes your issue:</p>
        
        <?php if (isset($_SESSION['request_success'])): ?>
            <div class="success"><?php echo $_SESSION['request_success']; unset($_SESSION['request_success']); ?></div>
        <?php elseif (isset($_SESSION['request_error'])): ?>
            <div class="error"><?php echo $_SESSION['request_error']; unset($_SESSION['request_error']); ?></div>
        <?php endif; ?>

        <div class="category-boxes">
            <a href="<?php echo URLROOT;?>/SupplierController/showForm/payment" class="category-box">
                <i class="fas fa-money-bill-wave"></i>
                <h3>Payment Issues</h3>
                <p>Problems with payments, refunds, or billing</p>
            </a>
            
            <a href="<?php echo URLROOT;?>/SupplierController/showForm/system" class="category-box">
                <i class="fas fa-cogs"></i>
                <h3>System Problems</h3>
                <p>Technical issues, bugs, or errors</p>
            </a>
            
            <a href="<?php echo URLROOT;?>/SupplierController/showForm/account" class="category-box">
                <i class="fas fa-user"></i>
                <h3>Account Issues</h3>
                <p>Login problems, profile updates, or account settings</p>
            </a>
            
            <a href="<?php echo URLROOT;?>/SupplierController/showForm/other" class="category-box">
                <i class="fas fa-question-circle"></i>
                <h3>Other Issues</h3>
                <p>Any other questions or concerns</p>
            </a>
        </div>

        <?php
        // Display form if a category is provided
        if (isset($data['category'])) {
            $category = $data['category'];
            echo '<div class="help-form">';
            echo '<h2>' . ucfirst($category) . ' Issue</h2>';
            echo '<form action="' . URLROOT . '/SupplierController/submitRequest" method="POST" enctype="multipart/form-data">';
            echo '<input type="hidden" name="category" value="' . $category . '">';
            echo '<div class="form-group">';
            echo '<label for="' . $category . '-subject">Subject</label>';
            echo '<input type="text" id="' . $category . '-subject" name="subject" required>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="' . $category . '-description">Description</label>';
            echo '<textarea id="' . $category . '-description" name="description" rows="5" required></textarea>';
            echo '</div>';
            echo '<div class="form-group">';
            echo '<label for="' . $category . '-attachment">Attachment (Optional)</label>';
            echo '<input type="file" id="' . $category . '-attachment" name="attachment">';
            echo '</div>';
            echo '<div class="form-buttons">';
            echo '<button type="submit" class="submit-btn">Submit Request</button>';
            echo '<button type="button" class="cancel-btn" onclick="window.location.href=\'' . URLROOT . '/SupplierController/requestHelp\'">Cancel</button>';
            echo '</div>';
            echo '</form>';
            echo '</div>';
        }
        ?>
    </div>
</body>
</html>