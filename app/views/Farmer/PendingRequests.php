<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Pending Job requests</title>
  <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/OrdersManagement.css">
  <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?> 

  <div class="table-container">
  <h1>Pending Job Requests</h1>
    <table id="Table">
      <thead>
        <tr>
          <th>Request ID</th>
          <th>Worker Name</th>
          <th>Status</th>
          <th>Start Date</th>
          <th>End Date</th>
          <th>Contact Number</th>
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
<script>
  const URLROOT = "<?php echo URLROOT; ?>";
</script>
 <script src="<?php echo URLROOT;?>/js/Farmer/PendingRequests.js"></script>
</body>
</html>