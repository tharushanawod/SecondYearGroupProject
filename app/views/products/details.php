<div class="product-details">
    <div class="product-image">
        <img src="<?php echo URLROOT . '/' . $data['product']->image; ?>" alt="<?php echo $data['product']->name; ?>">
    </div>
    <div class="product-info">
        <h2><?php echo $data['product']->name; ?></h2>
        <p class="price">LKR <?php echo $data['product']->price; ?></p>
        <p class="description"><?php echo $data['product']->description; ?></p>
        <p class="stock">In Stock: <?php echo $data['product']->quantity; ?></p>
        
        <form action="<?php echo URLROOT; ?>/cart/add" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $data['product']->id; ?>">
            <input type="number" name="quantity" value="1" min="1" max="<?php echo $data['product']->quantity; ?>">
            <button type="submit" class="add-to-cart">Add to Cart</button>
        </form>
    </div>
</div>
