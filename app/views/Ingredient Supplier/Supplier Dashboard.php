<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Ingredient Supplier/Supplier Dashboard.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet" />
</head>
<body>
    <div class="dashboard-container">
        
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>

        <div class="main-content">
            <div class="main-content-header">
                <h1 >Supplier Dashboard</h1>
            </div>

            <div class="cardBox">
                <div class="card">
                    <div class="icon"><img width="50" height="50" src="https://img.icons8.com/ios/50/clock--v1.png" alt="clock--v1"/></div>
                    <div>
                        <div class="numbers"><?php echo $data['pendingOrders']; ?></div>
                        <div class="cardName">Pending Orders</div>
                    </div>
                </div>

                <div class="card">
                    <div class="icon"><img width="50" height="50" src="https://img.icons8.com/ios/50/bullish--v1.png" alt="bullish--v1"/></div>
                    <div>
                        <div class="numbers">80</div>
                        <div class="cardName">Sales</div>
                    </div>
                </div>

                <div class="card">
                    <div class="icon"><img width="64" height="64" src="https://img.icons8.com/sf-black-filled/64/crowd.png" alt="crowd"/></div>                    
                    <div>
                        <div class="numbers">50</div>
                        <div class="cardName">Customers</div>
                    </div>
                </div>

                <div class="card">
                    <div class="icon"><img width="50" height="50" src="https://img.icons8.com/ios/50/us-dollar-circled--v2.png" alt="us-dollar-circled--v2"/></div>
                    <div>
                        <div class="numbers">LKR 77,842</div>
                        <div class="cardName">Earning</div>
                    </div>
                </div>
            </div>

           
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Recent Orders</h2>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Order ID</td>
                                <td>Customer Name</td>
                                <td>Order Date</td>
                                <td>Total Amount</td>
                                <td>Status</td>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $orders = $data['recentOrders'];
                            foreach($orders as $order): ?>
                            <tr>
                                <td><?php echo $order->order_id; ?></td>
                                <td><?php echo $order->customer_name; ?></td>
                                <td><?php echo date('Y-m-d', strtotime($order->order_date)); ?></td>
                                <td><?php echo $order->total_amount; ?></td>
                                <td><span class="<?php echo strtolower($order->status); ?>"><?php echo $order->status; ?></span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
                
                

                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>Recent Customers</h2>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <td>Customer ID</td>
                                <td>Customer Name</td>
                                <td>Contact</td>
                                <td>Location</td>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($data['recentCustomers'] as $customer): ?>
                            <tr>
                                <td><?php echo $customer->customer_id; ?></td>
                                <td><?php echo $customer->customer_name; ?></td>
                                <td><?php echo $customer->contact; ?></td>
                                <td><?php echo $customer->location; ?></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>   
</body>
</html>