<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Ingredient Supplier/Add Product.css">
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<h1>Update Product</h1>
<div class="container">
<form action="<?php echo URLROOT; ?>/SupplierController/update" method="post" enctype="multipart/form-data">
    <input type="hidden" name="id" value="<?= $data['product']->product_id ?>">
    <input type="hidden" name="existing_image" value="<?= $data['product']->image ?>">
    
    <label for="productName">Product Name:</label>
    <input type="text" id="productName" name="product_name" value="<?= htmlspecialchars($data['product']->product_name) ?>" required>
    
    <label for="category">Category:</label>
    <select id="category" name="category" required>
        <option value="Fertilizer" <?= $data['product']->category == 'Fertilizer' ? 'selected' : '' ?>>Fertilizer</option>
        <option value="Seeds" <?= $data['product']->category == 'Seeds' ? 'selected' : '' ?>>Seeds</option>
        <option value="Pest Control" <?= $data['product']->category == 'Pest Control' ? 'selected' : '' ?>>Pest Control</option>
    </select>

    <label for="price">Price:</label>
    <input type="number" id="price" name="price" value="<?= htmlspecialchars($data['product']->price) ?>" required>

    <label for="stock">Stock:</label>
    <input type="number" id="stock" name="stock" value="<?= htmlspecialchars($data['product']->stock) ?>" required>

    <label for="description">Product Description:</label>
    <textarea id="description" name="description" required><?= htmlspecialchars($data['product']->description) ?></textarea>

    <label for="imageUpload">Product Image:</label>
    <input type="file" id="imageUpload" name="image" accept="image/*">
    <img src="<?= URLROOT ?>/uploads/<?= $data['product']->image ?>" alt="Product Image" style="max-width: 200px; max-height: 200px;">

    <button type="submit">Update</button>
</form>
</div>
</body>
</html>