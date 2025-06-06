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
<h1>Moderator Reports</h1>
    <div class="table-container">
        <table id="logTable">
            <thead>
                <tr>
                    <?php echo date('Y-m-d H:i:s'); ?>
                    <th>User ID</th>
                    <th>Moderator ID</th>
                    <th>Comments</th>
                    <th>Log Time</th>
                    <th>View Logs</th>
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
    <script src="<?php echo URLROOT;?>/js/Admin/ModeratorReports.js"></script>
</body>
</html>
