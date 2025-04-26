<?php 
  $user_role = $_SESSION['user_role'];
?>

<div class="sidebar">
  <div class="logo">
    <img
      alt="Logo"
      src="<?php echo URLROOT; ?>/images/logo.png"
    />
  </div>

  <div class="menu">
    <ul>
      <li ><a href="<?php echo URLROOT; ?>/LandingController/index"><i class="fa-solid fa-house"></i><span class="menu-text">Home</span></a></li>
      
      <?php if($user_role == 'manufacturer') : ?>
        <li><a href="<?php echo URLROOT;?>/ManufacturerController/Dashboard"><i class="fa-solid fa-gauge"></i><span class="menu-text">Dashboard</span></a></li>
        <li><a href="<?php echo URLROOT;?>/ManufacturerController/setPrice"><i class="fa-solid fa-money-check-dollar"></i><span class="menu-text">Prices</span></a></li>
        <li><a href="<?php echo URLROOT;?>/ManufacturerController/StockHolders"><i class="fa-solid fa-store"></i><span class="menu-text">Stock Holders</span></a></li>
        <li><a href="<?php echo URLROOT;?>/ManufacturerController/LandingPage"><i class="fa-solid fa-chess-bishop"></i><span class="menu-text">Place Bids</span></a></li>
        <li><a href="<?php echo URLROOT;?>/ManufacturerController/BidControl"><i class="fa-solid fa-hand"></i><span class="menu-text">Bid Control</span></a></li>
        <li><a href="<?php echo URLROOT;?>/ManufacturerController/PendingPayments"><i class="fa-solid fa-clock"></i><span class="menu-text">Pending Payments</span></a></li>
        <li><a href="<?php echo URLROOT;?>/ManufacturerController/purchaseHistory"><i class="fas fa-comments"></i><span class="menu-text">Orders</span></a></li>
        <li><a href="<?php echo URLROOT;?>/ManufacturerController/RequestHelp"><i class="fa-solid fa-comment-dots"></i><span class="menu-text">Request Help</span></a></li>
        <li><a href="<?php echo URLROOT; ?>/ManufacturerController/getUnreadNotifications">
                <i class="fa-solid fa-bell"></i>
                <span class="menu-text">Notifications</span>
                <span class="notification-badge"></span>
                </a></li>         
        
        
        <?php elseif ($user_role === 'buyer'): ?>
          <li><a href="<?php echo URLROOT;?>/BuyerController/Dashboard"><i class="fa-solid fa-gauge"></i><span class="menu-text">Dashboard</span></a></li>
          <li><a href="<?php echo URLROOT;?>/BuyerController/LandingPage"><i class="fa-solid fa-chess-bishop"></i><span class="menu-text">Place Bids</span></a></li>
          <li><a href="<?php echo URLROOT;?>/BuyerController/BidControl"><i class="fa-solid fa-hand"></i><span class="menu-text">Bid Control</span></a></li>
          <li><a href="<?php echo URLROOT;?>/BuyerController/PendingPayments"><i class="fa-solid fa-clock"></i><span class="menu-text">Pending Payments</span></a></li>
          <li><a href="<?php echo URLROOT;?>/BuyerController/purchaseHistory"><i class="fas fa-comments"></i><span class="menu-text">Orders</span></a></li>
          <li><a href="<?php echo URLROOT;?>/BuyerController/RequestHelp"><i class="fa-solid fa-comment-dots"></i><span class="menu-text">Request Help</span></a></li>
            <li><a href="<?php echo URLROOT; ?>/BuyerController/getUnreadNotifications">
            <i class="fa-solid fa-bell"></i>
            <span class="menu-text">Notifications</span>
            <span class="notification-badge"></span>
            </a></li>
          
          
          <?php elseif ($user_role === 'farmer'): ?>
            <li><a href="<?php echo URLROOT;?>/FarmerController/Dashboard"><i class="fa-solid fa-gauge"></i><span class="menu-text">Dashboard</span></a></li>
            <li><a  href="<?php echo URLROOT;?>/FarmerController/GetIdea"><i class="fa-solid fa-store"></i><span class="menu-text">Products</span></a></li>
            <li><a href="<?php echo URLROOT;?>/FarmerController/orderManagement"><i class="fas fa-comments"></i><span class="menu-text">Orders</span></a></li>
            <li><a href="<?php echo URLROOT;?>/FarmerController/workerManagement"><i class="fa-solid fa-user"></i><span class="menu-text">Workers</span></a></li>
            <li><a href="<?php echo URLROOT;?>/CartController/browseProducts"><i class="fa-solid fa-flask"></i><span class="menu-text">Ingredients</span></a></li>
            <li><a href="<?php echo URLROOT;?>/FarmerController/orders"><i class="fa-solid fa-business-time"></i><span class="menu-text">My Orders</span></a></li>
             <li><a href="<?php echo URLROOT; ?>/FarmerController/getUnreadNotifications">
                <i class="fa-solid fa-bell"></i>
                <span class="menu-text">Notifications</span>
                <span class="notification-badge"></span>
                </a></li>
            <li><a href="<?php echo URLROOT;?>/FarmerController/requestHelp"><i class="fa-solid fa-comment-dots"></i><span class="menu-text">Request Help</span></a></li>
            <li><a href="<?php echo URLROOT;?>/FarmerController/Wallet"><i class="fa-solid fa-wallet"></i><span class="menu-text">Wallet</span></a></li>
           
           
            <?php elseif ($user_role === 'farmworker'): ?>
              <li><a href="<?php echo URLROOT;?>/WorkerController/dashboard"><i class="fa-solid fa-gauge"></i><span class="menu-text">Dashboard</span></a></li>
              <li><a href="<?php echo URLROOT;?>/WorkerController/jobRequest"><i class="fa-solid fa-user-tie"></i><span class="menu-text">Pending Jobs</span></a></li>
              <li><a href="<?php echo URLROOT;?>/WorkerController/DoList"><i class="fa-solid fa-list-check"></i><span class="menu-text">Accepted Jobs</span></a></li>
              <li><a href="<?php echo URLROOT;?>/WorkerController/trainingSelection"><i class="fa-solid fa-truck-monster"></i><span class="menu-text">Training</span></a></li>
              <li><a href="<?php echo URLROOT;?>/WorkerController/RequestHelp"><i class="fa-solid fa-comment-dots"></i><span class="menu-text">Request Help</span></a></li>
              <li><a href="<?php echo URLROOT; ?>/WorkerController/getUnreadNotifications">
                <i class="fa-solid fa-bell"></i>
                <span class="menu-text">Notifications</span>
                <span class="notification-badge"></span>
                </a></li>
              
              <?php elseif ($user_role === 'supplier'): ?>
                <li><a href="<?php echo URLROOT;?>/SupplierController/dashboard"><i class="fa-solid fa-gauge"></i><span class="menu-text">Dashboard</span></a></li>
                <li><a href="<?php echo URLROOT;?>/SupplierController/productManagement"><i class="fa-solid fa-store"></i><span class="menu-text">Product Control</span></a></li>
                <li><a href="<?php echo URLROOT;?>/SupplierController/viewOrders"><i class="fa-solid fa-gauge"></i><span class="menu-text">View Orders</span></a></li>
                <li><a href="<?php echo URLROOT;?>/SupplierController/RequestHelp"><i class="fa-solid fa-comment-dots"></i><span class="menu-text">Request Help</span></a></li>
                <li><a href="<?php echo URLROOT;?>/SupplierController/Wallet"><i class="fa-solid fa-wallet"></i><span class="menu-text">Wallet</span></a></li>

                <li><a href="<?php echo URLROOT; ?>/SupplierController/getUnreadNotifications">
                  <i class="fa-solid fa-bell"></i>
                  <span class="menu-text">Notifications</span>
                  <span class="notification-badge"></span>
                  </a></li>
                  
                <?php elseif ($user_role === 'moderator'): ?>
                  <li><a href="<?php echo URLROOT;?>/ModeratorController/Dashboard"><i class="fa-solid fa-gauge"></i><span class="menu-text">Dashboard</span></a></li>
                  <li><a href="<?php echo URLROOT;?>/ModeratorController/Help"><i class="fa-solid fa-comment-dots"></i><span class="menu-text">Help Center</span></a></li>
                  <li><a href="<?php echo URLROOT;?>/ModeratorController/ReportToAdmin"><i class="fas fa-user-shield"></i> <span class="menu-text">Report TO Admin</span></a></li>
                  <li><a href="<?php echo URLROOT;?>/ModeratorController/Ratings"><i class="fa-solid fa-star"></i> <span class="menu-text">Ratings</span></a></li>
                  
                  <?php else: ?>

                <li><a href="<?php echo URLROOT;?>/AdminController/Dashboard"><i class="fa-solid fa-gauge"></i><span class="menu-text">Dashboard</span></a></li>
                <li><a href="<?php echo URLROOT;?>/AdminController/UserControl"><i class="fa-solid fa-users"></i><span class="menu-text">User Control</span></a></li>
                <li><a href="<?php echo URLROOT;?>/AdminController/ModeratorControl"><i class="fa-solid fa-user-tie"></i><span class="menu-text">Moderators</span></a></li>
                <li><a href="<?php echo URLROOT;?>/AdminController/VerifyUsers"><i class="fa-solid fa-check"></i><span class="menu-text">Verify Users</span></a></li>
                <li><a href="<?php echo URLROOT;?>/AdminController/Wallet"><i class="fa-solid fa-wallet"></i><span class="menu-text">Wallet</span></a></li>
               
                <?php endif; ?>
       
      
      
    </ul>
  </div>

  <div class="profile">
  <img
    alt="Profile Picture"
    <?php $imagepath = $this->getProfileImage($_SESSION['user_id']); ?>
    height="40"
    width="40"
    style="object-fit: cover;"
    src="<?php echo $imagepath; ?>" />



  
    <div class="profile-info">
     
    
      
      <div class="name"><?php echo $_SESSION['user_name'];?></div>
      <div class="view-profile"><a href="
      <?php 
      
      if($_SESSION['user_role'] == 'manufacturer'){
        echo URLROOT.'/ManufacturerController/ManageProfile';
      }elseif($_SESSION['user_role'] == 'buyer'){
        echo URLROOT.'/BuyerController/ManageProfile';
      }elseif($_SESSION['user_role'] == 'farmer'){
        echo URLROOT.'/FarmerController/ManageProfile';
      }elseif($_SESSION['user_role'] == 'farmworker'){
        echo URLROOT.'/WorkerController/ManageProfile';
      }elseif($_SESSION['user_role'] == 'supplier'){
        echo URLROOT.'/SupplierController/ManageProfile';
      }
      elseif($_SESSION['user_role'] == 'moderator'){
        echo URLROOT.'/ModeratorController/ManageProfile';
      }
      else{
        echo URLROOT.'/AdminController/ManageProfile';
      }
      
      ?>
      
      ">View profile</a></div>
    </div>
    <div class="settings">
  <i class="fas fa-cog" onclick="toggleSettingsMenu()"></i>
  <div class="settings-menu" id="settings-menu">
    <ul>
      <li><i class="fas fa-sign-out-alt"></i><a href="<?php echo URLROOT; ?>/LandingController/logout">Logout</a></li>
      <li><i class="fas fa-bell"></i><a href="<?php 
        if($_SESSION['user_role'] == 'manufacturer'){
          echo URLROOT.'/ManufacturerController/getUnreadNotifications';
        }elseif($_SESSION['user_role'] == 'buyer'){
          echo URLROOT.'/BuyerController/getUnreadNotifications';
        }elseif($_SESSION['user_role'] == 'farmer'){
          echo URLROOT.'/FarmerController/getUnreadNotifications';
        }elseif($_SESSION['user_role'] == 'farmworker'){
          echo URLROOT.'/WorkerController/getUnreadNotifications';
        }elseif($_SESSION['user_role'] == 'supplier'){
          echo URLROOT.'/SupplierController/getUnreadNotifications';
        }else{
          echo URLROOT.'/AdminController/getUnreadNotifications';
        }
      ?>">Notifications</a></li>
    </ul>
  </div>
</div>

  </div>
</div>


<script>
  // Function to toggle the settings menu visibility
  function toggleSettingsMenu() {
    const menu = document.getElementById("settings-menu");
    menu.style.display = menu.style.display === "block" ? "none" : "block";
  }

  // Close the settings menu when clicking outside of it
  document.addEventListener("click", function (e) {
    const menu = document.getElementById("settings-menu");
    const settingsIcon = document.querySelector(".settings i");
    if (!menu.contains(e.target) && e.target !== settingsIcon) {
      menu.style.display = "none";
    }
  });

  // Function to fetch notifications from the server
  function fetchNotifications() {
    const user_id = <?php echo $_SESSION['user_id']; ?>;  // Get the user ID from PHP session
    let controller;  // Get the user role dynamically for controller
    const URLROOT = "<?php echo URLROOT; ?>";  // Get the base URL from PHP session
    const user_role = "<?php echo $_SESSION['user_role']; ?>";  // Get the user role from PHP session
    // Determine the appropriate controller based on user role
    switch(user_role) {
        case 'farmworker':
            controller = 'WorkerController';
            break;
        case 'buyer':
            controller = 'BuyerController';
            break;
        case 'farmer':
            controller = 'FarmerController';
            break;
        case 'manufacturer':
            controller = 'ManufacturerController';
            break;
        case 'supplier':
            controller = 'SupplierController';
            break;
    }

    // API call to fetch notifications
    fetch(`${URLROOT}/${controller}/getNotifications/${user_id}`)
      .then(response => {
        if (!response.ok) {
          throw new Error(`HTTP error! status: ${response.status}`);
        }
        return response.json();  // Parse JSON response
      })
      .then(notifications => {
        if (!Array.isArray(notifications)) {
          console.error('Invalid notifications data:', notifications);
          return;
        }
        displayNotificationCount(notifications);
      })
      .catch(error => {
        console.error('Error fetching notifications:', error);
        displayNotificationCount([]);
      });
  }

  // Function to display the count of unread notifications
  function displayNotificationCount(notifications) {
    const unreadCount = notifications.filter(n => !n.is_read).length;  // Count unread notifications
    const notifCountElement = document.querySelector('.notification-badge');  // Find the element to display count
    console.log('Unread notifications:', unreadCount);  // Log unread count for debugging

    // If there are unread notifications, show the count
    if (unreadCount > 0) {
      notifCountElement.textContent = unreadCount;
      notifCountElement.style.display = 'inline';  // Show the badge if there are unread notifications
    } else {
      notifCountElement.style.display = 'none';  // Hide the badge if there are no unread notifications
    }
  }

  // Fetch notifications when the page loads
  document.addEventListener('DOMContentLoaded', fetchNotifications);
</script>

