<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/FarmWorker/dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        
    <?php require 'sidebar.php';?>

        <div class="main-content">
            <div class="main-content-header">
                <h1>Dashboard</h1>
            </div>

            <div class="cardBox">
                <div class="card">
                    <div class="image"><img width="50" height="50" src="https://img.icons8.com/external-neu-royyan-wijaya/50/external-accepted-neu-business-and-finance-neu-royyan-wijaya.png" alt="external-accepted-neu-business-and-finance-neu-royyan-wijaya"/></div>
                    <div>
                        <div class="numbers">50</div>
                        <div class="cardName">Accepted Requests</div>
                    </div>
                </div>

                <div class="card">
                    <div class="image"><img width="50" height="50" src="https://img.icons8.com/ios/50/clock--v1.png" alt="clock--v1"/></div>
                    <div>
                        <div class="numbers">80</div>
                        <div class="cardName">Pending Requests</div>
                    </div>
                </div>                              
            </div>
           
            
            <div class="recentOrders">
                <div class="cardHeader">
                    <h2>Recent Orders</h2>
                    <a href="Orders.html" class="btn">View All</a>
                </div>

                <table>
                    <thead>
                        <tr>
                            <td>Name</td>
                            <td>Price</td>
                            <td>Payment</td>
                            <td>Status</td>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                            <td>Nitrogen Fertilizer</td>
                            <td>LKR 1200</td>
                            <td>Paid</td>
                            <td><span class="status delivered">Delivered</span></td>
                        </tr>

                        <tr>
                            <td>Maize Seed</td>
                            <td>LKR 2500</td>
                            <td>Due</td>
                            <td><span class="status pending">Pending</span></td>
                        </tr>

                        <tr>
                            <td>Pesticide</td>
                            <td>LKR 1200</td>
                            <td>Paid</td>
                            <td><span class="status return">Return</span></td>
                        </tr>

                        <tr>
                            <td>Insecticide</td>
                            <td>LKR 1700</td>
                            <td>Due</td>
                            <td><span class="status inProgress">In Progress</span></td>
                        </tr>

                        <tr>
                            <td>Nitrogen Fertilizer</td>
                            <td>LKR 1200</td>
                            <td>Paid</td>
                            <td><span class="status delivered">Delivered</span></td>
                        </tr>

                        <tr>
                            <td>Pesticide</td>
                            <td>LKR 2000</td>
                            <td>Due</td>
                            <td><span class="status pending">Pending</span></td>
                        </tr>

                        <tr>
                            <td>Hybrid Seed</td>
                            <td>LKR 1500</td>
                            <td>Paid</td>
                            <td><span class="status return">Return</span></td>
                        </tr>

                        <tr>
                            <td>Urea Fertilizer</td>
                            <td>LKR 1000</td>
                            <td>Due</td>
                            <td><span class="status inProgress">In Progress</span></td>
                        </tr>
                    </tbody>
                </table>
            </div>            
        </div>
    </div>
</body>
</html>