<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Admin/UpdateUserDetails.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?> 

    <div class="main-content">
      <form action="<?php echo URLROOT; ?>/AdminController/SubmitUserDetails/<?php  echo $data['user_id'];?>" method="POST">
    <div class="moderator-creation">
        <h1>Update Users ♻️</h1>

            <input type="hidden" id="user_id" name="user_id" placeholder="Enter ID" value="<?php echo $data['user_id']?>">
     
        <div class="input-group">
            <label for="username">Username</label>
            <input type="text" id="name" name="name" placeholder="Enter Username" value="<?php echo $data['name']?>" >
             <span class="form-invalid">
                        <?php echo $data['name_err'];?>
             </span>
        </div>
        <div class="input-group">
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter an email" value="<?php echo $data['email'];?>" required>
            <span class="form-invalid">
                        <?php echo $data['email_err'];?>
             </span>
        </div>
        <div class="input-group">
            <label for="contact">Contact Number</label>
            <input type="tel" id="phone" name="phone" placeholder="Enter a contact number" value="<?php echo $data['phone']; ?>" pattern="0\d{9}" user_type="Contact number must start with 0 and be 10 digits long">


            <span class="form-invalid">
                        <?php echo $data['phone_err'];?>
             </span>
        </div>
        <div class="input-group">
    <label for="user_type">Choose a user_type:</label>
    <select id="user_type" name="user_type" required>
        <option value="farmer" <?php echo $data['user_type'] === 'farmer' ? 'selected' : ''; ?>>Farmer</option>
        <option value="buyer" <?php echo $data['user_type'] === 'buyer' ? 'selected' : ''; ?>>Buyer</option>
        <option value="supplier" <?php echo $data['user_type'] === 'supplier' ? 'selected' : ''; ?>>Ingredient Supplier</option>
        <option value="farmworker" <?php echo $data['user_type'] === 'worker' ? 'selected' : ''; ?>>Farm Worker</option>
        <option value="manufacturer" <?php echo $data['user_type'] === 'manufacturer' ? 'selected' : ''; ?>>Manufacturer</option>
        <option value="moderator" <?php echo $data['user_type'] === 'moderator' ? 'selected' : ''; ?>>Moderator</option>
    </select>
</div>

        <div class="input-group">
            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter a password"  >
        </div>
        <button type="submit">Update</button>
        <a href="<?php echo URLROOT.'/AdminController/RestrictUser/'.$data['user_id'];?>"><button type="button" class="cancel-btn">Cancel</button></a>
    </div>
</form>

    </div>
    <script src="<?php echo URLROOT;?>/js/Admin/nav-active.js"></script>
</body>
</html>