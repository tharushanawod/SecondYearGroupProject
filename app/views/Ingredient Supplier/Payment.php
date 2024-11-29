<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Page</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/Ingredient Supplier/payment.css">
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
    
    <div class="product-page">
        <div class="image-card">
            <img src="<?php echo URLROOT; ?>/images/<?php echo $data['image'] ?? 'default.jpg'; ?>" 
                 alt="<?php echo $data['product_name'] ?? 'Unknown Product'; ?>">        
        </div>
        <div class="product-details">
            <h1><?php echo $data['product_name'] ?? 'Unknown Product'; ?></h1>
            <p class="price">LKR <?php echo $data['price'] ?? '0.00'; ?></p>
            <p class="stock">In Stock</p>
            <p class="description"><?php echo $data['description'] ?? 'No description available.'; ?></p>
            <div class="add-to-cart">
                <input type="number" value="1" min="1">
                <button onclick="window.location.href='<?php echo URLROOT; ?>/View cart<?php echo $data['id'] ?? 0; ?>'">Add to Cart</button>
            </div>
            <p class="category">Category: 
                <a href="<?php echo URLROOT; ?>/SupplierController/<?php echo strtolower($data['category'] ?? 'uncategorized'); ?>">
                    <?php echo $data['category'] ?? 'Uncategorized'; ?>
                </a>
            </p>
        </div>
    </div>
    
    <div class="tabs">
        <button class="tab-button active" onclick="openTab(event, 'description')">Description</button>
        <button class="tab-button" onclick="openTab(event, 'reviews')">Reviews (0)</button>
    </div>
    <div id="description" class="tab-content active">
        <p>Nitrogen rich fertilizer is a type of fertilizer that contains high levels of nitrogen, which is an essential nutrient for plant growth. It helps in promoting healthy growth, increased yield, and improved quality of crops. Nitrogen rich fertilizer is available in various forms such as liquid, granular, and slow-release, and can be applied through soil or foliar application methods. It is crucial for maintaining soil fertility and ensuring optimal plant growth.</p>
    </div>
    <div id="reviews" class="tab-content">
        <p>No reviews yet.</p>
    </div>
    
    <div class="related-products">
        <h2>Related products</h2>
        <div class="product-list">
            <div class="product-item">
                <img src="<?php echo URLROOT; ?>/images/images/img47.jpeg" alt="Product 1">
                <p>Urea rich fertilizer</p>
                <p class="price">LKR 1500.00</p>
            </div>
            <div class="product-item">
                <img src="<?php echo URLROOT; ?>/images/images/img48.jpeg" alt="Product 2">
                <p>Phosphorus rich fertilizer</p>
                <p class="price">LKR 2000.00</p>
            </div>
            <div class="product-item">
                <img src="<?php echo URLROOT; ?>/images/images/img49.jpeg" alt="Product 3">
                <p>Potassium rich fertilizer</p>
                <p class="price">LKR 3000.00</p>
            </div>
        </div>
    </div>
    
    <script src="<?php echo URLROOT; ?>/js/Ingredient Supplier/payment.js"></script>    
</body>
</html>
