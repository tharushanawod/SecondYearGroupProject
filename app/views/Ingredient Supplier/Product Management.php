<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Page</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Ingredient Supplier/ProductManagement.css">
</head>
<body>
<?php require 'sidebar.php';?>

<h1>Products Management</h1>
<button class="add-product-btn" onclick="location.href='<?php echo URLROOT ?>/SupplierController/add'">Add Product</button>

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
        <?php if (!empty($data['products'])) : ?>
            <?php foreach ($data['products'] as $product) : ?>
                <tr>
                    <td><?= htmlspecialchars($product->product_name) ?></td>
                    <td><?= htmlspecialchars($product->category) ?></td>
                    <td><?= htmlspecialchars($product->price) ?></td>
                    <td><?= htmlspecialchars($product->stock) ?></td>
                    <td>
                        <button class="edit-btn" onclick="location.href='<?= URLROOT ?>/SupplierController/edit/<?= htmlspecialchars($product->product_id) ?>'">Edit</button>
                        <button class="delete-btn" onclick="location.href='<?= URLROOT ?>/SupplierController/delete/<?= htmlspecialchars($product->product_id) ?>'">Delete</button>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php else : ?>
            <tr>
                <td colspan="5">No products available.</td>
            </tr>
        <?php endif; ?>
    </tbody>
</table>

</body>
</html>