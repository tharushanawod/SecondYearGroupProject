<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/BuyIngredients.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>    
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="container">
        <div class="filters">
            <div class="filter-dropdown">
                <button class="filter-btn">
                    <span>Grouped by:</span>
                    <span>Warehouse</span>
                    <span>▼</span>
                </button>
                <div class="filter-menu">
                    <a href="#">Warehouse</a>
                    <a href="#">Category</a>
                    <a href="#">Price</a>
                </div>
                <div class="cart-icon">
                    <a href="<?php echo URLROOT; ?>/FarmerController/viewCart">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                            <path fill="currentColor" d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/>
                        </svg>
                        <span class="cart-count"><?php echo isset($_SESSION['cart_items']) ? count($_SESSION['cart_items']) : 0; ?></span>
                    </a>
                </div>
            </div>
        </div>
        <div class="product-grid">
            <?php if (empty($data['products'])): ?>
                <div class="no-products">
                    <p>No products available at the moment.</p>
                </div>
            <?php else: ?>
                <?php foreach ($data['products'] as $product): ?>
                    <div class="product-card">
                        <div class="product-image">
                            <img src="<?php echo URLROOT; ?>/uploads/<?php echo $product->image; ?>" alt="<?php echo $product->name; ?>">
                        </div>
                        <div class="product-info">
                            <!-- <span class="category-tag"><?php echo $product->category; ?></span> -->
                            <h3 class="product-name"><?php echo $product->product_name; ?></h3>
                            <div class="product-code">Product ID: <?php echo $product->product_id; ?></div>
                            <div class="product-price">Rs. <?php echo number_format($product->price, 2); ?></div>
                            <div class="product-actions">
                                <a href="<?php echo URLROOT . '/FarmerController/viewDetails/' . $product->product_id; ?>" class="btn btn-view">
                                    View Details
                                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                        <path d="M288 32c-80.8 0-145.5 36.8-192.6 80.6C48.6 156 17.3 208 2.5 243.7c-3.3 7.9-3.3 16.7 0 24.6C17.3 304 48.6 356 95.4 399.4C142.5 443.2 207.2 480 288 480s145.5-36.8 192.6-80.6c46.8-43.5 78.1-95.4 93-131.1c3.3-7.9 3.3-16.7 0-24.6c-14.9-35.7-46.2-87.7-93-131.1C433.5 68.8 368.8 32 288 32zM144 256a144 144 0 1 1 288 0 144 144 0 1 1 -288 0zm144-64c0 35.3-28.7 64-64 64c-7.1 0-13.9-1.2-20.3-3.3c-5.5-1.8-11.9 1.6-11.7 7.4c.3 6.9 1.3 13.8 3.2 20.7c13.7 51.2 66.4 81.6 117.6 67.9s81.6-66.4 67.9-117.6c-11.1-41.5-47.8-69.4-88.6-71.1c-5.8-.2-9.2 6.1-7.4 11.7c2.1 6.4 3.3 13.2 3.3 20.3z"/>
                                    </svg>
                                </a>
                                <form action="<?php echo URLROOT . '/FarmerController/addToCart'; ?>" method="POST"> 
                                    <input type="hidden" name="product_id" value="<?php echo $product->product_id; ?>">
                                    <button type="submit" class="btn btn-cart">
                                        Add To Cart
                                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 576 512">
                                            <path fill="currentColor" d="M0 24C0 10.7 10.7 0 24 0L69.5 0c22 0 41.5 12.8 50.6 32l411 0c26.3 0 45.5 25 38.6 50.4l-41 152.3c-8.5 31.4-37 53.3-69.5 53.3l-288.5 0 5.4 28.5c2.2 11.3 12.1 19.5 23.6 19.5L488 336c13.3 0 24 10.7 24 24s-10.7 24-24 24l-288.3 0c-34.6 0-64.3-24.6-70.7-58.5L77.4 54.5c-.7-3.8-4-6.5-7.9-6.5L24 48C10.7 48 0 37.3 0 24zM128 464a48 48 0 1 1 96 0 48 48 0 1 1 -96 0zm336-48a48 48 0 1 1 0 96 48 48 0 1 1 0-96z"/>
                                        </svg>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
    <script>
    document.addEventListener("DOMContentLoaded", function () {
        const filterBtn = document.querySelector(".filter-btn");
        const filterMenu = document.querySelector(".filter-menu");

        // Toggle the visibility of the dropdown menu
        filterBtn.addEventListener("click", function () {
            filterMenu.classList.toggle("visible");
        });

        // Close the dropdown menu when clicking outside
        document.addEventListener("click", function (event) {
            if (!filterBtn.contains(event.target) && !filterMenu.contains(event.target)) {
                filterMenu.classList.remove("visible");
            }
        });
    });
    </script>
</body>
</html>