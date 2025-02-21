<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($data['product']->product_name) ? htmlspecialchars($data['product']->product_name) : 'Product Details'; ?></title>
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Cart/ViewDetails.css">
</head>
<body>
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>
    
    <div class="product-details-container">
        <!-- Cart Section -->
        <div class="filters">       
            <div class="cart-icon">
                <a href="<?php echo URLROOT; ?>/CartController/viewCart" class="cart-link">
                    <i class="fas fa-shopping-cart"></i>
                    <span class="cart-count"><?php echo isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0; ?></span>
                    View Cart
                </a>
            </div>
        </div>

        <?php if (isset($data['product'])): ?>
            <!-- Product Main Section -->
            <div class="product-main">
                <div class="product-image-section">
                    <img src="<?php echo URLROOT; ?>/uploads/<?php echo $data['product']->image; ?>" 
                         alt="<?php echo $data['product']->product_name; ?>" 
                         class="main-image">
                </div>
                
                <div class="product-info-section">            
                    <h1><?php echo htmlspecialchars($data['product']->product_name); ?></h1>               
                    <div class="category"><?php echo htmlspecialchars($data['product']->category_name); ?></div>
                    <div class="product-price">Rs. <?php echo number_format($data['product']->price, 0); ?></div>
                    
                    <div class="product-description">
                        <h2>Description</h2>
                        <p><?php echo $data['product']->description; ?></p>
                    </div>

                    <div class="stock-info">
                        <h2>Available Stock</h2>
                        <p><?php echo $data['product']->stock; ?> units</p>
                    </div>

                    <!-- Add to Cart Form -->
                    <form action="<?php echo URLROOT; ?>/CartController/addToCart" method="POST" class="add-to-cart-form">
                        <input type="hidden" name="product_id" value="<?php echo $data['product']->product_id; ?>">
                        <input type="hidden" id="maxStock" name="max_stock" value="<?php echo $data['product']->stock; ?>">
                        
                        <div class="quantity-selector">
                            <label for="quantity">Quantity:</label>
                            <input type="number" 
                                   id="quantity" 
                                   name="quantity" 
                                   min="1" 
                                   max="<?php echo $data['product']->stock; ?>" 
                                   value="1" 
                                   class="quantity-input">
                        </div>

                        <button type="submit" class="add-to-cart-btn">
                            <i class="fas fa-shopping-cart"></i> Add to Cart
                        </button>
                    </form>                

                    <!-- Message Container -->
                    <?php if (isset($_SESSION['message'])): ?>
                        <div class="message-div <?php echo $_SESSION['message_type']; ?>">
                            <?php echo $_SESSION['message']; unset($_SESSION['message'], $_SESSION['message_type']); ?>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="product-separator"></div>

            <!-- Related Products Section -->
            <?php if (!empty($data['relatedProducts'])): ?>
                <div class="related-products">
                    <h2>Related Products</h2>
                    <div class="related-products-grid">
                    <?php foreach ($data['relatedProducts'] as $related): ?>
                        <?php if ($related->product_id != $data['product']->product_id): ?>
                        <div class="related-product-card">
                            <img src="<?php echo URLROOT; ?>/uploads/<?php echo $related->image; ?>" 
                             alt="<?php echo $related->product_name; ?>">
                            <div class="related-product-info">
                            <h3><?php echo $related->product_name; ?></h3>
                            <div class="related-product-price">
                                Rs. <?php echo number_format($related->price, 2); ?>
                            </div>
                            <a href="<?php echo URLROOT; ?>/CartController/viewDetails/<?php echo $related->product_id; ?>" 
                               class="view-product-btn">View Product</a>
                            </div>
                        </div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php else: ?>
            <div class="error-message">
                <p>Product not found</p>
                <a href="<?php echo URLROOT; ?>/CartController/browseProducts" class="back-btn">
                    <i class="fas fa-arrow-left"></i> Back to Products
                </a>
            </div>
        <?php endif; ?>
    </div>
</body>
</html>