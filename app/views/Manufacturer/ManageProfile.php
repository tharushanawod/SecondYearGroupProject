<html>

<head>
   <title>Settings</title>
   <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css" rel="stylesheet" />
   <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet" />
   <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Manufacturer/ManageProfile.css" />
   <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet" />
</head>

<body>
   <?php require APPROOT . '/views/inc/sidebar.php'; ?>
   <div class="container">

      <!-- profile image section  -->

      <div class="profilesidebar">
         <?php $imagepath = $this->getProfileImage($_SESSION['user_id']); ?>
         <img alt="profile picture" src="<?php echo $imagepath; ?>" />
         <div class="edit-icon" onclick="openModal()">
            <i class="fas fa-pencil-alt"> </i>
         </div>
         <h2>
            <?php echo $_SESSION['user_name']; ?>
         </h2>
         <p>
            <?php echo $_SESSION['user_role']; ?>
         </p>
      </div>

      <!-- popup modal for uploading profile picture -->

      <div id="uploadModal" class="modal">
         <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div class="image-preview">
               <img src="<?php echo URLROOT;?>/images/profile.jpg" alt="Profile preview" id="preview-image">
            </div>
            <form class="upload-form" action="<?php echo URLROOT;?>/ManufacturerController/uploadProfileImage" method="POST"
               enctype="multipart/form-data">
               <input type="file" name="profile_picture" accept="image/*" required>
               <button type="submit">Save Profile Image</button>
            </form>
         </div>
      </div>

      <!-- popup to confirm the save profile details -->
      <div id="popup" class="popup">
         <div class="popup-content">
            <span class="close-btn" onclick="closePopup()">&times;</span>
            <p>Your profile has been updated successfully!</p>
            <p>Please Login To the System Again</p>
         </div>
      </div>


      <div class="content">
         <h1>Settings</h1>
         <div class="tabs">
            <a href="#"> General </a>

         </div>
         <h2>Profile</h2>

         <form action="<?php echo URLROOT;?>/ManufacturerController/ManageProfile" method="post" id="profileForm">
            <div class="form-group">
               <div>
                  <label for="name"> Name </label>
                  <input id="name" name="name" placeholder="Your full name" type="text"
                     value="<?php echo $data['name']?>" />
                  <span class="invalid">
                     <?php echo $data['name_err']; ?>
                  </span>
               </div>
               <div>
                  <label for="phone"> Phone Number </label>
                  <input id="contact" name="phone" placeholder="Your number" type="text"
                     value="<?php echo $data['phone']?>" />
                  <span class="invalid">
                     <?php echo $data['phone_err']; ?>
                  </span>
               </div>
            </div>

            <hr />
            <h2>Account</h2>
            <div class="form-group">
               <div>
                  <label for="email"> Email </label>
                  <input id="email" name="email" placeholder="example.email@gmail.com" type="email"
                     value="<?php echo $data['email']?>" />
                  <span class="invalid">
                     <?php echo $data['email_err']; ?>
                  </span>
               </div>
               <div>
                  <label for="password"> Password </label>
                  <input id="password" name="password" placeholder="********" type="password" />
               </div>
            </div>
            <button class="save-btn" type="submit" onclick="showPopup()">Save information</button>
      </div>
      </form>
   </div>
 <script src="<?php echo URLROOT;?>/js/common/ManageProfile.js"></script>

</body>

</html>