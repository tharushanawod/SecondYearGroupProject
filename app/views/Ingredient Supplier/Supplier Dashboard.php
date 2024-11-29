<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Ingredient Supplier/Supplier Dashboard.css">
</head>
<body>
    <div class="dashboard-container">
        
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>

        <div class="main-content">
            <div class="main-content-header">
                <h1>Supplier Dashboard</h1>
            </div>

            <div class="cardBox">
                <div class="card">
                    <div class="icon"><img width="50" height="50" src="https://img.icons8.com/ios/50/clock--v1.png" alt="clock--v1"/></div>
                    <div>
                        <div class="numbers">15</div>
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
                                <td>Urea (Granular/Prilled)</td>
                                <td>LKR 1200</td>
                                <td>Paid</td>
                                <td><span class="status delivered">Delivered</span></td>
                            </tr>

                            <tr>
                                <td>TF 222 Hybrid Maize seeds</td>
                                <td>LKR 2500</td>
                                <td>Due</td>
                                <td><span class="status pending">Pending</span></td>
                            </tr>

                            <tr>
                                <td>Chlorpyrifos</td>
                                <td>LKR 1200</td>
                                <td>Paid</td>
                                <td><span class="status return">Return</span></td>
                            </tr>

                            <tr>
                                <td>Lambda-Cyhalothrin</td>
                                <td>LKR 1700</td>
                                <td>Due</td>
                                <td><span class="status inProgress">In Progress</span></td>
                            </tr>

                            <tr>
                                <td>SA 336 Hybrid Maize seeds</td>
                                <td>LKR 1200</td>
                                <td>Paid</td>
                                <td><span class="status delivered">Delivered</span></td>
                            </tr>

                            <tr>
                                <td>Zinc Sulphate</td>
                                <td>LKR 2000</td>
                                <td>Due</td>
                                <td><span class="status pending">Pending</span></td>
                            </tr>

                            <tr>
                                <td>Emamectin Benzoate</td>
                                <td>LKR 1500</td>
                                <td>Paid</td>
                                <td><span class="status return">Return</span></td>
                            </tr>

                            <tr>
                                <td>HP 4311 Hybrid Maize Seeds</td>
                                <td>LKR 1000</td>
                                <td>Due</td>
                                <td><span class="status inProgress">In Progress</span></td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                <div class="recentCustomers">
                    <div class="cardHeader">
                        <h2>Recent Customers</h2>
                    </div>

                    <table>
                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="<?php echo URLROOT;?>/images/images/img2.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4> Sunil <br> <span> Anuradhapura</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="<?php echo URLROOT;?>/images/images/img2.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4> Nimal<br> <span> Ampara</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="<?php echo URLROOT;?>/images/images/img2.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4> Gamage<br> <span>Anuradhapura</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="<?php echo URLROOT;?>/images/images/img2.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4> Siriwardhana<br> <span>Anuradhapura</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="<?php echo URLROOT;?>/images/images/img2.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>Dissanyaka <br> <span>Puttlam</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="<?php echo URLROOT;?>/images/images/img2.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>Ranathunga <br> <span>Kurunegala</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="<?php echo URLROOT;?>/images/images/img2.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>Somapala <br> <span>Ampara</span></h4>
                            </td>
                        </tr>

                        <tr>
                            <td width="60px">
                                <div class="imgBx"><img src="<?php echo URLROOT;?>/images/images/img2.jpg" alt=""></div>
                            </td>
                            <td>
                                <h4>Sarath<br> <span>Anuradhapura</span></h4>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html>