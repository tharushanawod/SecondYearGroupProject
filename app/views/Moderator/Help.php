<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Moderator/Landing.css">
</head>
<body>
   <?php require 'sidebar.php';?>

    <main class="main-content">
       

        <section class="overview">
            <h2>Help & Support 🧑‍🚀</h2>
            <div class="cards">
                <div class="card">
                    <div class="card-header">
                        <h3>User count</h3>
                        <span class="info-icon">ℹ️</span>
                    </div>
                    <div class="number">1123</div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h3>Messages</h3>
                        <span class="info-icon">ℹ️</span>
                    </div>
                    <div class="number">298</div>
                </div>
            </div>
        </section>

        <section class="detailed-report">
            <h2> 📫 Inbox </h2>
            <div class="table-container">
                <table>
                    <thead>
                        <tr>
                            <th>User Id</th>
                            <th>Name</th>
                            <th>Title</th>
                   
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        <td>001</td>
                            <td>Alice Johnson</td>
                            <td>Farmer</td>
                            <td><button class="view-btn">Read</button>
                            <button class="view-btn">Delete</button></td>
                            
                        </tr>
                        <tr>
                        <td>001</td>
                            <td>Alice Johnson</td>
                            <td>Buyer</td>
                            <td><button class="view-btn">Read</button>
                            <button class="view-btn">Delete</button></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </main>
</body>
</html>