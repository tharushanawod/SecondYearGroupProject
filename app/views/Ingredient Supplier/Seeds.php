<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seeds</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Ingredient Supplier/shop.css">
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>   
    <div class="container"> 
    <div class="inside">
        <h1>Seeds</h1>
        <p>Home / Seeds</p>
    </div>               
        <div class="filterbar">            
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
                    <option value="<?php echo URLROOT;?>/SupplierController/shop">All Products</option>
                    <option value="<?php echo URLROOT;?>/SupplierController/fertilizer">Fertilizer (<?php echo isset($data['fertilizerProducts']) ? count($data['fertilizerProducts']) : 0; ?>)</option>
                    <option value="<?php echo URLROOT;?>/SupplierController/seeds">Seeds (<?php echo isset($data['products']) ? count($data['products']) : 0; ?>)</option>
                    <option value="<?php echo URLROOT;?>/SupplierController/pestControl">Pest Controls (<?php echo isset($data['pestControlProducts']) ? count($data['pestControlProducts']) : 0; ?>)</option>
                </select>
            </div>            
        </div>
        <main class="product-list">           
            <?php foreach ($data['products'] as $product): ?>
            <div class="product">
                <img src="<?php echo URLROOT;?>/uploads/<?php echo $product->image; ?>" alt="<?php echo $product->product_name; ?>">
                <p class="category"><?php echo $product->category_name; ?></p>
                <h3><?php echo $product->product_name; ?></h3>
                <p class="price">LKR <?php echo $product->price; ?></p>
                <!-- <form action="<?php echo URLROOT; ?>/SupplierController/viewCart/<?php echo $product->id; ?>" method="get">
                    <button type="submit" class="add-to-cart-button">Add to Cart</button>
                </form>                  -->
            </div>
            <?php endforeach; ?>
        </main>
    </div>
</body>
</html>