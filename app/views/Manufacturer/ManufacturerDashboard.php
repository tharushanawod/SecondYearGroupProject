<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Dashboard</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Manufacturer/ManufacturerDashboard.css">
</head>
<body>

        
    <?php require 'sidebar.php';?> 

        <div class="main-content">
            <div class="main-content-header">
                <h1> Manufacturer Dashbboard</h1>
            </div>

            <div class="cardBox">
                <div class="card">
                    <div>
                    <?php $row = $this->LastPrice(); ?>
                    <div class="numbers"><?php echo $row->type; ?></div>
                        <div class="cardName">Current Product Type</div>
                    </div>
                    <img width="50" height="50" src="https://img.icons8.com/wired/50/checkmark.png" alt="checkmark"/>
                </div>
                <div class="card">
                    <div>
                        <?php $row = $this->LastPrice(); ?>
                        <div class="numbers">LKR <?php echo $row->price; ?></div>
                        <div class="cardName">Current Price</div>
                    </div>
                    <img width="50" height="50" src="https://img.icons8.com/ios-filled/50/money-bag-euro.png" alt="money-bag-euro"/>
                </div>
                <div class="card">
                    <div>
                        <?php $prices = $this->getPreviousPrice(); ?>
                        <div class="numbers">LKR 198</div>
                        <div class="cardName">Previous Price</div>
                    </div>
                    <img width="50" height="50" src="https://img.icons8.com/ios/50/price-tag-usd--v1.png" alt="price-tag-usd--v1"/>
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
                                <?php
                                // Loop through users and display each user in a row
                                if(!empty($data['prices'])):
                                    foreach($data['prices'] as $price):
                                ?>
                                    <tr>
                                        <td><?php echo $price->name; ?></td>  <!-- User ID -->
                                        <td><?php echo $price->date; ?></td>  <!-- User Name -->
                                        <td><?php echo $price->type; ?></td>  <!-- User Email -->
                                        <td><?php echo $price->price; ?></td>  <!-- User Phone -->
                                        <td><div class="action">
                                            <a href="<?php echo URLROOT ;?>/ManufacturerController/RemovePrices/<?php echo $price->priceid ?>"><button class="action-button">Delete</button></a>
                                    </tr>
                                <?php
                                    endforeach;
                                else:
                                ?>
                                    <tr>
                                        <td colspan="5">No prices found</td>
                                    </tr>
                                <?php endif; ?>
                        </tbody>
                        
                    </table>
                </div>

  
                </div>
            </div>
        </div>
    </div>
</body>
</html>