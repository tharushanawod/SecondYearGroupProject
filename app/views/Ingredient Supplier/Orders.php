<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Page</title>
    <link rel="stylesheet" type="text/css" href="<?php echo URLROOT;?>/public/css/ingredient supplier/Orders.css">
</head>
<body>
<?php require 'sidebar.php';?>

    
        <h1>Orders</h1>
        <div class="filter-options">
            <label for="statusFilter">Filter by Status:</label>
            <select id="statusFilter">
                <option value="all">All</option>
                <option value="pending">Pending</option>
                <option value="accepted">Accepted</option>
                <option value="delivered">Delivered</option>
            </select>
        </div>

       
        <table id="ordersTable">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product</th>
                    <th>Customer</th>
                    <th>Price</th>
                    <th>Payment</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                
            </tbody>
        </table>

        <!-- Order Details Modal -->
        <div id="orderDetailsModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Order Details</h2>
                <p><strong>Customer Name:</strong> <span id="customerName"></span></p>
                <p><strong>Delivery Address:</strong> <span id="deliveryAddress"></span></p>
                <p><strong>Product Details:</strong> <span id="productDetails"></span></p>
                <p><strong>Special Instructions:</strong> <span id="specialInstructions"></span></p>

                <div class="modal-actions">
                    <button id="acceptOrderBtn">Accept Order</button>
                    <button id="sendCodeBtn">Send Delivery Code</button>
                    <button id="closeBtn">Close</button>
                </div>
            </div>
        </div>
    
    <script src="<?php echo URLROOT;?>/js/Ingredient Supplier/Orders.js"></script>    
</body>
</html>
