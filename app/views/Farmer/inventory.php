<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>inventory</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/OrdersManagement.css">
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
<div class="container">
        <h1>Ingredients Orders</h1>

        <div class="main-container">
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
                        <th>Supplier</th>
                        <th>Price(Rs)</th>
                        <th>Items</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>UREA</td>
                        <td>Dasanayaka</td>
                        <td>2900</td>
                        <td>2</td>
                        <td>Pending</td>
                        <td class="actions">
                            <button class="accept">Confirm Delivery</button>
                            <button class="send-code">Cancel Order</button>
                    
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>FABIA PestControl</td>
                        <td>N.M Herath</td>
                        <td>1200</td>
                        <td>5</td>
                        <td>Accepted</td>
                        <td class="actions">
                        <button class="accept">Confirm Delivery</button>
                            <button class="send-code">Cancel Order</button>
                    
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>666 Hybrid seeds</td>
                        <td>H.K Gajasinghe</td>
                        <td>8989</td>
                        <td>2</td>
                        <td>Accepted</td>
                        <td class="actions">
                        <button class="accept">Confirm Delivery</button>
                            <button class="send-code">Cancel Order</button>
                    
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>ACELA liquid Fertilizer</td>
                        <td>N.B Asanka</td>
                        <td>9670</td>
                        <td>3</td>
                        <td>Pending</td>
                        <td class="actions">
                        <button class="accept">Confirm Delivery</button>
                            <button class="send-code">Cancel Order</button>
                    
                        </td>
                    </tr>
                    <!-- Add remaining orders similarly -->
                </tbody>
            </table>

         
        </div>
    </div>
    
</body>
</html>