<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/BuyIngredients.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet">
</head>
<body>
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="container">
        <div class="filters">
            <div class="filter-dropdown">
                <button class="filter-btn">
                    <span>Grouped by:</span>
                    <span>Category</span>
                    <span>▼</span>
                </button>
                <div class="filter-menu">
                    <a href="#">All</a>
                    <a href="#">Category</a>
                    <a href="#">Price</a>
                </div>
                <div class="cart-icon">
                    <a href="<?php echo URLROOT; ?>/FarmerController/viewCart">
                        <i class="fas fa-shopping-cart"></i>
                        <span class="cart-count"><?php echo isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0; ?></span>
                    </a>
                </div>
            </div>
        </div>

        <div class="product-grid">
            <?php foreach ($data['products'] as $product): ?>
                <a href="<?php echo URLROOT; ?>/FarmerController/viewDetails/<?php echo $product->product_id; ?>" 
                   class="product-card">
                    <div class="product-image">
                        <img src="<?php echo URLROOT; ?>/uploads/<?php echo $product->image; ?>" 
                             alt="<?php echo $product->product_name; ?>">
                    </div>
                    <div class="product-info">
                        <span class="category-tag">
                            <?php echo htmlspecialchars($product->category_name ?? 'No Category'); ?>
                        </span>
                        <h3 class="product-name"><?php echo $product->product_name; ?></h3>
                        <div class="product-price">Rs. <?php echo number_format($product->price, 2); ?></div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    </div>
</body>
</html>