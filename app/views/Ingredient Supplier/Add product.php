<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Page</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Ingredient Supplier/Add product.css">
</head>
<body>
<?php require 'header.php';?>
    <div class="container">
        <h1>Products Management</h1>
        <button id="addProductBtn" class="add-product-btn">Add Product</button>
        
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
            <?php if (!empty($products) && is_array($products)): ?>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?php echo $product['product_name']; ?></td>
                    <td><?php echo $product['category']; ?></td>
                    <td>LKR <?php echo $product['price']; ?></td>
                    <td><?php echo $product['stock']; ?></td>
                    <td>
                        <a href="index.php?action=edit&id=<?php echo $product['id']; ?>">Edit</a>
                        <a href="index.php?action=delete&id=<?php echo $product['id']; ?>" onclick="return confirm('Are you sure?')">Delete</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            <?php endif; ?>
            </tbody>
        </table>
        
        <div id="productFormModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="formTitle">Add Product</h2>
                <form id="productForm" action="<?php echo URLROOT; ?>/SupplierController/updateProduct" method="post">
                    <input type="hidden" id="productId" name="id">
                    <input type="hidden" id="productImage" name="image">
                    <label for="productName">Product Name:</label>
                    <input type="text" id="productName" name="productName" required>
                    
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
                    <input type="file" id="imageUpload" name="imageUpload" accept="image/*">
                    <img id="imagePreview" src="" alt="Image Preview" style="display:none;">

                    <div class="form-buttons">
                        <button type="submit" id="saveBtn">Save</button>
                        <button type="button" id="cancelBtn">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="<?php echo URLROOT;?>/js/Ingredient Supplier/Add product.js"></script>
</body>
</html>