<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Table with Pagination</title>
  <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Ingredient Supplier/OrdersManagement.css">
  <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?> 

  <div class="table-container">
    <div class="header-container">
      <h1>Pending Orders</h1>
      
    </div>
    <table id="orderTable">
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Order Details</th>
          <th>Delivery Details</th>
          <th>Payment Status</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody>
        <!-- Rows will be dynamically inserted here -->
      </tbody>
    </table>
    <div class="pagination">
      <button id="prevBtn">Previous</button>
      <span id="pageInfo"></span>
      <button id="nextBtn">Next</button>
    </div>
  </div>

  <div class="modal-overlay" id="buyerModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Buyer Details</h3>
            <button class="close-modal" onclick="closeBuyerModal()">&times;</button>
        </div>
        <div class="modal-body" id="buyerDetailsContent">
            <!-- Content will be dynamically inserted here -->
        </div>
        <div class="modal-footer">
            <button class="modal-btn modal-btn-primary" onclick="closeBuyerModal()">Close</button>
        </div>
    </div>
</div>

<div class="modal-overlay" id="orderDetailsModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Order Details</h3>
            <button class="close-modal" onclick="closeOrderDetailsModal()">&times;</button>
        </div>
        <div class="modal-body" id="orderDetailsContent">
            <!-- Content will be dynamically inserted here -->
            <div class="order-item-container">
                <!-- Order items will appear here -->
            </div>
            <div class="order-summary">
                <!-- Order summary information will appear here -->
            </div>
        </div>
        <div class="modal-footer">
            <button class="modal-btn modal-btn-primary" onclick="closeOrderDetailsModal()">Close</button>
        </div>
    </div>
</div>
<script>
  const URLROOT = "<?php echo URLROOT; ?>";
  const USERID = "<?php echo $_SESSION['user_id']; ?>";
</script>
 <script src="<?php echo URLROOT;?>/js/Ingredient Supplier/PendingOrders.js"></script>
</body>
</html>