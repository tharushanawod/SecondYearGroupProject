<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shop/All Products</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Ingredient Supplier/shop.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet" />
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="container">
        <div class="inside">
            <h1>All Products</h1>
            <p>Home / All Products</p>
        </div>
        <aside class="filterbar">            
            <div class="filter">
                <h2>Filter by price</h2>
                <input type="range" min="100" max="5000" value="100" class="slider">
                <div class="price-range">
                    <span>LKR 100</span>
                    <span>LKR 5000</span>
                </div>
            </div>            
            <div class="categories-dropdown">
                <h2>Categories</h2>
                <select onchange="location = this.value;">
                    <option value=""></option>
                    <option value="<?php echo URLROOT;?>/SupplierController/fertilizer">Fertilizer (<?php echo isset($data['fertilizerProducts']) ? count($data['fertilizerProducts']) : 0; ?>)</option>
                    <option value="<?php echo URLROOT;?>/SupplierController/seeds">Seeds (<?php echo isset($data['seedsProducts']) ? count($data['seedsProducts']) : 0; ?>)</option>
                    <option value="<?php echo URLROOT;?>/SupplierController/pestControl">Pest Controls (<?php echo isset($data['pestControlProducts']) ? count($data['pestControlProducts']) : 0; ?>)</option>
                </select>
            </div>
        </aside>
        <main class="product-list">            
            <?php foreach ($data['products'] as $product): ?>
            <div class="product">
                <img src="<?php echo URLROOT;?>/uploads/<?php echo $product->image; ?>" alt="<?php echo $product->product_name; ?>">
                <p class="category"><?php echo $product->category; ?></p>
                <h3><?php echo $product->product_name; ?></h3>
                <p class="price">LKR <?php echo $product->price; ?></p>
                <!-- <form action="<?php echo URLROOT; ?>/SupplierController/addToCart/<?php echo $product->id; ?>" method="post">
                    <button type="submit" class="add-to-cart-button">Add to Cart</button>
                </form>                  -->
            </div>
            <?php endforeach; ?>
        </main>
    </div>
</body>
</html>