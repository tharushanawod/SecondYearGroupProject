<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop/All Products</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Ingredient Supplier/shop.css">
</head>
<body>
    <?php require 'shop header.php';?>
    <div class="container">
        <aside class="sidebar">
            <div class="search-box">
                <input type="text" placeholder="Search products...">
                <button>Search</button>
            </div>
            <div class="filter">
                <h2>Filter by price</h2>
                <input type="range" min="100" max="5000" value="100" class="slider">
                <div class="price-range">
                    <span>LKR 100</span>
                    <span>LKR 5000</span>
                </div>
            </div>
            <div class="categories">
                <h2>Categories</h2>
                <ul>
                    <li><a href="<?php echo URLROOT;?>/SupplierController/fertilizer">Fertilizer (10)</a></li>
                    <li><a href="<?php echo URLROOT;?>/SupplierController/seeds">Seeds (9)</a></li>
                    <li><a href="<?php echo URLROOT;?>/SupplierController/pestControl">Pest Controls (10)</a></li>
                </ul>
            </div>
        </aside>
        <main class="product-list">
            <div class="inside">
                <h1>Shop</h1>
                <p>Home / All Products</p>
            </div>
                <div class="product">
                <img src="<?php echo URLROOT;?>/images/images/img49.jpeg" alt="Nitrogen-Rich Corn Fertilizer">
                <p class="category">Fertilizers</p>
                <h3>Nitrogen-Rich Corn Fertilizer</h3>
                <span class="price">LKR 2500.00</span>
            </div>
            <div class="product">
                <img src="<?php echo URLROOT;?>/images/images/img47.jpeg" alt="Phosphate-Rich Corn Fertilizer">
                <p class="category">Fertilizers</p>
                <h3>Phosphate-Rich Corn Fertilizer</h3>
                <p class="price"><span class="old-price">LKR 3500.00</span> LKR 2500.00</p>
                <span class="sale-badge">Sale!</span>
            </div>
            <div class="product">
                <img src="<?php echo URLROOT;?>/images/images/img50.jpeg" alt="Potassium-Rich Corn Fertilizer">
                <p class="category">Fertilizers</p>
                <h3>Potassium-Rich Corn Fertilizer</h3>
                <p class="price"><span class="old-price">LKR 3500.00</span> LKR 2500.00</p>
                <span class="sale-badge">Sale!</span>
            </div>
            <div class="product">
                <img src="<?php echo URLROOT;?>/images/images/img48.jpeg" alt="Organic Insecticide">
                <p class="category">Insecticides</p>
                <h3>Organic Insecticide</h3>
                <span class="price">LKR 3500.00</span>
            </div>
            <div class="product">
                <img src="<?php echo URLROOT;?>/images/images/img44.jpeg" alt="Organic Seeds">
                <p class="category">Seeds</p>
                <h3>Organic Seeds</h3>
                <span class="price">LKR 3500.00</span>
            </div>
            <div class="product">
                <img src="<?php echo URLROOT;?>/images/images/img43.jpeg" alt="Organic Pesticide">
                <p class="category">Pesticides</p>
                <h3>Organic Pesticide</h3>
                <span class="price">LKR 3500.00</span>
            </div>
        </main>
    </div>
</body>
</html>