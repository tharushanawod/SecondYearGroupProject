<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Table with Pagination</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Manufacturer/PendingPayments.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
    <style>
    /* ... existing styles ... */

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

    .farmer-detail {
        display: flex;
        margin-bottom: 20px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eef2f7;
    }

    .farmer-detail:last-child {
        border-bottom: none;
        margin-bottom: 0;
        padding-bottom: 0;
    }

    .detail-icon {
        width: 40px;
        height: 40px;
        background: #f0fff4;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 15px;
        color: #2e8b57;
    }

    .detail-content h4 {
        color: #64748b;
        font-size: 14px;
        margin-bottom: 5px;
    }

    .detail-content p {
        color: #1e293b;
        font-size: 16px;
        font-weight: 500;
        margin: 0;
    }

    .location-map {
        margin-top: 20px;
        height: 200px;
        background: #f8fafc;
        border-radius: 8px;
        overflow: hidden;
    }

    @keyframes fadeIn {
        from { opacity: 0; }
        to { opacity: 1; }
    }

    @keyframes slideIn {
        from {
            transform: translateY(-20px);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
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
<h1>Orders</h1>
    <div class="table-container">
        <table id="orderTable">
            <thead>
                <tr>
                    <th>Transaction ID</th>
                    <th>Quantity</th>
                    <th>Paid Amount</th>
                    <th>Total Amount</th>
                    <th>Farmer's Details</th>
                    <th>Farmer Confirmation</th>
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

    <!-- Add this modal HTML before the closing body tag -->
<div class="modal-overlay" id="farmerModal">
    <div class="modal-content">
        <div class="modal-header">
            <h3>Farmer Details</h3>
            <button class="close-modal" onclick="closeFarmerModal()">&times;</button>
        </div>
        <div class="modal-body" id="farmerDetailsContent">
            <!-- Content will be dynamically inserted here -->
        </div>
        <div class="modal-footer">
            <button class="modal-btn modal-btn-primary" onclick="closeFarmerModal()">Close</button>
        </div>
    </div>
</div>

    <script>
        const URLROOT = "<?php echo URLROOT; ?>";
        const USERID = "<?php echo $_SESSION['user_id']; ?>";
    </script>
    <script src="<?php echo URLROOT;?>/js/Manufacturer/PurchaseHistory.js"></script>
</body>
</html>
