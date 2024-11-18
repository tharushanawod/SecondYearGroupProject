<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Labour Requests</title>
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
                        <h3>labours</h3>
                        <span class="info-icon">ℹ</span>
                    </div>
                    <div class="number">1123</div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3>Requets</h3>
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
                            <th>Labour Id</th>
                            <th>Name</th>
                            <th>Description</th>
                            <th>Chrage</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <tr>
    <td>101</td>
    <td>John Doe</td>
    <td>Experienced harvester with 5 years of experience</td>
    <td>$50/day</td>
    <td><button class="view-btn">Hire</button></td>
</tr>
<tr>
    <td>102</td>
    <td>Jane Smith</td>
    <td>Planting and irrigation specialist</td>
    <td>$45/day</td>
    <td><button class="view-btn">Hire</button></td>
</tr>
<tr>
    <td>103</td>
    <td>Mike Brown</td>
    <td>Skilled in pest control and crop monitoring</td>
    <td>$55/day</td>
    <td><button class="view-btn">Hire</button></td>
</tr>
<tr>
    <td>104</td>
    <td>Sarah Lee</td>
    <td>Crop rotation and soil health expert</td>
    <td>$60/day</td>
    <td><button class="view-btn">Hire</button></td>
</tr>

                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>