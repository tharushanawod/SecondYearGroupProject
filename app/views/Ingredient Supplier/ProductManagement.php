<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Ingredient Supplier/ProductManagement.css">    
    <script src="<?php echo URLROOT;?>/js/Ingredient Supplier/ProductManagement.js" defer></script>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
<div class="maincontainer">
    <h1>Products Inventory</h1>
    <button class="add-product-btn" onclick="showModal('addProductModal')">Add Product</button>

    <!-- Product Table -->
    <table id="productTable">
        <thead>
            <tr>
                <th>Image</th>
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
                        <td><img src="<?php echo URLROOT; ?>/uploads/<?php echo $product->image; ?>" alt="<?php echo $product->product_name; ?>" class="product-thumb"></td>
                        <td><?= htmlspecialchars($product->product_name) ?></td>
                        <td><?= htmlspecialchars($product->category_name) ?></td>
                        <td>LKR <?= htmlspecialchars(number_format($product->price, 2)) ?></td>
                        <td><?= htmlspecialchars($product->stock) ?></td>
                        <td>
                            <button class="edit-btn" onclick="showModal('updateProductModal', <?= htmlspecialchars(json_encode($product)) ?>)">Update</button>
                            <button class="delete-btn" onclick="showModal('deleteProductModal', <?= htmlspecialchars(json_encode($product)) ?>)">Delete</button>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr><td colspan="6">No products available.</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Add Product Modal -->
    <div id="addProductModal" class="modal">
        <div class="modal-content">
            <h2>Add New Product</h2>
            <form action="<?php echo URLROOT; ?>/SupplierController/save" method="post" enctype="multipart/form-data">
                <input type="hidden" name="supplier_id" value="<?= $_SESSION['supplier_id'] ?>">
                
                <div class="form-group">
                    <label for="product_name">Product Name:</label>
                    <input type="text" name="product_name" required>
                </div>

                <div class="form-group">
                    <label for="category_id">Category:</label>
                    <select name="category_id" required>
                        <?php foreach ($data['categories'] as $category) : ?>
                            <option value="<?= $category->id ?>"><?= $category->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="price">Price (LKR):</label>
                    <input type="number" name="price" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="stock">Stock:</label>
                    <input type="number" name="stock" required>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" required></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Product Image:</label>
                    <input type="file" name="image" accept="image/*" required>
                    <img id="imagePreview" class="preview-image" src="" alt="">
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-btn">Add Product</button>
                    <button type="button" class="cancel-btn" onclick="closeModal('addProductModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Update Product Modal -->
    <div id="updateProductModal" class="modal">
        <div class="modal-content">
            <h2>Update Product</h2>
            <form action="<?php echo URLROOT; ?>/SupplierController/update" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id" id="updateProductId">
                <input type="hidden" name="existing_image" id="updateProductExistingImage">
                
                <div class="form-group">
                    <label for="product_name">Product Name:</label>
                    <input type="text" name="product_name" id="updateProductName" required>
                </div>

                <div class="form-group">
                    <label for="category_id">Category:</label>
                    <select name="category_id" id="updateCategory" required>
                        <?php foreach ($data['categories'] as $category) : ?>
                            <option value="<?= $category->id ?>"><?= $category->name ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="price">Price (LKR):</label>
                    <input type="number" name="price" id="updatePrice" step="0.01" required>
                </div>

                <div class="form-group">
                    <label for="stock">Stock:</label>
                    <input type="number" name="stock" id="updateStock" required>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" id="updateDescription" required></textarea>
                </div>

                <div class="form-group">
                    <label for="image">Product Image:</label>
                    <input type="file" name="image" accept="image/*">
                    <img id="updateImagePreview" class="preview-image" src="" alt="">
                </div>

                <div class="form-actions">
                    <button type="submit" class="submit-btn">Update Product</button>
                    <button type="button" class="cancel-btn" onclick="closeModal('updateProductModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>

    <!-- Delete Product Modal -->
    <div id="deleteProductModal" class="modal">
        <div class="modal-content">
            <h2>Delete Product</h2>
            <p>Are you sure you want to delete "<span id="deleteProductName"></span>"?</p>
            
            <div class="product-preview">
                <img id="deleteProductImage" src="" alt="">
                <p><strong>Category:</strong> <span id="deleteProductCategory"></span></p>
                <p><strong>Price:</strong> LKR <span id="deleteProductPrice"></span></p>
                <p><strong>Stock:</strong> <span id="deleteProductStock"></span></p>
            </div>

            <form action="<?php echo URLROOT; ?>/SupplierController/destroy" method="post">
                <input type="hidden" name="product_id" id="deleteProductId">
                <div class="form-actions">
                    <button type="submit" class="delete-btn">Delete</button>
                    <button type="button" class="cancel-btn" onclick="closeModal('deleteProductModal')">Cancel</button>
                </div>
            </form>
        </div>
    </div>
</div>

</body>
</html>