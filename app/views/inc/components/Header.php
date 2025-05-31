
  <header class="modern-header">
    <div class="header-container">
        <div class="header-content">
            <!-- Logo Section -->
            <div class="logo-section">
                <a href="<?php echo URLROOT; ?>/LandingController/index" class="logo-link">
                    <img src="<?php echo URLROOT; ?>/images/logo.png" alt="CornCradle Logo" class="logo-img" />
                </a>
            </div>

            <!-- Navigation Section -->
            <nav class="main-nav">
                <a href="<?php echo URLROOT; ?>/LandingController/index" class="nav-link">Home</a>
                <a href="<?php echo URLROOT; ?>/LandingController/Auction" class="nav-link">How it Works</a>
                <a href="<?php echo URLROOT; ?>/LandingController/Aboutus" class="nav-link">About Us</a>
                <a href="mailto:CornCradle@gmail.com?subject=Contact%20Us&body=Hello,%20I%20would%20like%20to%20contact%20you." class="nav-link">Contact Us</a>
            </nav>

            <!-- Auth Section -->
            <div class="auth-section">
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
                    <a href="<?php echo URLROOT; ?>/<?php echo $dashboardController; ?>/Dashboard" class="btn-dashboard">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                    <a href="<?php echo URLROOT; ?>/LandingController/logout" class="btn-logout">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </a>
                <?php else : ?>
                    <a href="<?php echo URLROOT; ?>/LandingController/login" class="btn-login">Login</a>
                    <a href="<?php echo URLROOT; ?>/LandingController/Register" class="btn-signup">Sign Up</a>
                <?php endif; ?>
            </div>

            <!-- Mobile Menu Button -->
            <button class="mobile-menu-btn" onclick="toggleMobileMenu()">
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
                <span class="hamburger-line"></span>
            </button>
        </div>

        <!-- Mobile Navigation -->
        <div class="mobile-nav" id="mobileNav">
            <a href="<?php echo URLROOT; ?>/LandingController/index" class="mobile-nav-link">Home</a>
            <a href="<?php echo URLROOT; ?>/LandingController/Auction" class="mobile-nav-link">How it Works</a>
            <a href="<?php echo URLROOT; ?>/LandingController/Aboutus" class="mobile-nav-link">About Us</a>
            <a href="mailto:CornCradle@gmail.com?subject=Contact%20Us&body=Hello,%20I%20would%20like%20to%20contact%20you." class="mobile-nav-link">Contact Us</a>
            
            <?php if (isset($_SESSION['user_id'])) : ?>
                <a href="<?php echo URLROOT; ?>/<?php echo $dashboardController; ?>/Dashboard" class="mobile-nav-link">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>
                <a href="<?php echo URLROOT; ?>/LandingController/logout" class="mobile-nav-link">
                    <i class="fas fa-sign-out-alt"></i> Logout
                </a>
            <?php else : ?>
                <a href="<?php echo URLROOT; ?>/LandingController/login" class="mobile-nav-link">Login</a>
                <a href="<?php echo URLROOT; ?>/LandingController/Register" class="mobile-nav-link">Sign Up</a>
            <?php endif; ?>
        </div>
    </div>
</header>
