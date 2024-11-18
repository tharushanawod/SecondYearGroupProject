<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
<link rel="stylesheet" href="<?php echo URLROOT;?>/css/Admin/LandingDashboard.css">
  </head>
  <body>
    <?php require 'sidebar.php';?>

    <div class="main-content">
      <div class="overview">
        <h2> Welcome Back .. 👋</h2>
        <div class="stats-grid">
        <div class="stat-card">
              <span>Farmers</span>
          <?php $farmerCount = $this->UserCount('farmer'); ?>
              <h3><?php echo $farmerCount; ?></h3>
              <div class="user-icon">👤</div>
          </div>
          <div class="stat-card">
            <span>Buyers</span>
            <?php $buyercount = $this->UserCount('buyer'); ?>
            <h3><?php echo $buyercount; ?></h3>
            <div class="user-icon">👤</div>
          </div>
          <div class="stat-card">
            <span>Farm Workers</span>
            <?php $farmworkerCount = $this->UserCount('farmerworkr'); ?>
            <h3><?php echo $farmworkerCount; ?></h3>
            <div class="user-icon">👤</div>
          </div>
          <div class="stat-card">
            <span>Ingredient Suppliers</span>
            <?php $supplierCount = $this->UserCount('supplier'); ?>
            <h3><?php echo $supplierCount; ?></h3>
            <div class="user-icon">👤</div>
          </div>
          <div class="stat-card">
            <span>Manufacturers</span>
            <?php $manufacturercount = $this->UserCount('manufacturer'); ?>
            <h3><?php echo $manufacturercount; ?></h3>
            <div class="user-icon">👤</div>
          </div>
        </div>
      </div>

      <div class="detailed-report">
        <h2>Detailed report</h2>
        <table>
          <thead>
            <tr>
              <th>CUSTOMER NAME</th>
              <th>Title</th>
              <th>CONTACT NUMBER</th>
              <th>CREATED DATE</th>
              <th>EMAIL</th>
            </tr>
          </thead>
          <tbody>
          <?php
        // Loop through users and display each user in a row
        if(!empty($data['users'])):
            foreach($data['users'] as $user):
        ?>
            <tr>
                <td><?php echo $user->name; ?></td>  <!-- User ID -->
                <td><?php echo $user->title; ?></td>  <!-- User Name -->
                <td><?php echo $user->phone; ?></td>  <!-- User Email -->
                <td><?php echo $user->created_at; ?></td>  <!-- User Phone -->
                <td><?php echo $user->email; ?></td>  <!-- User Title -->
            </tr>
        <?php
            endforeach;
        else:
        ?>
            <tr>
                <td colspan="6">No users found</td>
            </tr>
        <?php endif; ?>
  </tbody>
        </table>
      </div>
    </div>
    <script src="<?php echo URLROOT;?>/js/Admin/nav-active.js"></script>
  </body>
</html>
