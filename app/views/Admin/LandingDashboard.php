<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
<link rel="stylesheet" href="<?php echo URLROOT;?>/css/Admin/LandingDashboard.css">
<link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
<style>
  @import url(../components/sidebar2.css);
* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family:  sans-serif;
}

body {
  display: flex;
  background-color: #f4f4f4;
}

.main-content {
  margin-left: 250px;
  padding: 40px;

}

.overview {
  margin-bottom: 30px;
}

.stats-grid {
  display: grid;
  grid-template-columns: repeat(5, 1fr);
  gap: 20px;
  margin-top: 20px;
}

.stat-card {
  background: #c8dbed;
  padding: 20px;
  border-radius: 12px;
  position: relative;
}

.stat-card h3 {
  font-size: 32px;
  margin: 10px 0;
}

.user-icon {
  position: absolute;
  top: 20px;
  right: 20px;
  color: #ff7675;
}

.detailed-report {
  border-radius: 12px;
  padding: 20px;
  margin-top: 30px;
}

table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 20px;
}

th,
td {
  padding: 12px;
  text-align: left;
  border-bottom: 1px solid #eee;
  height: 10px;
}

.user-avatar {
  width: 40px;
  height: 40px;
  border-radius: 50%;
  margin-right: 10px;
}

.user-info {
  display: flex;
  align-items: center;
}

.detailed-report {
  background-color: #c8dbed;
}

table tr {
  transition: all 0.3s ease;
}

table tr:hover td {
  background-color: #d9e6f2;
  transform: scale(1.02);
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
}



table tr td:nth-child(5) {
  text-align: center;
}

table th:nth-child(5) {
  text-align: center;
}

.container {
  background-color: white;
  padding: 2rem;
  border-radius: 8px;
  box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
  width: 90%;
  max-width: 400px;
  margin: 1rem auto;
}

@media (max-width: 480px) {
  .container {
    margin: 1rem;
    padding: 1.5rem;
    width: 95%;
  }

  h1 {
    font-size: 20px;
  }

  p {
    font-size: 13px;
    margin-bottom: 1.5rem;
  }

  input[type="email"] {
    padding: 10px;
    font-size: 14px;
  }

  .btn {
    padding: 10px;
    font-size: 14px;
  }
}

@media (max-width: 320px) {
  .container {
    padding: 1rem;
  }

  h1 {
    font-size: 18px;
  }

  p {
    font-size: 12px;
  }
}
</style>
  </head>
  <body>
  <?php require APPROOT . '/views/inc/sidebar.php'; ?>
  <div class="main-content">
      <div class="overview">
        <h2> Welcome Back .. 👋</h2>
        <div class="stats-grid">
        <div class="stat-card">
              <span>Farmers</span>
          <?php $farmerCount = $this->UserCount('farmer'); ?>
              <h3><?php echo $farmerCount; ?></h3>
              <div class="user-icon"><img width="50" height="50" src="https://img.icons8.com/ios-filled/50/farmer-male--v1.png" alt="farmer-male--v1"/></div>
          </div>
          <div class="stat-card">
            <span>Buyers</span>
            <?php $buyercount = $this->UserCount('buyer'); ?>
            <h3><?php echo $buyercount; ?></h3>
            <div class="user-icon"><img width="50" height="50" src="https://img.icons8.com/ios-filled/50/cash-in-hand.png" alt="cash-in-hand"/></div>
          </div>
          <div class="stat-card">
            <span>Farm Workers</span>
            <?php $farmworkerCount = $this->UserCount('farmworker'); ?>
            <h3><?php echo $farmworkerCount; ?></h3>
            <div class="user-icon"><img width="50" height="50" src="https://img.icons8.com/external-outline-design-circle/50/external-Labour-carpenter-outline-design-circle.png" alt="external-Labour-carpenter-outline-design-circle"/></div>
          </div>
          <div class="stat-card">
            <span>Ingredient Suppliers</span>
            <?php $supplierCount = $this->UserCount('supplier'); ?>
            <h3><?php echo $supplierCount; ?></h3>
            <div class="user-icon"><img width="50" height="50" src="https://img.icons8.com/ios-filled/50/warehouse.png" alt="warehouse"/></div>
          </div>
          <div class="stat-card">
            <span>Manufacturers</span>
            <?php $manufacturercount = $this->UserCount('manufacturer'); ?>
            <h3><?php echo $manufacturercount; ?></h3>
            <div class="user-icon"><img width="50" height="50" src="https://img.icons8.com/ios-filled/50/company.png" alt="company"/></div>
          </div>
        </div>
      </div>

      <div class="detailed-report">
        <h2>Detailed report</h2>
        <table>
          <thead>
            <tr>
              <th>NAME</th>
              <th>Title</th>
              <th>CONTACT NUMBER</th>
              <th>Status</th>
              <th>EMAIL</th>
              <th>Action</th>
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
                <td><?php echo $user->user_type; ?></td>  <!-- User Name -->
                <td><?php echo $user->phone; ?></td>  <!-- User Email -->
                <td style="
    <?php
        if ($user->status == 'verified') {
            echo ' color: green; border-radius: 25px;width: 20px;';
        } elseif ($user->status == 'unverified') {
            echo 'color: tomato; border-radius: 25px;width: 20px;';
        } elseif ($user->status == 'restricted') {
            echo 'color: red; border-radius: 25px;width: 20px;';
        }
    ?>
">
    <?php echo $user->status; ?>
</td>

                <td><?php echo $user->email; ?></td>  <!-- User Title -->
                <td>
    <?php 
        if ($user->status == 'restricted') {
            echo '<a href="' . URLROOT . '/AdminController/AllowUser/' . $user->id . '">
            <button style="background-color: #0c0a7c; color: white; border: none; padding: 10px 20px; cursor: pointer;">Allow</button></a>';
        }

        else{
          echo '-';
        }
    ?>
</td>


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
