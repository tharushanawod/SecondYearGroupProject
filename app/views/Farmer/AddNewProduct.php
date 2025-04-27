<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/AddProducts.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>

<body>
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="container">
        <div class="header">
            <h1>ADD NEW PRODUCT</h1>
        </div>
        
        <div class="product-form-container">
            <form id="add-product-form" action="<?php echo URLROOT; ?>/FarmerController/AddProduct" method="POST" enctype="multipart/form-data">
                <div class="form-group">
                    <label for="price">Starting Price (LKR)</label>
                    <input type="number" name="price" class="form-control" id="price"
                        placeholder="Enter starting price" value="<?php echo isset($data['price']) ? $data['price'] : ''; ?>" min="0" required>
                    <span class="form-invalid">
                        <?php echo isset($data['price_err']) ? $data['price_err'] : ''; ?>
                    </span>
                </div>
                
                <div class="form-group">
                    <label for="quantity">Quantity (Kg)</label>
                    <input type="number" name="quantity" class="form-control" id="quantity"
                        placeholder="Enter quantity" value="<?php echo isset($data['quantity']) ? $data['quantity'] : ''; ?>" min="0" required>
                    <span class="form-invalid">
                        <?php echo isset($data['quantity_err']) ? $data['quantity_err'] : ''; ?>
                    </span>
                </div>
                
                <div class="form-group">
                    <label for="closing_date">Closing Date & Time</label>
                    <input type="datetime-local" id="closing_date" name="closing_date" class="form-control" required>
                    <span class="form-invalid">
                        <?php echo isset($data['closing_date_err']) ? $data['closing_date_err'] : ''; ?>
                    </span>
                </div>
                
                <div class="form-group">
                    <label for="media">Product Image</label>
                    <input type="file" class="form-control" id="media" name="media" accept="image/*" required>
                    <img id="media-preview" src="#" alt="Product Preview" style="display:none; max-width: 200px; margin-top: 10px;">
                    <span class="form-invalid">
                        <?php echo isset($data['media_err']) ? $data['media_err'] : ''; ?>
                    </span>
                </div>
                
                <div class="form-buttons"> 
                   <a href="<?php echo URLROOT; ?>/FarmerController/AddProduct"><button type="button" class="btn btn-secondary" >Cancel</button></a>
                    <button type="submit" class="btn btn-primary">Add Product</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Preview image before upload
        document.getElementById('media').addEventListener('change', function(e) {
            const preview = document.getElementById('media-preview');
            const file = e.target.files[0];
            
            if (file) {
                preview.style.display = 'block';
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                
                reader.readAsDataURL(file);
            } else {
                preview.style.display = 'none';
            }
        });
        
        // Set minimum date for closing date
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            today.setDate(today.getDate() + 1); // Set minimum to tomorrow
            
            const year = today.getFullYear();
            const month = String(today.getMonth() + 1).padStart(2, '0');
            const day = String(today.getDate()).padStart(2, '0');
            const hours = String(today.getHours()).padStart(2, '0');
            const minutes = String(today.getMinutes()).padStart(2, '0');
            
            const minDateTime = `${year}-${month}-${day}T${hours}:${minutes}`;
            document.getElementById('closing_date').setAttribute('min', minDateTime);
        });
    </script>
</body>
</html>