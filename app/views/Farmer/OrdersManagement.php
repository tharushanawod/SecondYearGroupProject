<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Table with Pagination</title>
  <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/OrdersManagement.css">
  <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
  <style>
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 1000;
        animation: fadeIn 0.3s ease;
    }

    .modal-content {
        background: white;
        width: 90%;
        max-width: 500px;
        margin: 50px auto;
        border-radius: 12px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.15);
        animation: slideIn 0.3s ease;
        overflow: hidden;
    }

    .modal-header {
        background: #2e8b57;
        color: white;
        padding: 20px;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .modal-header h3 {
        margin: 0;
        font-size: 20px;
        font-weight: 600;
    }

    .close-modal {
        background: none;
        border: none;
        color: white;
        font-size: 24px;
        cursor: pointer;
        transition: transform 0.2s ease;
    }

    .close-modal:hover {
        transform: rotate(90deg);
    }

    .modal-body {
        padding: 25px;
    }

    .modal-body p {
        margin-bottom: 15px;
        line-height: 1.5;
    }

    .modal-body p:last-child {
        margin-bottom: 0;
    }

    /* Warning text styling */
    .warning-text {
        background-color: #ffebee;
        border-left: 4px solid #d32f2f;
        padding: 12px 15px;
        margin: 15px 0;
        border-radius: 4px;
        color: #d32f2f;
        font-weight: 500;
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
    }

    .warning-text i {
        margin-right: 8px;
        color: #d32f2f;
    }

    .modal-footer {
        padding: 20px;
        background: #f8fafc;
        text-align: right;
        border-top: 1px solid #eef2f7;
    }

    .modal-btn {
        padding: 10px 20px;
        border-radius: 6px;
        font-size: 14px;
        font-weight: 500;
        cursor: pointer;
        transition: all 0.3s ease;
    }

    .modal-btn-primary {
        background: #2e8b57;
        color: white;
        border: none;
    }

    .modal-btn-primary:hover {
        background: #246c44;
        transform: translateY(-1px);
    }
  </style>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?> 

  <div class="table-container">
  <h1>Orders</h1>
  <div class="search-container">
  <input type="text" id="orderIdSearch" placeholder="Search by Order ID">
</div>

    <table id="orderTable">
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Quantity (kg)</th>
          <th>Unit Price (Rs)</th>
          <th>Payment to Receive</th>
          <th>Buyer Details</th>
          <th>Payment Status</th>
          <th>Buyer Confirmation</th>
          <th>Your Confirmation</th>
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
<script>
  const URLROOT = "<?php echo URLROOT; ?>";
  const USERID = "<?php echo $_SESSION['user_id']; ?>";
</script>
 <script src="<?php echo URLROOT;?>/js/Farmer/OrdersManagement.js"></script>

    <!-- Add confirmation modal -->
    <div class="modal-overlay" id="confirmationModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Confirm Delivery</h3>
                <button class="close-modal" onclick="closeConfirmationModal()">&times;</button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to confirm this delivery?</p>
                <p class="warning-text">
                    <i class="fas fa-exclamation-triangle"></i>
                    Please confirm that you have delivered the products to the buyer. Payment will be processed only after both you and the buyer have confirmed the delivery.
                </p>
            </div>
            <div class="modal-footer">
                <button class="modal-btn" onclick="closeConfirmationModal()">Cancel</button>
                <button class="modal-btn modal-btn-primary" id="confirmDeliveryBtn">Confirm</button>
            </div>
        </div>
    </div>
</body>
</html>