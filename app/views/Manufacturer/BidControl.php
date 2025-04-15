<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Table with Pagination</title>
  <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/BidControl.css">
  <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
  <div class="table-container">
  <h1>Orders</h1>
    <table id="bidsTable">
      <thead>
        <tr>
          <th>Bid ID</th>
          <th>Your Bid</th>
          <th>Current Highest Bid</th>
          <th>Remaining Time</th>
          <th>Quantity (kg)</th>
          <th>Actions</th>
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

  <!-- Confirmation Popup -->
  <div class="popup-overlay" id="popupOverlay">
    <div class="popup">
      <h3>Are you sure you want to cancel this bid?</h3>
      <button class="confirm" id="confirmCancel">Yes, Cancel</button>
      <button class="cancel" id="closePopup">No, Keep Bid</button>
    </div>
  </div>

<script>
  const URLROOT = "<?php echo URLROOT; ?>";
  const USERID = "<?php echo $_SESSION['user_id']; ?>";
</script>
<script src="<?php echo URLROOT;?>/js/Buyer/BidControl.js"></script>
</body>
</html>
