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
        
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>

        <div class="main-content">
            <div class="main-content-header">
                <h1>Farm Worker Dashboard</h1>
            </div>

            <div class="cardBox">
                <div class="card">
                    <div class="image"><img width="50" height="50" src="https://img.icons8.com/ios/50/approval--v1.png" alt="approval--v1"/></div>
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
                    <h2>Recent Requests</h2>                    
                </div>
                <table>
                    <thead>
                        <tr>
                            <td><b>Farmer</b></td>
                            <td><b>Duration</b></td>
                            <td><b>Description</b></td>
                        </tr>
                    </thead>

                    <tbody>
                        <tr>
                        
                            <td>Samith Perera</td>
                            <td>3 Days</td>
                            <td>Looking for a farm worker to help with daily tasks.</td>
                        </tr>

                        <tr>
                         
                            <td>F.G Gamage</td>
                            <td>6 Days</td>
                            <td>Seeking a farm worker to assist with planting and harvesting.</td>
                        </tr>

                        <tr>
                   
                            <td>Aruna Gamage</td>
                            <td>2 Days</td>
                            <td>Looking for a farm worker to help with apply pesticides.</td>
                        </tr>                        
                    </tbody>
                </table>
            </div>            
        </div>
    </div>
</body>
</html>