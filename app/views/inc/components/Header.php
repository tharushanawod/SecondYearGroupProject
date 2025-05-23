
  <header>
    <nav>
        <a href="#" class="logo"><img src="<?php echo URLROOT; ?>/images/logo.png" alt="logomy" /></a>
      <ul>
        <li><a href="<?php echo URLROOT; ?>/LandingController/index">Home</a></li>
        <li><a href="<?php echo URLROOT; ?>/LandingController/Aboutus">About Us</a></li>
        <li><a href="<?php echo URLROOT; ?>/LandingController/Auction">Auction</a></li>
        <li><a href="mailto:CornCradle@gmail.com?subject=Contact%20Us&body=Hello,%20I%20would%20like%20to%20contact%20you.">Contact Us</a></li>
      </ul>
      <?php if (isset($_SESSION['user_id'])) : ?>
    <?php 
        // Example role values: 'admin', 'farmer', 'buyer'
        $role = $_SESSION['user_role']; 
        $dashboardController = '';

        // Dynamically determine the controller based on the role
        switch ($role) {
            case 'admin':
                $dashboardController = 'AdminController';
                break;
            case 'farmer':
                $dashboardController = 'FarmerController';
                break;
            case 'buyer':
                $dashboardController = 'BuyerController';
                break;
            case 'manufacturer':
                $dashboardController = 'ManufacturerController';
                break;
            case 'supplier':
                $dashboardController = 'SupplierController';
                break;
            case 'farmworker':
                $dashboardController = 'WorkerController';
                break;
            case 'moderator':
                $dashboardController = 'ModeratorController';
                break;
            default:
                $dashboardController = 'LandingController';
        }
    ?>
    <div class="buttons">
    <a href="<?php echo URLROOT; ?>/<?php echo $dashboardController; ?>/Dashboard" class="sign-up-btn">
    <i class="fas fa-tachometer-alt"></i> Dashboard</a>
    <a href="<?php echo URLROOT; ?>/LandingController/logout" class="sign-up-btn"><i class="fas fa-sign-out-alt"></i>Logout</a>
  
    </div>
    
<?php else : ?>
  <div class="buttons">
  <a href="<?php echo URLROOT; ?>/LandingController/Register" class="sign-up-btn">Sign Up</a>
  <a href="<?php echo URLROOT; ?>/LandingController/login" class="sign-up-btn">Login</a>
  </div>
    
<?php endif; ?>

    </nav>
  </header>
