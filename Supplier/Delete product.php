<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Products Page</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Ingredient Supplier/Delete product.css">
</head>
<body>
<?php require 'header.php';?>
    <div class="container">
        <h1>Delete Products</h1>
        
        <table id="productTable">
            <thead>
                <tr>
                    <th>Product Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <!-- Example row -->
                <tr>
                    <td>Example Product</td>
                    <td>Fertilizer</td>
                    <td>LKR 1000</td>
                    <td>50</td>
                    <td class="actions">
                        <button class="delete">Delete</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
    <script src="<?php echo URLROOT;?>/js/Ingredient Supplier/Delete product.js"></script>    
</body>
</html>