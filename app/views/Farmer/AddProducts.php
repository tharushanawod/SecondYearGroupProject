<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/AddProducts.css">
</head>
<body>
<?php require 'sidebar.php';?>
    <div class="container">
        <div class="header">
            <h1>PRODUCTS</h1>
          
            <button class="create-btn" onclick="openPopup()">Create New Product</button>
        </div>
        <div class="filters">
            <div class="filter-dropdown">
                <button class="filter-btn">
                    <span>Grouped by:</span>
                    <span>Warehouse</span>
                    <span>▼</span>
                </button>
                <div class="filter-menu">
                    <a href="#">Warehouse</a>
                    <a href="#">Category</a>
                    <a href="#">Price</a>
                </div>
            </div>
        </div>
        <div class="product-grid">
    <?php if (!empty($data['products'])): ?>
        <?php foreach ($data['products'] as $product): ?>
            <div class="product-card">
                <div class="product-image">
                    <!-- Default image (you can change this if you have a dynamic image URL in the database) -->
                    <img src="<?php echo URLROOT; ?>/images/bottom.jpg" alt="Corn Product">
                </div>
                <div class="product-info">
                    <!-- Default name -->
                    <div class="product-name">Corn</div>

                    <!-- Product details from the database -->
                    <div class="product-code">Product ID: <?php echo htmlspecialchars($product->productid); ?></div>
                    <div class="product-code">Quantity : <?php echo htmlspecialchars($product->quantity); ?>(Kg)</div>
                    <div class="product-price">Rs. <?php echo htmlspecialchars($product->price); ?></div>
                    <div class="low-stock-label"><?php echo htmlspecialchars($product->type); ?></div>

                    <!-- Action buttons -->
                    <div class="action-label">
                        <a href="<?php echo URLROOT; ?>/FarmerController/DeleteProducts/<?php echo $product->productid; ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete </a>
                    </div>
                    <div class="action-label">
                        <a href="<?php echo URLROOT; ?>/FarmerController/UpdateProduct/<?php echo $product->id; ?>">Update</a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <p>No products available.</p>
    <?php endif; ?>
</div>

        </div>
    </div>

    <div class="popup-overlay" id="popup-overlay">
        <div class="popup-content">
            <h2 class="popup-title">Create New Product</h2>
            
            <form id="create-product-form" action="<?php echo URLROOT;?>/FarmerController/AddProduct" method="POST">
                <div class="form-group">
                    <label for="product-type">Product Type</label>
                    <select class="form-control select" id="product-type" name="type">
                        <option value="sweet-corn">Sweet Corn</option>
                        <option value="dry-corn">Dry Corn</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="price">Price (LKR)</label>
                    <input type="number" step="10" name="price" class="form-control" id="price" placeholder="Enter price" value="<?php echo $data['price']?>" required>
                     <span class="form-invalid">
                        <?php echo $data['price_err'];?>
                    </span>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity (Kg)</label>
                    <input type="number" step="100" name="quantity" class="form-control" id="quantity" placeholder="Enter quantity" value="<?php echo $data['quantity']?>" required>
                    <span class="form-invalid">
                        <?php echo $data['quantity_err'];?>
                    </span>
                </div>
                <!-- <div class="form-group">
                    <label for="media">Media (images, video or 3D models)</label>
                    <input type="file" class="form-control" id="media" accept="image/*,video/*,model/*" required>
                </div> -->
                <div class="btn-group">
                    <button type="button" class="btn btn-secondary" onclick="closePopup()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
    <div class="t"><button type="button" class="btn btn-secondary" onclick="openPopup()">click me</button></div>
    <script>
         document.addEventListener('DOMContentLoaded', function () {
        <?php if (!empty($data['show_popup']) && $data['show_popup'] === true): ?>
            openPopup(); // Call your JavaScript function to show the popup
        <?php endif; ?>
    });

        function openPopup() {
            const popup = document.getElementById('popup-overlay');
            popup.style.opacity = '1';
            popup.style.visibility = 'visible';
        }

        function closePopup() {
            const popup = document.getElementById('popup-overlay');
            popup.style.opacity = '0';
            popup.style.visibility = 'hidden';
        }

        // document.getElementById('create-product-form').addEventListener('submit', (event) => {
        //     event.preventDefault();
        //     // Handle form submission here
        //     console.log('Form submitted:', {
        //         productType: document.getElementById('product-type').value,
        //         price: document.getElementById('price').value,
        //         quantity: document.getElementById('quantity').value,
        //         media: document.getElementById('media').files[0]
        //     });
        //     closePopup();
        // });
    </script>
    <!-- <script>
    document.addEventListener("DOMContentLoaded", function () {
        const filterBtn = document.querySelector(".filter-btn");
        const filterMenu = document.querySelector(".filter-menu");

        // Toggle the visibility of the dropdown menu
        filterBtn.addEventListener("click", function () {
            filterMenu.classList.toggle("visible");
        });

        // Close the dropdown menu when clicking outside
        document.addEventListener("click", function (event) {
            if (!filterBtn.contains(event.target) && !filterMenu.contains(event.target)) {
                filterMenu.classList.remove("visible");
            }
        });
    });
</script> -->
</body>
</html>