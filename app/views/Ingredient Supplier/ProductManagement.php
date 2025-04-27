<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Management</title>
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/Ingredient Supplier/ProductManagement.css">
    <style>
       
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>

    <div class="main-container">
        <div class="header-section">
            <div class="header-content">
                <h1>Products Inventory</h1>
                <div class="search-section">
                    <input type="text" class="search-box" placeholder="Search products..." oninput="filterProducts()">
                    <button class="add-product-btn" onclick="showModal('addProductModal')">
                        <i class="fas fa-plus"></i>
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
                        <th>Product ID</th>
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
                                alt="<?php echo htmlspecialchars($product->product_name); ?>" class="product-thumb">
                        </td>
                        <td>
                            <?= htmlspecialchars($product->product_id) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($product->product_name) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($product->category_name) ?>
                        </td>
                        <td>LKR
                            <?= htmlspecialchars(number_format($product->price, 2)) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($product->stock) ?>
                        </td>
                        <td>
                            <div class="action-buttons">
                                <button class="edit-btn"
                                    onclick="showModal('updateProductModal', <?= htmlspecialchars(json_encode($product)) ?>, '<?php echo URLROOT; ?>')">
                                    <i class="fas fa-edit"></i>
                                </button>
                                <button class="delete-btn"
                                    onclick="showModal('deleteProductModal', <?= htmlspecialchars(json_encode($product)) ?>, '<?php echo URLROOT; ?>')">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                    <?php else : ?>
                    <tr>
                        <td colspan="6" style="text-align: center;">No products available.</td>
                    </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <!-- Add Product Modal -->
        <div id="addProductModal" class="modal">
            <div class="modal-content">
                <form action="<?php echo URLROOT; ?>/SupplierController/save" method="post"
                    enctype="multipart/form-data">
                    <input type="hidden" name="supplier_id" value="<?= $_SESSION['supplier_id'] ?>">

                    <div class="form-group">
                        <label for="product_name">Product Name:</label>
                        <input type="text" name="product_name" required>
                    </div>

                    <div class="form-group">
                        <label for="category_id">Category:</label>
                        <select name="category_id" required>
                            <?php foreach ($data['categories'] as $category) : ?>
                            <option value="<?= $category->category_id ?>">
                                <?= $category->category_name ?>
                            </option>
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

                    <div class="fee-notice">
                        <i class="fas fa-info-circle"></i>
                        <p>Note: A 2% service fee will be charged for each successful sale.</p>
                    </div>

                    <div class="form-group">
                        <label for="image">Product Image:</label>
                        <input type="file" name="image" accept="image/*" required
                            onchange="previewImage(this, 'imagePreview')">
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
                <form action="<?php echo URLROOT; ?>/SupplierController/update" method="post"
                    enctype="multipart/form-data">
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
                            <option value="<?= $category->category_id ?>">
                                <?= $category->category_name ?>
                            </option>
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

                    <div class="fee-notice">
                        <i class="fas fa-info-circle"></i>
                        <p>Note: A 2% service fee will be charged for each successful sale.</p>
                    </div>

                    <div class="form-group">
                        <label for="image">Product Image:</label>
                        <input type="file" name="image" accept="image/*"
                            onchange="previewImage(this, 'updateImagePreview')">
                        <!-- <img id="updateImagePreview" class="preview-image" src="" alt=""> -->
                    </div>

                    <div class="form-actions">
                        <button type="submit" class="submit-btn">Update Product</button>
                        <button type="button" class="cancel-btn"
                            onclick="closeModal('updateProductModal')">Cancel</button>
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
                        <button type="button" class="cancel-btn"
                            onclick="closeModal('deleteProductModal')">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showModal(modalId, product = null, urlRoot = '') {
            const modal = document.getElementById(modalId);
            modal.style.display = 'block';

            if (product) {
                if (modalId === 'updateProductModal') {
                    document.getElementById('updateProductId').value = product.product_id;
                    document.getElementById('updateProductName').value = product.product_name;
                    document.getElementById('updateCategory').value = product.category_id;
                    document.getElementById('updatePrice').value = product.price;
                    document.getElementById('updateStock').value = product.stock;
                    document.getElementById('updateDescription').value = product.description;
                    document.getElementById('updateProductExistingImage').value = product.image;
                    document.getElementById('updateImagePreview').src = urlRoot + '/uploads/' + product.image;
                } else if (modalId === 'deleteProductModal') {
                    document.getElementById('deleteProductId').value = product.product_id;
                    document.getElementById('deleteProductName').textContent = product.product_name;
                    document.getElementById('deleteProductCategory').textContent = product.category_name;
                    document.getElementById('deleteProductPrice').textContent = product.price;
                    document.getElementById('deleteProductStock').textContent = product.stock;
                    document.getElementById('deleteProductImage').src = urlRoot + '/uploads/' + product.image;
                }
            }
        }

        function closeModal(modalId) {
            document.getElementById(modalId).style.display = 'none';
        }

        function previewImage(input, previewId) {
            const preview = document.getElementById(previewId);
            if (input.files && input.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(input.files[0]);
            }
        }

        function filterProducts() {
            const input = document.querySelector('.search-box');
            const filter = input.value.toUpperCase();
            const table = document.getElementById('productTable');
            const tr = table.getElementsByTagName('tr');

            for (let i = 1; i < tr.length; i++) {
                const td = tr[i].getElementsByTagName('td')[1];
                if (td) {
                    const txtValue = td.textContent || td.innerText;
                    if (txtValue.toUpperCase().indexOf(filter) > -1) {
                        tr[i].style.display = '';
                    } else {
                        tr[i].style.display = 'none';
                    }
                }
            }
        }
    </script>
</body>

</html>