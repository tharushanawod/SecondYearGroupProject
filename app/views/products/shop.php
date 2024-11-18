<div class="shop-container">
    <div class="categories">
        <a href="?category=fertilizer">Fertilizers</a>
        <a href="?category=seeds">Seeds</a>
        <a href="?category=pestcontrol">Pest Control</a>
    </div>

    <div class="products-grid">
        <?php foreach($data['products'] as $product): ?>
            <div class="product-card">
                <img src="<?php echo URLROOT . '/' . $product->image; ?>" alt="<?php echo $product->name; ?>">
                <h3><?php echo $product->name; ?></h3>
                <p class="price">LKR <?php echo $product->price; ?></p>
                <a href="<?php echo URLROOT; ?>/products/details/<?php echo $product->id; ?>" class="view-btn">View Details</a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
