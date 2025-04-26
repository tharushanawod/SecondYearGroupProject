<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/AddProducts.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>

</head>

<body>
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="container">
        <div class="header">
            <h1>PRODUCTS</h1>
            <?php echo $data['user_id'];?>
            <button class="create-btn" onclick="openPopup()">Add New Product</button>
        </div>
        
        <!-- Filter Section -->
        <div class="filter-bar">
            <div class="filter-group">
                <label class="filter-label">Status</label>
                <select class="filter-select" id="statusFilter">
                    <option value="all">All Products</option>
                    <option value="active">Active</option>
                    <option value="expired">Expired</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Price Range</label>
                <select class="filter-select" id="priceFilter">
                    <option value="all">All Prices</option>
                    <option value="low">Under Rs. 1,000</option>
                    <option value="medium">Rs. 1,000 - Rs. 5,000</option>
                    <option value="high">Above Rs. 5,000</option>
                </select>
            </div>
            <div class="filter-group">
                <label class="filter-label">Sort By</label>
                <select class="filter-select" id="sortFilter">
                    <option value="default">Default</option>
                    <option value="price-asc">Price: Low to High</option>
                    <option value="price-desc">Price: High to Low</option>
                </select>
            </div>
            <div class="filter-buttons">
                <button class="filter-btn reset-btn" id="resetFilters">Reset</button>
                <button class="filter-btn apply-btn" id="applyFilters">Apply Filters</button>
            </div>
        </div>

        <div class="product-grid">
            <?php if (!empty($data['products'])): ?>
            <?php foreach ($data['products'] as $product): ?>
            <?php 
                $isActive = strtotime($product->closing_date) > time();
                $statusClass = $isActive ? 'active' : 'expired';
                $statusText = $isActive ? 'Active' : 'Expired';
                $statusIcon = $isActive ? 'fa-circle-check' : 'fa-circle-xmark';
            ?>
            <div class="product-card" data-price="<?php echo $product->starting_price; ?>" data-status="<?php echo $isActive ? 'active' : 'expired'; ?>">
                <div class="product-image">
                    <img src="<?php echo URLROOT; ?>/<?php echo $product->media; ?>" alt="Corn Product">
                    <div class="status-badge <?php echo $statusClass; ?>">
                        <i class="fas <?php echo $statusIcon; ?>"></i> <?php echo $statusText; ?>
                    </div>
                </div>
                <div class="product-info">
                    <div class="product-name">Corn</div>
                    <div class="product-code">Product ID: <?php echo htmlspecialchars($product->product_id); ?></div>
                    <div class="product-quantity">Quantity: <?php echo htmlspecialchars($product->quantity); ?>(Kg)</div>
                    <div class="product-price">Unit Price: Rs. <?php echo htmlspecialchars($product->starting_price); ?></div>
                    <div class="product-price">Current Highest Bid:  <?php
                    if(empty($product->highest_bid)){
                        echo "No Bids Yet";
                    }else{
                        echo 'Rs.'.htmlspecialchars($product->highest_bid); 
                    }
                    ?></div>
                    <div class="countdown-timer" data-expiry-date="<?php echo $product->closing_date; ?>">
                        <i class="fas fa-clock"></i> <span id="countdown-<?php echo $product->product_id; ?>"></span>
                    </div>

                    <!-- Updated action buttons structure -->
                    <div class="action-buttons">
                        <div class="action-label">
                        <?php if (strtotime($product->closing_date) > time() && empty($product->highest_bid)): ?>
                            <a href="<?php echo URLROOT; ?>/FarmerController/DeleteProducts/<?php echo $product->product_id; ?>"
                                onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                <?php else: ?>
    <span class="disabled-update"> Delete</span>
<?php endif; ?>
                        </div>
                        <div class="action-label">
                        <?php if (strtotime($product->closing_date) > time() && empty($product->highest_bid)): ?>
    <a href="#" onclick="openPopup('<?php echo $product->product_id; ?>'); return false;">Update</a>
<?php else: ?>
    <span class="disabled-update"> Update</span>
<?php endif; ?>

                        </div>
                    </div>
                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <div class="empty-state">
                <i class="fas fa-leaf"></i>
                <p>No products available yet</p>
                <button class="add-first-btn" onclick="openPopup()">Add Your First Product</button>
            </div>
            <?php endif; ?>
        </div>

    </div>
    </div>

    <div class="popup-overlay" id="popup-overlay">
        <div class="popup-content">
            <h2 class="popup-title">Add Corn for Auction </h2>

            <form id="create-product-form"
                method="POST" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label for="price">Starting Price (LKR)</label>
                    <input type="number" name="price" class="form-control" id="price"
                        placeholder="Enter price" value="<?php echo $data['price']?>" min="0" required>
                    <span class="form-invalid">
                        <?php echo $data['price_err'];?>
                    </span>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity (Kg)</label>
                    <input type="number" name="quantity" class="form-control" id="quantity"
                        placeholder="Enter quantity" value="<?php echo $data['quantity']?>" min="0" required>
                    <span class="form-invalid">
                        <?php echo $data['quantity_err'];?>
                    </span>
                </div>
                <div class="form-group">
                    <label for="expiry-date">Closing Date & Time</label>
                    <input type="datetime-local" id="closing_date" name="closing_date" class="form-control" required>
                </div>
                <div class="form-group">
                    <label for="media">Media (images Only)</label>
                    <input type="file" class="form-control" id="media" name="media" accept="image/*,video/*,model/*">
                    <img id="media-preview" src="#" alt="Current Media"
                        style="display:none; max-width: 200px; margin-top: 10px;">
                </div>

                <div class="btn-group">
                    <button type="button" class="btn btn-secondary" onclick="closePopup()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Add</button>
                </div>
            </form>
        </div>
    </div>
    
    <script>
    const URLROOT = '<?php echo URLROOT; ?>';
    </script>
<script src="<?php echo URLROOT; ?>/js/Farmer/AddProducts.js"></script>

</body>
</html>