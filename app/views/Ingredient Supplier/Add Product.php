<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Ingredient Supplier/Add Product.css">
</head>
<body>
<?php require 'sidebar.php';?>

<h1>Add Product</h1>

<div class="container">
<form action="<?php echo URLROOT; ?>/SupplierController/save" method="post" enctype="multipart/form-data">
    <label for="productName">Product Name:</label>
    <input type="text" id="productName" name="product_name" required>
    
    <label for="category">Category:</label>
    <select id="category" name="category" required>
        <option value="Fertilizer">Fertilizer</option>
        <option value="Seeds">Seeds</option>
        <option value="Pest Control">Pest Control</option>
    </select>

    <label for="price">Price:</label>
    <input type="number" id="price" name="price" required>

    <label for="stock">Stock:</label>
    <input type="number" id="stock" name="stock" required>

    <label for="description">Product Description:</label>
    <textarea id="description" name="description" required></textarea>

    <label for="imageUpload">Product Image:</label>
    <input type="file" id="imageUpload" name="image" accept="image/*">

    <button type="submit">Add Product</button>
</form>
</div>
</body>
</html>