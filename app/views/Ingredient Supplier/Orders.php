<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Page</title>
    <link rel="stylesheet" type="text/css" href="<?php echo URLROOT;?>/public/css/ingredient supplier/Orders.css">
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
                <th>Customer</th>
                <th>Price</th>
                <th>Payment</th>
                <th>Quantity</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data['orders'] as $order): ?>
                <tr>
                    <td><?php echo $order->id; ?></td>
                    <td><?php echo $order->product_name; ?></td>
                    <td><?php echo $order->farmer_id; ?></td>
                    <td><?php echo $order->price; ?></td>
                    <td><?php echo $order->payment_status; ?></td>
                    <td><?php echo $order->quantity; ?></td>
                    <td><?php echo $order->order_status; ?></td>
                    <td class="actions">
                        <button class="accept">Accept</button>
                        <button class="send-code">Cancel</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</div>
<script src="<?php echo URLROOT; ?>/public/js/ingredient supplier/Orders.js"></script>
</body>
</html>