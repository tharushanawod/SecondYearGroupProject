<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase History</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/purchase history.css">
</head>
<body>
    
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
    
<div class="container">      
    <h2 class="header-content">Purchase History</h2>        
            
        <table id="purchaseHistory">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Farmer</th>
                    <th>Purchase Date</th>
                    <th>Quantity</th>
                    <th>Price</th>
                    <th>Status</th>                    
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Product 1</td>
                    <td>Sunil</td>
                    <td>2024-04-25</td>
                    <td>10 kg</td>
                    <td>LKR 1200</td>
                    <td>Delivered</td>                    
                </tr>
                <tr>
                    <td>Product 2</td>
                    <td>Kamal</td>
                    <td>2024-05-11</td>
                    <td>5 kg</td>
                    <td>LKR 1400</td>
                    <td>In Transit</td>                    
                </tr>
                <tr>
                    <td>Product 3</td>
                    <td>Silva</td>
                    <td>2024-07-20</td>
                    <td>5 kg</td>
                    <td>LKR 1400</td>
                    <td>In Transit</td>
                </tr>
                <tr>
                    <td>Product 4</td>
                    <td>Perera</td>
                    <td>2024-08-22</td>
                    <td>5 kg</td>
                    <td>LKR 1400</td>
                    <td>In Transit</td>                    
                </tr>
            </tbody>
        </table>
</div>
</body>
</html>