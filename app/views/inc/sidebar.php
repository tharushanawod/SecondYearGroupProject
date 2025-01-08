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
          <li><a href="<?php echo URLROOT;?>/BuyerController/cancelBid"><i class="fa-solid fa-hand"></i><span class="menu-text">Bid Control</span></a></li>
          <li><a href="<?php echo URLROOT;?>/BuyerController/payment"><i class="fa-solid fa-clock"></i><span class="menu-text">Pending Payments</span></a></li>
          <li><a href="<?php echo URLROOT;?>/BuyerController/purchaseHistory"><i class="fas fa-comments"></i><span class="menu-text">Orders</span></a></li>
          <li><a href="<?php echo URLROOT;?>/BuyerController/RequestHelp"><i class="fa-solid fa-comment"></i><span class="menu-text">Chat</span></a></li>
          
          
          <?php elseif ($user_role === 'farmer'): ?>
            <li><a href="<?php echo URLROOT;?>/FarmerController/Dashboard"><i class="fa-solid fa-gauge"></i><span class="menu-text">Dashboard</span></a></li>
            <li><a href="<?php echo URLROOT;?>/FarmerController/AddProduct"><i class="fa-solid fa-store"></i><span class="menu-text">Products</span></a></li>
            <li><a href="<?php echo URLROOT;?>/FarmerController/orderManagement"><i class="fas fa-comments"></i><span class="menu-text">Orders</span></a></li>
            <li><a href="<?php echo URLROOT;?>/FarmerController/workerManagemen"><i class="fa-solid fa-user"></i><span class="menu-text">Workers</span></a></li>
            <li><a href="<?php echo URLROOT;?>/FarmerController/BuyIngredients"><i class="fa-solid fa-flask"></i><span class="menu-text">Ingredients</span></a></li>
            <li><a href="<?php echo URLROOT;?>/FarmerController/inventory"><i class="fa-solid fa-business-time"></i><span class="menu-text">My Orders</span></a></li>
            <li><a href="<?php echo URLROOT;?>/FarmerController/requestHelp"><i class="fa-solid fa-comment"></i><span class="menu-text">Chat</span></a></li>
           
           
            <?php elseif ($user_role === 'farmworker'): ?>
              <li><a href="<?php echo URLROOT;?>/WorkerController/dashboard"><i class="fa-solid fa-gauge"></i><span class="menu-text">Dashboard</span></a></li>
              <li><a href="<?php echo URLROOT;?>/WorkerController/jobRequest"><i class="fa-solid fa-user-tie"></i><span class="menu-text">Jobs</span></a></li>
              <li><a href="<?php echo URLROOT;?>/WorkerController/trainingSelection"><i class="fa-solid fa-truck-monster"></i><span class="menu-text">Training</span></a></li>
              <li><a href="<?php echo URLROOT;?>/WorkerController/RequestHelp"><i class="fa-solid fa-comment"></i><span class="menu-text">Chat</span></a></li>
              
              
              <?php else: ?>
                <li><a href="<?php echo URLROOT;?>/SupplierController/dashboard"><i class="fa-solid fa-gauge"></i><span class="menu-text">Dashboard</span></a></li>
                <li><a href="<?php echo URLROOT;?>/SupplierController/shop"><i class="fa-solid fa-gauge"></i><span class="menu-text">Products</span></a></li>
                <li><a href="<?php echo URLROOT;?>/SupplierController/productManagement"><i class="fa-solid fa-gauge"></i><span class="menu-text">Product Control</span></a></li>
                <li><a href="<?php echo URLROOT;?>/SupplierController/viewOrders"><i class="fa-solid fa-gauge"></i><span class="menu-text">View Orders</span></a></li>
                <li><a href="<?php echo URLROOT;?>/SupplierController/RequestHelp"><i class="fa-solid fa-gauge"></i><span class="menu-text">Chat</span></a></li>
                
              <?php endif; ?>
       

      
      
    </ul>
  </div>

  <div class="profile">
    <img
      alt="Profile Picture"
      height="40"
      width="40"
      src="https://storage.googleapis.com/a1aa/image/3nj5elSPqtzAfE0A1gunUEeeP7xlqGODBcFraf3sS6MndUWgC.jpg"
    />
    <div class="profile-info">
      <div class="name"><?php echo $_SESSION['user_name']; ?></div>
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
      }else{
        echo URLROOT.'/SupplierController/ManageProfile';
      }
      
      ?>
      
      ">View profile</a></div>
    </div>
    <div class="settings">
      <i class="fas fa-cog"></i>
    </div>
  </div>
</div>
