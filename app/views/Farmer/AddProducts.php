<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/Farmer/AddProducts.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>

<body>
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>

    <div class="container">
        <div class="header">
            <h1>PRODUCTS</h1>
            <a href="<?php echo URLROOT; ?>/FarmerController/AddNewProduct">
                <button class="create-btn">Add New Product</button>
            </a>
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

        <!-- Product Grid -->
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
                            <div class="product-quantity">Quantity: <?php echo htmlspecialchars($product->quantity); ?> (Kg)</div>
                            <div class="product-price">Unit Price: Rs. <?php echo htmlspecialchars($product->starting_price); ?></div>
                            <div class="product-price">Current Highest Bid:  
                                <?php 
                                    echo empty($product->highest_bid) ? "No Bids Yet" : 'Rs.' . htmlspecialchars($product->highest_bid);
                                ?>
                            </div>
                            <div class="countdown-timer" data-expiry-date="<?php echo $product->closing_date; ?>">
                                <i class="fas fa-clock"></i> <span id="countdown-<?php echo $product->product_id; ?>"></span>
                            </div>

                            <!-- Action Buttons -->
                            <div class="action-buttons">
                                <div class="action-label">
                                    <?php if ($isActive && empty($product->highest_bid)): ?>
                                        <a href="<?php echo URLROOT; ?>/FarmerController/DeleteProducts/<?php echo $product->product_id; ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                                    <?php else: ?>
                                        <span class="disabled-update">Delete</span>
                                    <?php endif; ?>
                                </div>
                                <div class="action-label">
                                    <?php if ($isActive && empty($product->highest_bid)): ?>
                                        <a href="<?php echo URLROOT; ?>/FarmerController/UpdateProducts/<?php echo $product->product_id; ?>">Update</a>
                                    <?php else: ?>
                                        <span class="disabled-update">Update</span>
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

   <script>
    // Event listener for DOM content loaded
document.addEventListener("DOMContentLoaded", function () {
  // Countdown timer logic
  const timers = document.querySelectorAll(".countdown-timer");
  const input = document.getElementById("closing_date");

  timers.forEach((timer) => {
    const expiryDate = new Date(timer.getAttribute("data-expiry-date"));
    const countdownElement = timer.querySelector("span");

    function updateCountdown() {
      const now = new Date();
      const timeRemaining = expiryDate - now;

      if (timeRemaining > 0) {
        const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
        const hours = Math.floor(
          (timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );
        const minutes = Math.floor(
          (timeRemaining % (1000 * 60 * 60)) / (1000 * 60)
        );
        const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

        countdownElement.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
      } else {
        countdownElement.textContent = "Expired";
      }
    }

    // Update countdown every second
    setInterval(updateCountdown, 1000);
    updateCountdown(); // Initial call
  });
});


// Filter functionality
document.addEventListener("DOMContentLoaded", function() {
    const statusFilter = document.getElementById("statusFilter");
    const priceFilter = document.getElementById("priceFilter");
    const sortFilter = document.getElementById("sortFilter");
    const resetFiltersBtn = document.getElementById("resetFilters");
    const applyFiltersBtn = document.getElementById("applyFilters");
    const productCards = document.querySelectorAll(".product-card");
    
    applyFiltersBtn.addEventListener("click", applyFilters);
    resetFiltersBtn.addEventListener("click", resetFilters);
    
    function applyFilters() {
        const statusValue = statusFilter.value;
        const priceValue = priceFilter.value;
        const sortValue = sortFilter.value;
        
        productCards.forEach(card => {
            let showCard = true;
            const cardPrice = parseFloat(card.dataset.price);
            const cardStatus = card.dataset.status;
            
            // Status filter
            if (statusValue !== 'all' && cardStatus !== statusValue) {
                showCard = false;
            }
            
            // Price filter
            if (priceValue !== 'all') {
                if (priceValue === 'low' && cardPrice >= 1000) {
                    showCard = false;
                } else if (priceValue === 'medium' && (cardPrice < 1000 || cardPrice > 5000)) {
                    showCard = false;
                } else if (priceValue === 'high' && cardPrice <= 5000) {
                    showCard = false;
                }
            }
            
            card.style.display = showCard ? 'block' : 'none';
        });
        
        // Sort products
        sortProducts(sortValue);
    }
    
    function sortProducts(sortValue) {
        const productGrid = document.querySelector('.product-grid');
        const products = Array.from(productCards).filter(card => card.style.display !== 'none');
        
        if (sortValue === 'price-asc') {
            products.sort((a, b) => parseFloat(a.dataset.price) - parseFloat(b.dataset.price));
        } else if (sortValue === 'price-desc') {
            products.sort((a, b) => parseFloat(b.dataset.price) - parseFloat(a.dataset.price));
        }
        
        // Reorder products in the DOM
        products.forEach(product => productGrid.appendChild(product));
    }
    
    function resetFilters() {
        statusFilter.value = 'all';
        priceFilter.value = 'all';
        sortFilter.value = 'default';
        
        productCards.forEach(card => {
            card.style.display = 'block';
        });
        
        // Reset sort order
        const productGrid = document.querySelector('.product-grid');
        const products = Array.from(productCards);
        products.sort((a, b) => {
            return parseInt(a.querySelector('.product-code').textContent.match(/\d+/)[0]) - 
                   parseInt(b.querySelector('.product-code').textContent.match(/\d+/)[0]);
        });
        
        products.forEach(product => productGrid.appendChild(product));
    }
});


   </script>
</body>

</html>
