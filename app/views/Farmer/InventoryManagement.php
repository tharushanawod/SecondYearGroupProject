<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products Page</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/InventoryManagement.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
    
</head>
<body>

    <div class="container">
        <h1>Inventory Management</h1>
                
        <table id="productTable">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Breed</th>
                    <th>Price</th>
                    <th>Stock(kg)</th>                    
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Dry Corn</td>
                    <td>Corn</td>
                    <td>LKR 1200</td>
                    <td>500 kg</td>    
                </tr>
                <tr>
                    <td>Dry Corn</td>
                    <td>Corn</td>
                    <td>LKR 1500</td>
                    <td>100 kg</td>                    
                </tr>
                <tr>
                    <td>Dry Corn</td>
                    <td>Corn</td>
                    <td>LKR 1000</td>
                    <td>50 kg</td>                    
                </tr>
            </tbody>
        </table>

        <div class="button-row">
            <button id="addProductBtn" class="add-product-btn">Add Product</button>
            <button id="editProductBtn" class="edit-product-btn">Edit Product</button>
            <button id="deleteProductBtn" class="delete-product-btn">Delete Product</button>
        </div>
                
        <div id="productFormModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2 id="formTitle">Add Product</h2>
                <form id="productForm">
                    <label for="productName">Product Name:</label>
                    <input type="text" id="productName" required>
                    
                    <label for="category">Category:</label>
                    <select id="category" required>
                        <option value="Category 1">Fertilizer</option>
                        <option value="Category 2">Seeds</option>
                        <option value="Category 3">Pest Control</option>
                    </select>

                    <label for="price">Price:</label>
                    <input type="number" id="price" required>

                    <label for="stock">Stock:</label>
                    <input type="number" id="stock" required>

                    <label for="imageUpload">Product Image:</label>
                    <input type="file" id="imageUpload" accept="image/*">
                    <img id="imagePreview" src="" alt="Image Preview" style="display:none;">

                    <div class="form-buttons">
                        <button type="submit" id="saveBtn">Save</button>
                        <button type="button" id="cancelBtn">Cancel</button>
                    </div>
                </form>
            </div>
        </div>
    </div>    
</body>
</html>
