<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Control with Pagination</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Admin/UserControl.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?> 
<h1>Account Verfication</h1>
    <div class="table-container">
        <table id="userTable">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>OTP Status</th>
                    <th>Account Status</th>
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
    <!-- Update the modal HTML -->
    <div id="restrictModal" class="modal">
        <div class="modal-content">
            <h2 id="modalTitle">Confirm Restriction</h2>
            <p id="modalMessage">Are you sure you want to restrict this user?</p>
            <div class="modal-buttons">
                <button class="cancel-restrict" onclick="closeModal()">Cancel</button>
                <button class="confirm-restrict" id="confirmRestrict">Confirm</button>
            </div>
        </div>
    </div>

    <script>
    const URLROOT = "<?php echo URLROOT; ?>";
    </script>
    <script src="<?php echo URLROOT;?>/js/Admin/VerifyUsers.js"></script>
</body>
</html>
