<div class="sidebar">
      <div class="profile">
        <img src="./card-pic-1.jpg" alt="User Profile" class="profile-icon">
        <p class="username"><?php echo $_SESSION['user_name'];?></p>
    </div>
      <ul class="nav-list">
        <li class="nav-item">
          <a href="<?php echo URLROOT;?>/AdminController/LandingDashboard">Dashboard</a>
        </li>
        <li class="nav-item">
          <a href="<?php echo URLROOT;?>/AdminController/RemoveUsers">Remove Users</a>
        </li>
        <li class="nav-item">
          <a href="<?php echo URLROOT;?>/AdminController/UpdateUsers">Update Users</a>
        </li>
        <li class="nav-item">
          <a href="<?php echo URLROOT;?>/AdminController/AddModerators">Moderators Management</a>
        </li>
        <li class="nav-item">
          <a href="<?php echo URLROOT;?>/AdminController/Report">Reports</a>
        </li>
        <li class="nav-item">
          <a href="<?php echo URLROOT;?>/LandingController/logout">Logout</a>
        </li>
        

      </ul>
    </div>