<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Dashboard</title>
<link rel="stylesheet" href="<?php echo URLROOT;?>/css/Admin/LandingDashboard.css">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
  </head>
  <body>
  <?php require APPROOT . '/views/inc/sidebar.php'; ?>
  <div class="main-content">
        <h2 class="mb-4">Dashboard Overview</h2>

        <!-- Stats Cards -->
        <div class="row mb-4">
            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="card-body">
                        <div>
                            <h6 class="card-title">Total Farmers</h6>
                            <h2 class="mb-0">
                                <?php echo $data['user_counts']['farmercount']; ?>
                            </h2>
                        </div>
                        <i class="fas fa-tractor"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="card-body">
                        <div>
                            <h6 class="card-title">Total Buyers</h6>
                            <h2 class="mb-0">
                            <?php echo $data['user_counts']['buyercount']; ?>
                            </h2>
                        </div>
                        <i class="fas fa-shopping-basket"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card stat-card">
                    <div class="card-body">
                        <div>
                            <h6 class="card-title">Total Farm Workers</h6>
                            <h2 class="mb-0">
                            <?php echo $data['user_counts']['workercount']; ?>
                            </h2>
                        </div>
                        <i class="fas fa-users"></i>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mb-4">
            <div class="col-md-6">
                <div class="card stat-card">
                    <div class="card-body">
                        <div>
                            <h6 class="card-title">Total Products Listed</h6>
                            <h2 class="mb-0">
                            <?php echo $data['product_count']; ?>
                            </h2>
                        </div>
                        <i class="fas fa-seedling"></i>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card stat-card">
                    <div class="card-body">
                        <div>
                            <h6 class="card-title">Total Bids Placed</h6>
                            <h2 class="mb-0">
                            <?php echo $data['bid_count']; ?>
                            </h2>
                        </div>
                        <i class="fas fa-gavel"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="quick-actions">
            <h3>Quick Actions</h3>
            <div class="action-buttons">
          <a href="<?php echo URLROOT; ?>/AdminController/UserControl" class="action-button-link">
              <div class="action-button">
            <i class="fas fa-user-cog"></i>
            <h4>Manage Users</h4>
            <p>View and manage user accounts</p>
              </div>
          </a>
          
          <a href="<?php echo URLROOT; ?>/AdminController/ModeratorReports" class="action-button-link">
              <div class="action-button">
              <i class="fas fa-flag"></i>
            <h4>Moderator Reports</h4>
            <p>View Critical Issues</p>
              </div>
          </a>
            </div>
        </div>
    </div>
  </body>
</html>
