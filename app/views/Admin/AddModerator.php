<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator Creation</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Admin/AddModerator.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>

    <div class="main-content">
        <div class="moderator-creation">
            <h1>Moderator Creation 👋</h1>
            <form action="<?php echo URLROOT;?>/AdminController/AddModerator" method="post">
    <div class="input-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" placeholder="Enter Username"  value="<?php echo $data['name']?>" required />
        <span class="form-invalid">
            <?php echo $data['name_err'];?>
        </span>
    </div>
    <div class="input-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" placeholder="Enter an email" value="<?php echo $data['email']?>" required />
        <span class="form-invalid">
            <?php echo $data['email_err'];?>
        </span>
    </div>
    <div class="input-group">
        <label for="phone">Contact Number</label>
        <input type="tel" id="phone" name="phone" placeholder="Enter a contact Number" pattern="0\d{9}" title="Contact number must start with 0 and be 10 digits long" value="<?php echo $data['phone']?>" required />
        <span class="form-invalid">
            <?php echo $data['phone_err'];?>
        </span>    
    </div>
    <div class="input-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" placeholder="Enter a password" value="<?php echo $data['password']?>" required />
        <span class="form-invalid">
            <?php echo $data['password_err'];?>
        </span>
    </div>
    <div class="button-group">
        <button type="submit">Create Account</button>
        <a href="<?php echo URLROOT;?>/AdminController/ModeratorControl"><button type="button" class="cancel-btn">Cancel</button></a>
    </div>
</form>

        </div>
    </div>
    <script src="<?php echo URLROOT;?>/js/Admin/nav-active.js"></script>
</body>
</html>