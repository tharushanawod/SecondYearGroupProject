<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bids Confirmation</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Moderator/Viewbids.css">

</head>
<body>
<?php require 'sidebar.php';?>

    <main class="main-content">
        <header class="header">
            <h1>Bids Confirmation</h1>
        </header>

        <div class="product-details">
            <div class="product-id">Product ID - 0034</div>
            <div class="price">RS.150</div>
        </div>

        <div class="product-card">
            <div class="product-image">
                <img src="/api/placeholder/300/200" alt="Product image">
            </div>
            <div class="product-info">
                <span class="tag">Corn</span>
                <p class="description">
                    Proident ut laboris exercitation eu sit occaecat incididunt
                    aliquip labore in Lorem deserunt qui in consectetur id ad est s
                </p>
                <div class="quantity">4000Kg</div>
            </div>
        </div>

        <div class="table-container">
            <table>
                <thead>
                    <tr>
                        <th>Product Id</th>
                        <th>Bid Id</th>
                        <th>Bid price</th>
                        <th>Buyer ID</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>001</td>
                        <td>Corn</td>
                        <td>RS.100</td>
                        <td>001</td>
                        <td><button class="accept-btn">Accept</button></td>
                    </tr>
                    <tr>
                        <td>002</td>
                        <td>Corn</td>
                        <td>RS.100</td>
                        <td>001</td>
                        <td><button class="accept-btn">Accept</button></td>
                    </tr>
                    <tr>
                        <td>003</td>
                        <td>Corn</td>
                        <td>RS.100</td>
                        <td>001</td>
                        <td><button class="accept-btn">Accept</button></td>
                    </tr>
                    <tr>
                        <td>004</td>
                        <td>Corn</td>
                        <td>RS.100</td>
                        <td>001</td>
                        <td><button class="accept-btn">Accept</button></td>
                    </tr>
                    <tr>
                        <td>005</td>
                        <td>Corn</td>
                        <td>RS.100</td>
                        <td>001</td>
                        <td><button class="accept-btn">Accept</button></td>
                    </tr>
                    <tr>
                        <td>006</td>
                        <td>Corn</td>
                        <td>RS.100</td>
                        <td>001</td>
                        <td><button class="accept-btn">Accept</button></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>