<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Product</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Ingredient Supplier/Add Product.css">
</head>
<body>
<?php require 'sidebar.php';?>

<h1>Delete Product</h1>
<div class="container">
<p>Are you sure you want to delete the product "<?= htmlspecialchars($data['product']->product_name) ?>"?</p>
<form action="<?php echo URLROOT; ?>/SupplierController/destroy" method="post">
    <input type="hidden" name="product_id" value="<?= $data['product']->product_id ?>">
    <button class ="delete" type="submit">Yes, Delete</button>
    <button class="cancel" type="button" a href="<?php echo URLROOT; ?>/SupplierController/productManagement">Cancel</button>
    
</form>
</div>
</body>
</html>

