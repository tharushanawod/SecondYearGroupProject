<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders Page</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/OrdersManagement.css">
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>

    <div class="container">
        <h1>Orders From Buyers</h1>

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
                        <th>Buyer</th>
                        <th> Unit Price(Rs)</th>
                        <th>Quantity (kg)</th>
                        <th>Status</th>
                      
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>Dry Corn</td>
                        <td>Dasanayaka</td>
                        <td>100</td>
                        <td>200 kg</td>
                        <td>Pending</td>
                      
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Sweet Corn</td>
                        <td>N.M Herath</td>
                        <td>120</td>
                        <td>50 kg</td>
                        <td>Accepted</td>
                       
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Dry Cornd</td>
                        <td>H.K Gajasinghe</td>
                        <td>89</td>
                        <td>250 kg</td>
                        <td>Accepted</td>
                      
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>Sweet Corn</td>
                        <td>N.B Asanka</td>
                        <td>99</td>
                        <td>300 kg</td>
                        <td>Pending</td>
                       
                    </tr>
                    <!-- Add remaining orders similarly -->
                </tbody>
            </table>

         
        </div>
    </div>
</body>
</html>
