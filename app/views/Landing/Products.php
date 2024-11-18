<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Green Market - Product Store</title>
   <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Products.css">
</head>
<body>
  <?php require APPROOT.'/views/inc/components/Header.php'; ?>
<section class="Products-section">
<div class="container">
        <div class="products-grid">
            <!-- Product Card 1 -->
            <div class="product-card">
                <img src="images/card-pic-1.jpg" alt="Product 1" class="product-image">
                <h3 class="product-title">Organic Apple</h3>
                <p class="product-price">$2.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn">-</button>
                    <input type="number" value="1" min="1" class="quantity-input">
                    <button class="quantity-btn">+</button>
                </div>
                <button class="add-to-cart">Add to Cart</button>
            </div>

            <!-- Product Card 2 -->
            <div class="product-card">
                <img src="images/card-pic-2.jpg" alt="Product 2" class="product-image">
                <h3 class="product-title">Fresh Banana</h3>
                <p class="product-price">$1.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn">-</button>
                    <input type="number" value="1" min="1" class="quantity-input">
                    <button class="quantity-btn">+</button>
                </div>
                <button class="add-to-cart">Add to Cart</button>
            </div>

            <!-- Product Card 3 -->
            <div class="product-card">
                <img src="images/card-pic-3.jpg" alt="Product 3" class="product-image">
                <h3 class="product-title">Fresh Orange</h3>
                <p class="product-price">$3.49</p>
                <div class="quantity-control">
                    <button class="quantity-btn">-</button>
                    <input type="number" value="1" min="1" class="quantity-input">
                    <button class="quantity-btn">+</button>
                </div>
                <button class="add-to-cart">Add to Cart</button>
            </div>

            <!-- Product Card 4 -->
            <div class="product-card">
                <img src="images/card-pic-1.jpg" alt="Product 4" class="product-image">
                <h3 class="product-title">Green Grapes</h3>
                <p class="product-price">$4.99</p>
                <div class="quantity-control">
                    <button class="quantity-btn">-</button>
                    <input type="number" value="1" min="1" class="quantity-input">
                    <button class="quantity-btn">+</button>
                </div>
                <button class="add-to-cart">Add to Cart</button>
            </div>
        </div>
    </div>
</section>
    

</body>
</html>