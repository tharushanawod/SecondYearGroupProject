<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="url-root" content="<?php echo URLROOT; ?>">
    <title>Orders Page</title>
    <link rel="stylesheet" type="text/css" href="<?php echo URLROOT; ?>/public/css/ingredient supplier/Orders.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet" />  
</head>
<body>
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="container">
        <h1>Orders</h1>
        <div class="filter-options">            
            <form method="GET" action="<?php echo URLROOT; ?>/SupplierController/viewOrders">
                <select id="statusFilter" name="status">
                    <option value="all">All</option>
                    <option value="pending">Pending</option>
                    <option value="accepted">Accepted</option>
                </select>
                <button type="submit">Filter</button>
            </form>
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
                                <form method="POST" action="<?php echo URLROOT; ?>/SupplierController/acceptOrder/<?php echo htmlspecialchars($order->id); ?>">
                                    <button type="submit" class="accept">Accept</button>
                                </form>
                                <button class="reject" onclick="openRejectModal(<?php echo htmlspecialchars($order->id); ?>)">Reject</button>
                                <button class="view" onclick="openViewModal(<?php echo htmlspecialchars($order->id); ?>)">View</button>
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

        <!-- Order Details Modal -->
        <div id="orderDetailsModal" class="modal">
            <div class="modal-content"> 
                <span class="close" onclick="closeModal('orderDetailsModal')">&times;</span>           
                <h2>Order Details</h2>
                <p><strong>Order ID:</strong> <span id="orderId"></span></p>
                <p><strong>Product:</strong> <span id="productName"></span></p>
                <p><strong>Customer ID:</strong> <span id="customerId"></span></p>
                <p><strong>Price:</strong> LKR <span id="price"></span></p>
                <p><strong>Quantity:</strong> <span id="quantity"></span></p>
                <p><strong>Order Status:</strong> <span id="orderStatus"></span></p>
                <p><strong>Payment Status:</strong> <span id="paymentStatus"></span></p>
                <p><strong>Created At:</strong> <span id="createdAt"></span></p>
                <p id="rejectionReasonContainer" style="display: none;"><strong>Rejection Reason:</strong> <span id="rejectionReason"></span></p>
            </div>
        </div>

        <!-- Reject Order Modal -->
        <div id="rejectOrderModal" class="modal">
            <div class="modal-content">
                <span class="close" onclick="closeModal('rejectOrderModal')">&times;</span>
                <h2>Reject Order</h2>
                <form method="POST" action="<?php echo URLROOT; ?>/SupplierController/rejectOrder">
                    <input type="hidden" id="rejectOrderId" name="order_id">
                    <textarea name="rejection_reason" placeholder="Enter reason for rejection" required></textarea>
                    <button type="submit">Submit</button>
                </form>
            </div>
        </div>
    </div>
    <script src="<?php echo URLROOT; ?>/public/js/Ingredient Supplier/Orders.js"></script>
</body>
</html>