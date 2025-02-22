<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buy Ingredients</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Cart/BuyIngredients.css">
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
                    <a href="<?php echo URLROOT; ?>/CartController/browseProducts">All</a>
                    <?php if(isset($data['categories']) && !empty($data['categories'])): ?>
                        <?php foreach ($data['categories'] as $category): ?>
                            <a href="<?php echo URLROOT; ?>/CartController/BuyIngredients/<?php echo $category->category_id; ?>">
                                <?php echo htmlspecialchars($category->category_name); ?>
                            </a>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
                <div class="cart-icon">
                    <?php if(isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'farmer'): ?>
                        <a href="<?php echo URLROOT; ?>/CartController/viewCart" class="cart-link">
                            <i class="fas fa-shopping-cart"></i>
                            <?php
                                $cartCount = isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0;
                            ?>
                            <span class="cart-count"><?php echo $cartCount; ?></span>
                            
                        </a>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="product-grid">
            <?php if(isset($data['products']) && !empty($data['products'])): ?>
                <?php foreach ($data['products'] as $product): ?>
                    <a href="<?php echo URLROOT; ?>/CartController/viewDetails/<?php echo $product->product_id; ?>" 
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
                            <input type="hidden" id="productId" value="<?php echo $product->product_id; ?>">
                            <input type="hidden" id="maxStock" value="<?php echo $product->stock; ?>">
                            <input type="hidden" id="quantity" value="1">                        
                        </div>
                    </a>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No products found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>