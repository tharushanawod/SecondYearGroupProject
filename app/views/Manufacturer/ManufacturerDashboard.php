<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Dashboard</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Manufacturer/ManufacturerDashboard.css">
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
                    <div>
                        <div class="numbers">Dry Corn</div>
                        <div class="cardName">Product Type</div>
                    </div>
                    <img width="50" height="50" src="https://img.icons8.com/wired/50/checkmark.png" alt="checkmark"/>
                </div>

                <div class="card">
                    <div>
                        <div class="numbers">LKR 198</div>
                        <div class="cardName">Previous Price</div>
                    </div>
                    <img width="50" height="50" src="https://img.icons8.com/ios/50/price-tag-usd--v1.png" alt="price-tag-usd--v1"/>
                </div>

          

                <div class="card">
                    <div>
                        <div class="numbers">LKR 210</div>
                        <div class="cardName">Current Price</div>
                    </div>
                    <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/money-bag-euro.png" alt="money-bag-euro"/>
                </div>
            </div>

           
            <div class="details">
                <div class="recentOrders">
                    <div class="cardHeader">
                        <h2>Recent Prices</h2>
                    </div>

                    <table>
                        <thead>
                            <tr>
                                <td>Name</td>
                                <td>Date</td>
                                <td>Type</td>
                                <td>Price</td>
                                <td>Action</td>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>Corn</td>
                                <td>2021-09-20</td>
                                <td>Dry Corn</td>
                                <td>LKR 223.50</td>
                                <td><div class="action">
                                    <button class="action-button">Update</button>
                                    <button class="action-button">Delete</button>
                                </div>
                            </td>
                            </tr>

                            <tr>
                                <td>Corn</td>
                                <td>2021-09-20</td>
                                <td>Dry Corn</td>
                                <td>LKR 223.50</td>
                                <td><div class="action">
                                    <button class="action-button">Update</button>
                                    <button class="action-button">Delete</button>
                                </div>
                            </td>
                            </tr>
                            
                            <tr>
                                <td>Corn</td>
                                <td>2021-09-20</td>
                                <td>Dry Corn</td>
                                <td>LKR 223.50</td>
                                <td><div class="action">
                                    <button class="action-button">Update</button>
                                    <button class="action-button">Delete</button>
                                </div>
                            </td>
                            </tr>
                            <tr>
                                <td>Corn</td>
                                <td>2021-09-20</td>
                                <td>Dry Corn</td>
                                <td>LKR 223.50</td>
                                <td><div class="action">
                                    <button class="action-button">Update</button>
                                    <button class="action-button">Delete</button>
                                </div>
                            </td>
                            </tr>
                            <tr>
                                <td>Corn</td>
                                <td>2021-09-20</td>
                                <td>Dry Corn</td>
                                <td>LKR 223.50</td>
                                <td><div class="action">
                                    <button class="action-button">Update</button>
                                    <button class="action-button">Delete</button>
                                </div>
                            </td>
                            </tr>
                            <tr>
                                <td>Corn</td>
                                <td>2021-09-20</td>
                                <td>Dry Corn</td>
                                <td>LKR 223.50</td>
                                <td><div class="action">
                                    <button class="action-button">Update</button>
                                    <button class="action-button">Delete</button>
                                </div>
                            </td>
                            </tr>
                       
                        </tbody>
                    </table>
                </div>

  
                </div>
            </div>
        </div>
    </div>
</body>
</html>