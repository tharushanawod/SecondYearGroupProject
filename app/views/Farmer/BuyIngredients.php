<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/AddProducts.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="container">
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
            <?php foreach ($data['products'] as $product): ?>
                <div class="product-card">
                    <div class="product-image">
                        <img src="<?php echo URLROOT; ?>/uploads/<?php echo $product->image; ?>" alt="<?php echo $product->name; ?>">
                    </div>
                    <div class="product-info">
                        <div class="product-name"><?php echo $product->name; ?></div>
                        <div class="product-code">Product ID: <?php echo $product->product_id; ?></div>
                        <div class="product-price">Rs.<?php echo $product->price; ?></div>
                        <div class="action-label">
                            <a href="<?php echo URLROOT;?>/FarmerController/ViewCart"><div class="icon">Add To Cart<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512"><!--!Font Awesome Free 6.7.0 by @fontawesome - https://fontawesome.com License - https://fontawesome.com/license/free Copyright 2024 Fonticons, Inc.--><path d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/></svg></div></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script>
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
    </script>
</body>
</html>