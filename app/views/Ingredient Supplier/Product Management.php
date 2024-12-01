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
                        <button class="edit-btn" onclick="showModal('updateProductModal', <?= htmlspecialchars(json_encode($product)) ?>)">Update</button>
                        <button class="delete-btn" onclick="showModal('deleteProductModal', <?= htmlspecialchars(json_encode($product)) ?>)">Delete</button>
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

<!-- Add Product Modal -->
<div id="addProductModal" class="modal">
    <div class="modal-content">        
        <h2>Add Product</h2>
            <form action="<?php echo URLROOT; ?>/SupplierController/save" method="post" enctype="multipart/form-data" class="form-grid">
        <div class="form-group">
            <label for="productName">Product Name:</label>
            <input type="text" id="productName" name="product_name" required>
        </div>
        
        <div class="form-group">
            <label for="category">Category:</label>
            <select id="category" name="category" required>
                <option value="Fertilizer">Fertilizer</option>
                <option value="Seeds">Seeds</option>
                <option value="Pest Control">Pest Control</option>
            </select>
        </div>

        <div class="form-group">
            <label for="price">Price:</label>
            <input type="number" id="price" name="price" required>
        </div>

        <div class="form-group">
            <label for="stock">Stock:</label>
            <input type="number" id="stock" name="stock" required>
        </div>

        <div class="form-group full-width">
            <label for="description">Product Description:</label>
            <textarea id="description" name="description" required></textarea>
        </div>

        <div class="form-group full-width">
            <label for="imageUpload">Product Image:</label>
            <input type="file" id="imageUpload" name="image" accept="image/*">
        </div>

        <div class="form-group full-width">
            <button type="submit">Add Product</button>
            <a href="javascript:void(0)" class="cancel" onclick="closeModal('addProductModal')">Cancel</a>
        </div>
    </form>
        </div>
</div>

<!-- Update Product Modal -->
<div id="updateProductModal" class="modal">
    <div class="modal-content">        
        <h2>Update Product</h2>
        <form id="updateProductForm" action="<?php echo URLROOT; ?>/SupplierController/update" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" id="updateProductId">
            <input type="hidden" name="existing_image" id="updateProductExistingImage">
            
            <label for="updateProductName">Product Name:</label>
            <input type="text" id="updateProductName" name="product_name" required>
            
            <label for="updateCategory">Category:</label>
            <select id="updateCategory" name="category" required>
                <option value="Fertilizer">Fertilizer</option>
                <option value="Seeds">Seeds</option>
                <option value="Pest Control">Pest Control</option>
            </select>

            <label for="updatePrice">Price:</label>
            <input type="number" id="updatePrice" name="price" required>

            <label for="updateStock">Stock:</label>
            <input type="number" id="updateStock" name="stock" required>

            <label for="updateDescription">Product Description:</label>
            <textarea id="updateDescription" name="description" required></textarea>

            <label for="updateImageUpload">Product Image:</label>
            <input type="file" id="updateImageUpload" name="image" accept="image/*">            
            <img id="updateProductImage" src="" alt="" style="max-width: 200px; max-height: 200px;">

            <button type="submit">Update Product</button>
            <a href="javascript:void(0)" class="cancel" onclick="closeModal('updateProductModal')">Cancel</a>
        </form>
    </div>
</div>

<!-- Delete Product Modal -->
<div id="deleteProductModal" class="modal">
    <div class="modal-content">        
        <h2>Delete Product</h2>
        <p>Are you sure you want to delete the product "<span id="deleteProductName"></span>"?</p>
        <div class="product-details">
            <p><strong>Category:</strong> <span id="deleteProductCategory"></span></p>
            <p><strong>Price:</strong> LKR <span id="deleteProductPrice"></span></p>
            <p><strong>Stock:</strong> <span id="deleteProductStock"></span></p>
            <p><strong>Description:</strong> <span id="deleteProductDescription"></span></p>            
            <img id="deleteProductImage" src="" alt="" style="max-width: 200px; max-height: 200px;">
        </div>
        <form id="deleteProductForm" action="<?php echo URLROOT; ?>/SupplierController/destroy" method="post">
            <input type="hidden" name="product_id" id="deleteProductId">
            <button class="delete" type="submit">Yes, Delete</button>
            <a href="javascript:void(0)" class="cancel" onclick="closeModal('deleteProductModal')">Cancel</a>
        </form>
    </div>
</div>

</div>


</body>
</html>