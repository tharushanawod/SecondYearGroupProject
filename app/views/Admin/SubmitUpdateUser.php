<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator Creation</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Admin/SubmitUpdateUser.css">
</head>
<body>
 <?php require 'sidebar.php';?>

    <div class="main-content">
        <div class="moderator-creation">
            <h1>Update Users ♻️</h1>
            <div class="input-group">
                <label for="username">Username</label>
                <input type="text" id="username" placeholder="Enter Username" />
            </div>
            <div class="input-group">
                <label for="email">Email</label>
                <input type="email" id="email" placeholder="Enter an email" />
            </div>
            <div class="input-group">
                <label for="contact">Contact Number</label>
                <input type="tel" id="contact" placeholder="Enter a contact Number" />
            </div>
            <div class="input-group">
            <label for="title">Choose a Title:</label>
                <select id="titles" name="titles">
                <option value="farmer">Farmer</option>
                <option value="buyer">Buyer</option>
                <option value="supplier">Ingredient Supplier</option>
                <option value="farmworker">Farm Worker</option>
                <option value="manufacturer">Manufacturer</option>
                </select>

            </div>
            <div class="input-group">
                <label for="password">Password</label>
                <input type="password" id="password" placeholder="Enter a password" />
            </div>
            <button>Update</button>
            <button class="cancel-btn">Cancel</button>
        </div>
    </div>
    <script src="<?php echo URLROOT;?>/js/Admin/nav-active.js"></script>
</body>
</html>