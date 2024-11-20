<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Fertilizer</title>
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
                    <li><a href="<?php echo URLROOT;?>/SupplierController/fertilizer">Fertilizer (<?php echo count($data['products']); ?>)</a></li>
                    <li><a href="<?php echo URLROOT;?>/SupplierController/seeds">Seeds (<?php echo count($data['seedsProducts']); ?>)</a></li>
                    <li><a href="<?php echo URLROOT;?>/SupplierController/pestControl">Pest Control (<?php echo count($data['pestControlProducts']); ?>)</a></li>
                </ul>
            </div>
        </aside>
        <main class="product-list">
            <div class="inside">
                <h1>Fertilizer</h1>
                <p>Home / Fertilizer</p>
            </div>
            <?php foreach ($data['products'] as $product): ?>
            <div class="product">
                <img src="<?php echo URLROOT;?>/images/<?php echo $product->image; ?>" alt="<?php echo $product->product_name; ?>">
                <p class="category"><?php echo $product->category; ?></p>
                <h3><?php echo $product->product_name; ?></h3>
                <p class="price">LKR <?php echo $product->price; ?></p>  
                <form action="<?php echo URLROOT; ?>/SupplierController/viewCart/<?php echo $product->id; ?>" method="get">
                    <button type="submit" class="add-to-cart-button">Add to Cart</button>
                </form>              
            </div>
            <?php endforeach; ?>
        </main>
    </div>
</body>
</html>