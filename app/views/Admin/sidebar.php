<div class="sidebar">
      <div class="profile">
        <img src="<?php echo URLROOT;?>/images/card-pic-5.jpg" alt="User Profile" class="profile-icon">
        <p class="username"><?php echo $_SESSION['user_name'];?></p>
    </div>
      <ul class="nav-list">
        <li class="nav-item">
          
          <a href="<?php echo URLROOT;?>/AdminController/LandingDashboard"><div class="links"><img width="20" height="20" src="https://img.icons8.com/ios/50/dashboard.png" alt="dashboard"/><p>Dashboard</p></div></a>
        </li>
        <li class="nav-item">
          <a href="<?php echo URLROOT;?>/AdminController/RemoveUsers"><div class="links"><img width="20" height="20" src="https://img.icons8.com/ios/50/user--v1.png" alt="user--v1"/><p>Remove Users</p></div></a>
        </li>
        <li class="nav-item">
          <a href="<?php echo URLROOT;?>/AdminController/UpdateUsers"><div class="links"><img width="20" height="20" src="https://img.icons8.com/pastel-glyph/64/loop.png" alt="loop"/><p>Update Users</p></div></a>
        </li>
        <li class="nav-item">
          <a href="<?php echo URLROOT;?>/AdminController/AddModerators"><div class="links"><img width="20" height="20" src="https://img.icons8.com/ios/50/commercial-development-management.png" alt="commercial-development-management"/><p>Moderators Management</p></div></a>
        </li>
        <li class="nav-item">
          <a href="<?php echo URLROOT;?>/AdminController/getManufacturers"><div class="links"><img width="20" height="20" src="https://img.icons8.com/ios/50/commercial-development-management.png" alt="commercial-development-management"/><p>Verify Users</p></div></a>
        </li>
        <li class="nav-item">
          <a href="<?php echo URLROOT;?>/AdminController/Report"><div class="links"><img width="20" height="20" src="https://img.icons8.com/ios/50/graph-report.png" alt="graph-report"/><p>Reports</p></div></a>
        </li>
        <li class="nav-item">
          <a href="<?php echo URLROOT;?>/LandingController/logout"><div class="links"><img width="20" height="20" src="https://img.icons8.com/ios/50/exit--v1.png" alt="exit--v1"/><p>Logout</p></div></a>
        </li>
        

      </ul>
    </div>