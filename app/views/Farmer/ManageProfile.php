<!DOCTYPE html>
<html>
<head>
  <title>Personal Data</title>
  <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/ManageProfile.css">
</head>
<body>
    <?php require 'sidebar.php'; ?>
  <div class="container">
  <h2>Personal Data</h2>
    <div class="profile-group">
       
      <img src="<?php echo URLROOT;?>/images/aman.jpeg" alt="Profile Picture" class="profile-picture">
      <div class="buttons"> <a href="#" class="btn">Upload new picture</a>
      <a href="#" class="btn">Delete</a>
    </div>
     
    </div>
    <div class="form-group">
      <label for="first-name">First name</label>
      <input type="text" id="first-name" name="first-name" value="Brian">
    </div>
    <div class="form-group">
      <label for="last-name">Last name</label>
      <input type="text" id="last-name" name="last-name" value="Kim">
    </div>
    <div class="form-group">
      <label for="contact-number">Contact Number</label>
      <input type="tel" id="contact-number" name="contact-number" value="0771457654">
    </div>
    <div class="form-group">
      <label for="email">Email</label>
      <input type="email" id="email" name="email" value="alee@yahoo.com">
    </div>
    <button type="submit" class="btn">Save Changes</button>
  </div>
</body>
</html>