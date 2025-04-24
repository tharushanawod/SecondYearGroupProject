<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Table with Pagination</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Moderator/Logs.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?> 
<h1> Buyer Transaction Logs</h1>
    <div class="table-container">
        <table id="logTable">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Order ID</th>
                    <th>Amount</th>
                    <th>Farmer Confirmed</th>
                    <th>Buyer Confirmed</th>
                    <th>Payment ID</th>
                    <th>wallet Status</th> 
                    <th>Withdraw Status</th> 
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
        const USERID = "<?php echo $_SESSION['user_id']; ?>";
    </script>
    <script src="<?php echo URLROOT;?>/js/Admin/BuyerTransactionLog.js"></script>
</body>
</html>
