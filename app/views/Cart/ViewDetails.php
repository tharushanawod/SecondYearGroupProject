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
            <?php if(isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'farmer'): ?>
                <div class="cart-icon">
                    <a href="<?php echo URLROOT; ?>/CartController/viewCart" class="cart-link">
                        <i class="fas fa-shopping-cart"></i>
                        <?php
                            $cartCount = isset($_SESSION['cart_count']) ? $_SESSION['cart_count'] : 0;
                        ?>
                        <span class="cart-count"><?php echo $cartCount; ?></span>
                        View Cart 
                    </a>
                </div>
            <?php endif; ?>
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
            
            <div class="supplier-rating-section">
                <h2>Supplier Ratings & Reviews</h2>
                
                <!-- Average Rating Display -->
                <div class="rating-summary">
                    <div class="average-rating">
                        <span class="rating-number"><?php echo $data['averageRating']; ?></span>
                        <div class="stars">
                            <?php for($i = 1; $i <= 5; $i++): ?>
                                <i class="fa<?php echo ($i <= $data['averageRating']) ? 's' : 'r'; ?> fa-star"></i>
                            <?php endfor; ?>
                        </div>
                        <span class="total-ratings">(<?php echo $data['totalRatings']; ?> reviews)</span>
                    </div>
                </div>
            
                <!-- Reviews List -->
                <div class="reviews-list">
                    <?php if(!empty($data['reviews'])): ?>
                        <?php foreach($data['reviews'] as $review): ?>
                            <div class="review-card">
                                <div class="review-header">
                                    <img src="<?php echo URLROOT; ?>/<?php echo $review->file_path ?? 'img/profile/default.jpg'; ?>" 
                                         alt="Reviewer" class="reviewer-image">
                                    <div class="reviewer-info">
                                        <h4><?php echo htmlspecialchars($review->farmer_name); ?></h4>
                                        <div class="stars">
                                            <?php for($i = 1; $i <= 5; $i++): ?>
                                                <i class="fa<?php echo ($i <= $review->rating) ? 's' : 'r'; ?> fa-star"></i>
                                            <?php endfor; ?>
                                        </div>
                                        <span class="review-date"><?php echo date('M d, Y', strtotime($review->created_at)); ?></span>
                                    </div>
                                </div>
                                <p class="review-text"><?php echo htmlspecialchars($review->review_text); ?></p>
                            </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <p class="no-reviews">No reviews yet</p>
                    <?php endif; ?>
                </div>
            
                <!-- Rating Form -->
                <?php if(isset($_SESSION['user_id']) && $_SESSION['user_role'] === 'farmer'): ?>
                    <div class="add-rating-form">
                        <h3>Rate this Supplier</h3>
                        <form action="<?php echo URLROOT; ?>/SupplierController/addRating" method="POST">
                            <input type="hidden" name="supplier_id" value="<?php echo $data['product']->supplier_id; ?>">
                            <input type="hidden" name="product_id" value="<?php echo $data['product']->product_id; ?>">
                            <div class="star-rating">
                                <input type="hidden" name="rating" id="ratingInput" value="0">
                                <?php for($i = 5; $i >= 1; $i--): ?>
                                    <span class="star" data-rating="<?php echo $i; ?>">★</span>
                                <?php endfor; ?>
                            </div>
                            <textarea name="review" class="review-input" placeholder="Write your review here..." required></textarea>
                            <button type="submit" class="submit-rating-btn">Submit Review</button>
                        </form>
                    </div>
                <?php endif; ?>
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