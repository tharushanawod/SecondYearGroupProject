<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/ViewDetails.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
    <title>Product Details</title>
    <script src="<?php echo URLROOT;?>/js/jquery-3.2.1.min.js"></script>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
<div class="product-details-container">
    <!-- Product Main Section -->
    <div class="product-main">
        <div class="product-image-section">
            <img src="<?php echo URLROOT; ?>/uploads/<?php echo $data['product']->image; ?>" alt="<?php echo $data['product']->name; ?>" class="main-image">
        </div>
        
        <div class="product-info-section">
            <span class="category-tag">Pesticides</span>
            <h1 class="product-title"><?php echo $data['product']->name; ?></h1>
            <div class="product-id">Product ID: <?php echo $data['product']->product_id; ?></div>
            <div class="product-price">Rs. <?php echo number_format($data['product']->price, 2); ?></div>
            
            <div class="product-description">
                <h2>Description</h2>
                <p><?php echo $data['product']->description; ?></p>
            </div>

            <div class="product-usage">
                <h2>Usage Instructions</h2>
                <p><?php echo $data['product']->usage_instructions; ?></p>
            </div>

            <div class="action-buttons">
                <a href="<?php echo URLROOT; ?>/FarmerController/addToCart" class="add-to-cart-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                        <path fill="currentColor" d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/>
                    </svg>
                    Add To Cart
                </a>
            </div>
        </div>
    </div>

    <!-- Related Products Section -->
    <div class="related-products">
        <h2>Related Products</h2>
        <div class="related-products-grid">
            <?php foreach ($data['relatedProducts'] as $related): ?>
                <div class="related-product-card">
                    <img src="<?php echo URLROOT; ?>/uploads/<?php echo $related->image; ?>" alt="<?php echo $related->name; ?>">
                    <div class="related-product-info">
                        <h3><?php echo $related->name; ?></h3>
                        <div class="related-product-price">Rs. <?php echo number_format($related->price, 2); ?></div>
                        <a href="<?php echo URLROOT; ?>/FarmerController/viewDetails/<?php echo $related->product_id; ?>" class="view-product-btn">View Product</a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>
</body>
</html>