<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Moderator/Landing.css">
</head>
<body>
   <?php require 'sidebar.php';?>

    <main class="main-content">
       

        <section class="overview">
            <h2>Overview</h2>
            <div class="cards">
                <div class="card">
                    <div class="card-header">
                        <h3>Bids count</h3>
                        <span class="info-icon">ℹ️</span>
                    </div>
                    <div class="number">1123</div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3>Products</h3>
                        <span class="info-icon">ℹ️</span>
                    </div>
                    <div class="number">298</div>
                </div>
            </div>
        </section>

        <section class="detailed-report">
            <h2>Detailed report</h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>Product Id</th>
                            <th>Name</th>
                            <th>Minimum Price</th>
                            <th>FarmerID</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>001</td>
                            <td>Corn</td>
                            <td>RS.100</td>
                            <td>001</td>
                            <td><button class="view-btn">View</button>
                            <button class="view-btn">Delete</button></td>
                            
                        </tr>
                        <tr>
                            <td>002</td>
                            <td>Corn</td>
                            <td>RS.100</td>
                            <td>001</td>
                            <td><button class="view-btn">View</button>
                            <button class="view-btn">Delete</button></td>
                        </tr>
                        <tr>
                            <td>003</td>
                            <td>Corn</td>
                            <td>RS.100</td>
                            <td>001</td>
                            <td><button class="view-btn">View</button>
                            <button class="view-btn">Delete</button></td>
                        </tr>
                        <tr>
                            <td>004</td>
                            <td>Corn</td>
                            <td>RS.100</td>
                            <td>001</td>
                            <td><button class="view-btn">View</button>
                            <button class="view-btn">Delete</button></td>
                        </tr>
                        <tr>
                            <td>005</td>
                            <td>Corn</td>
                            <td>RS.100</td>
                            <td>001</td>
                            <td><button class="view-btn">View</button>
                            <button class="view-btn">Delete</button></td>
                        </tr>
                        <tr>
                            <td>006</td>
                            <td>Corn</td>
                            <td>RS.100</td>
                            <td>001</td>
                            <td><button class="view-btn">View</button>
                            <button class="view-btn">Delete</button></td>
                        </tr>
                        <tr>
                            <td>006</td>
                            <td>Corn</td>
                            <td>RS.100</td>
                            <td>001</td>
                            <td><button class="view-btn">View</button>
                            <button class="view-btn">Delete</button></td>
                        </tr>
                        <tr>
                            <td>006</td>
                            <td>Corn</td>
                            <td>RS.100</td>
                            <td>001</td>
                            <td><button class="view-btn">View</button>
                            <button class="view-btn">Delete</button></td>
                        </tr>
                        <tr>
                            <td>006</td>
                            <td>Corn</td>
                            <td>RS.100</td>
                            <td>001</td>
                            <td><button class="view-btn">View</button>
                            <button class="view-btn">Delete</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>