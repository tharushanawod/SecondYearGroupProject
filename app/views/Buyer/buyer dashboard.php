<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Dashboard</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/buyer dashboard.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>

    <div class="dashboard-container">
        
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>

        <div class="main-content">
            <div class="main-content-header">
                <h1>Buyer Dashboard</h1>
            </div>

            <div class="cardBox">
                <div class="card">
                    <div class="icon"><img width="50" height="50" src="https://img.icons8.com/ios/50/approval--v1.png" alt="approval--v1"/></div>
                    <div>
                        <div class="numbers">20</div>
                        <div class="cardName">Accepted Bids</div>
                    </div>
                </div>

                <div class="card">
                    <div class="icon"><img width="50" height="50" src="https://img.icons8.com/ios-filled/50/auction.png" alt="auction"/></div>
                    <div>
                        <div class="numbers">12</div>
                        <div class="cardName">Active Bids</div>
                    </div>
                </div>

                <div class="card">
                    <div class="icon"><img width="50" height="50" src="https://img.icons8.com/external-basicons-line-edtgraphics/50/external-Purchases-delivery-basicons-line-edtgraphics.png" alt="external-Purchases-delivery-basicons-line-edtgraphics"/></div>
                    <div>
                        <div class="numbers">12</div>
                        <div class="cardName">Purchases</div>
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
                        <h2>Recent Bids</h2>                        
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>Product Name</td>
                                <td>Bid Amount</td>
                                <td>Status</td>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>Dry Corn</td>
                                <td>LKR 1200</td>
                                <td><span class="accepted">Accepted</span></td>
                            </tr>

                            <tr>
                                <td>Sweet Corn</td>
                                <td>LKR 2500</td>
                                <td><span class="pending">Pending</span></td>
                            </tr>

                            <tr>
                                <td>Dry Corn</td>
                                <td>LKR 1200</td>
                                <td><span class="accepted">Accepted</span></td>
                            </tr>

                            <tr>
                                <td>sweet Corn</td>
                                <td>LKR 1700</td>
                                <td><span class="accepted">Accepted</span></td>
                            </tr>

                            <tr>
                                <td>Dry Corn</td>
                                <td>LKR 1200</td>
                                <td><span class="accepted">Accepted</span></td>
                            </tr>

                            <tr>
                                <td>Sweet Corn</td>
                                <td>LKR 2000</td>
                                <td><span class="pending">Pending</span></td>
                            </tr>

                            <tr>
                                <td>Dry Corn</td>
                                <td>LKR 1500</td>
                                <td><span class="accepted">Accepted</span></td>
                            </tr>

                            <tr>
                                <td>Sweet Corn</td>
                                <td>LKR 1000</td>
                                <td><span class="pending">Pending</span></td>
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