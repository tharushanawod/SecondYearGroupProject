<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Page</title>
    <link rel="stylesheet" type="text/css" href="<?php echo URLROOT; ?>/public/css/ingredient supplier/Orders.css">
    <script src="<?php echo URLROOT; ?>/public/js/Ingredient Supplier/Orders.js" defer></script>
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet" />
</head>
<body>
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="container">
        <h1>Orders</h1>
        <div class="filter-options">
            <label for="statusFilter">Filter by Status:</label>
            <select id="statusFilter">
                <option value="all">All</option>
                <option value="pending">Pending</option>
                <option value="accepted">Accepted</option>
            </select>
        </div> 

        <table id="ordersTable">
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Product</th>
                    <th>Customer ID</th>
                    <th>Price</th>
                    <th>Payment</th>
                    <th>Quantity</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($data['orders'])): ?>
                    <?php foreach ($data['orders'] as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order->id); ?></td>
                            <td><?php echo htmlspecialchars($order->product_name); ?></td>
                            <td><?php echo htmlspecialchars($order->farmer_id); ?></td>                            
                            <td>LKR <?php echo htmlspecialchars($order->price); ?></td>
                            <td><?php echo htmlspecialchars($order->payment_status); ?></td>
                            <td><?php echo htmlspecialchars($order->quantity); ?></td>
                            <td><?php echo htmlspecialchars($order->order_status); ?></td>
                            <td class="actions">
                                <button class="accept" onclick="acceptOrder(<?php echo htmlspecialchars($order->id); ?>)">Accept</button>
                                <button class="reject" onclick="rejectOrder(<?php echo htmlspecialchars($order->id); ?>)">Reject</button>
                                <button class="view" onclick="viewOrderDetails(<?php echo htmlspecialchars($order->id); ?>)">View</button>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="8">No orders found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>

        <!-- Order Details Modal
        <div id="orderDetailsModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Order Details</h2>
                <p><strong>Customer Name:</strong> <span id="customerName"></span></p>
                <p><strong>Delivery Address:</strong> <span id="deliveryAddress"></span></p>
                <p><strong>Product Details:</strong> <span id="productDetails"></span></p>
                <p><strong>Special Instructions:</strong> <span id="specialInstructions"></span></p>
                <textarea id="rejectionReason" placeholder="Enter reason for rejection"></textarea>
                <div class="modal-actions">
                    <button id="acceptOrderBtn">Accept Order</button>
                    <button id="rejectOrderBtn">Reject Order</button>
                    <button id="closeBtn">Close</button>
                </div>
            </div>
        </div> -->
    </div>
</body>
</html>