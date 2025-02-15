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
        <li><a href="<?php echo URLROOT;?>/ManufacturerController/AddPrices"><i class="fa-solid fa-money-check-dollar"></i><span class="menu-text">Prices</span></a></li>
        <li><a href="<?php echo URLROOT;?>/ManufacturerController/StockHolders"><i class="fa-solid fa-store"></i><span class="menu-text">Stock Holders</span></a></li>
        <li><a href="<?php echo URLROOT;?>/ManufacturerController/requestHelp"><i class="fa-solid fa-comment"></i><span class="menu-text">Chat</span></a></li>
        
        
        <?php elseif ($user_role === 'buyer'): ?>
          <li><a href="<?php echo URLROOT;?>/BuyerController/Dashboard"><i class="fa-solid fa-gauge"></i><span class="menu-text">Dashboard</span></a></li>
          <li><a href="<?php echo URLROOT;?>/BuyerController/LandingPage"><i class="fa-solid fa-chess-bishop"></i><span class="menu-text">Place Bids</span></a></li>
          <li><a href="<?php echo URLROOT;?>/BuyerController/BidControl"><i class="fa-solid fa-hand"></i><span class="menu-text">Bid Control</span></a></li>
          <li><a href="<?php echo URLROOT;?>/BuyerController/PendingPayment"><i class="fa-solid fa-clock"></i><span class="menu-text">Pending Payments</span></a></li>
          <li><a href="<?php echo URLROOT;?>/BuyerController/purchaseHistory"><i class="fas fa-comments"></i><span class="menu-text">Orders</span></a></li>
          <li><a href="<?php echo URLROOT;?>/BuyerController/RequestHelp"><i class="fa-solid fa-comment"></i><span class="menu-text">Chat</span></a></li>
          
          
          <?php elseif ($user_role === 'farmer'): ?>
            <li><a href="<?php echo URLROOT;?>/FarmerController/Dashboard"><i class="fa-solid fa-gauge"></i><span class="menu-text">Dashboard</span></a></li>
            <li><a  href="<?php echo URLROOT;?>/FarmerController/GetIdea"><i class="fa-solid fa-store"></i><span class="menu-text">Products</span></a></li>
            <li><a href="<?php echo URLROOT;?>/FarmerController/orderManagement"><i class="fas fa-comments"></i><span class="menu-text">Orders</span></a></li>
            <li><a href="<?php echo URLROOT;?>/FarmerController/workerManagement"><i class="fa-solid fa-user"></i><span class="menu-text">Workers</span></a></li>
            <li><a href="<?php echo URLROOT;?>/FarmerController/BuyIngredients"><i class="fa-solid fa-flask"></i><span class="menu-text">Ingredients</span></a></li>
            <li><a href="<?php echo URLROOT;?>/FarmerController/inventory"><i class="fa-solid fa-business-time"></i><span class="menu-text">My Orders</span></a></li>
            <li><a href="<?php echo URLROOT;?>/FarmerController/requestHelp"><i class="fa-solid fa-comment"></i><span class="menu-text">Chat</span></a></li>
           
           
            <?php elseif ($user_role === 'farmworker'): ?>
              <li><a href="<?php echo URLROOT;?>/WorkerController/dashboard"><i class="fa-solid fa-gauge"></i><span class="menu-text">Dashboard</span></a></li>
              <li><a href="<?php echo URLROOT;?>/WorkerController/jobRequest"><i class="fa-solid fa-user-tie"></i><span class="menu-text">Jobs</span></a></li>
              <li><a href="<?php echo URLROOT;?>/WorkerController/DoList"><i class="fa-solid fa-list-check"></i><span class="menu-text">Do List</span></a></li>

              <li><a href="<?php echo URLROOT;?>/WorkerController/trainingSelection"><i class="fa-solid fa-truck-monster"></i><span class="menu-text">Training</span></a></li>
              <li><a href="<?php echo URLROOT;?>/WorkerController/RequestHelp"><i class="fa-solid fa-comment"></i><span class="menu-text">Chat</span></a></li>
              
              
              <?php elseif ($user_role === 'supplier'): ?>
                <li><a href="<?php echo URLROOT;?>/SupplierController/dashboard"><i class="fa-solid fa-gauge"></i><span class="menu-text">Dashboard</span></a></li>
                <li><a href="<?php echo URLROOT;?>/SupplierController/shop"><i class="fa-solid fa-gauge"></i><span class="menu-text">Products</span></a></li>
                <li><a href="<?php echo URLROOT;?>/SupplierController/productManagement"><i class="fa-solid fa-gauge"></i><span class="menu-text">Product Control</span></a></li>
                <li><a href="<?php echo URLROOT;?>/SupplierController/viewOrders"><i class="fa-solid fa-gauge"></i><span class="menu-text">View Orders</span></a></li>
                <li><a href="<?php echo URLROOT;?>/SupplierController/RequestHelp"><i class="fa-solid fa-gauge"></i><span class="menu-text">Chat</span></a></li>
                
                <?php else: ?>
                <li><a href="<?php echo URLROOT;?>/AdminController/Dashboard"><i class="fa-solid fa-gauge"></i><span class="menu-text">Dashboard</span></a></li>
                <li><a href="<?php echo URLROOT;?>/AdminController/Manageprofile"><i class="fa-solid fa-user"></i><span class="menu-text">Profile</span></a></li>
                <li><a href="<?php echo URLROOT;?>/AdminController/RemoveUsers"><i class="fa-solid fa-users"></i><span class="menu-text">Users</span></a></li>
                <li><a href="<?php echo URLROOT;?>/AdminController/UpdateUsers"><i class="fa-solid fa-refresh"></i><span class="menu-text">Update Users</span></a></li>
                <li><a href="<?php echo URLROOT;?>/AdminController/AddModerators"><i class="fa-solid fa-user-tie"></i><span class="menu-text">Moderators</span></a></li>
                <li><a href="<?php echo URLROOT;?>/AdminController/getManufacturers"><i class="fa-solid fa-check"></i><span class="menu-text">Verify Users</span></a></li>
                <li><a href="<?php echo URLROOT;?>/AdminController/Report"><i class="fa-solid fa-chart-bar"></i><span class="menu-text">Reports</span></a></li>  
              
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
      <li><i class="fas fa-bell"></i><a href="<?php echo URLROOT; ?>/NotificationController/index">Notifications</a></li>
    </ul>
  </div>
</div>

  </div>
</div>

<script>
  function toggleSettingsMenu() {
  const menu = document.getElementById("settings-menu");
  menu.style.display = menu.style.display === "block" ? "none" : "block";
}

document.addEventListener("click", function (e) {
  const menu = document.getElementById("settings-menu");
  const settingsIcon = document.querySelector(".settings i");
  if (!menu.contains(e.target) && e.target !== settingsIcon) {
    menu.style.display = "none";
  }
});

</script>