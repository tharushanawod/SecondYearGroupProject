<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Ingredient Supplier/ProductManagement.css">    
    <script src="<?php echo URLROOT;?>/js/Ingredient Supplier/ProductManagement.js" defer></script>
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet" />
</head>
<body>
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>
    
    <div class="maincontainer">
        <div class="header-section">
            <div class="header-content">
                <h1>Products Inventory</h1>
                <div class="search-section">
                    <input type="text" class="search-box" placeholder="Search products..." oninput="filterProducts()">
                    <button class="add-product-btn" onclick="showModal('addProductModal')">
                        <svg width="20" height="20" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Add Product
                    </button>
                </div>
            </div>
        </div>

        <div class="table-container">
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
                                <td>
                                    <img src="<?php echo URLROOT; ?>/uploads/<?php echo htmlspecialchars($product->image); ?>" 
                                        alt="<?php echo htmlspecialchars($product->product_name); ?>" 
                                        class="product-thumb">
                                </td>
                                <td><?= htmlspecialchars($product->product_name) ?></td>
                                <td><?= htmlspecialchars($product->category_name) ?></td>
                                <td>LKR <?= htmlspecialchars(number_format($product->price, 2)) ?></td>
                                <td><?= htmlspecialchars($product->stock) ?></td>
                                <td>
                                    <div class="action-buttons">
                                        <button class="edit-btn" onclick="showModal('updateProductModal', <?= htmlspecialchars(json_encode($product)) ?>, '<?php echo URLROOT; ?>')">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        <button class="delete-btn" onclick="showModal('deleteProductModal', <?= htmlspecialchars(json_encode($product)) ?>, '<?php echo URLROOT; ?>')">
                                            <svg width="16" height="16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr><td colspan="6">No products available.</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

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
                                <option value="<?= $category->category_id ?>"><?= $category->category_name ?></option>
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
                        <input type="file" name="image" accept="image/*" required onchange="previewImage(this, 'imagePreview')">
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
                    <input type="hidden" name="product_id" id="updateProductId">
                    <input type="hidden" name="existing_image" id="updateProductExistingImage">
                    
                    <div class="form-group">
                        <label for="product_name">Product Name:</label>
                        <input type="text" name="product_name" id="updateProductName" required>
                    </div>

                    <div class="form-group">
                        <label for="category_id">Category:</label>
                        <select name="category_id" id="updateCategory" required>
                            <?php foreach ($data['categories'] as $category) : ?>
                                <option value="<?= $category->category_id ?>"><?= $category->category_name ?></option>
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
                        <input type="file" name="image" accept="image/*" onchange="previewImage(this, 'updateImagePreview')">
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
                    <img id="deleteProductImage" class="delete-preview-image" src="" alt="">
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