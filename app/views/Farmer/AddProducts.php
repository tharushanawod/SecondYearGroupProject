<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/AddProducts.css">
</head>

<body>
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="container">
        <div class="header">
            <h1>PRODUCTS</h1>
            <?php echo $data['user_id'];?>
            <button class="create-btn" onclick="openPricesPopup()">Show Company Purchase Rate</button>
            <button class="create-btn" onclick="openPopup()">Create New Product</button>
        </div>
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
            </div>
        </div>
        <div class="product-grid">
            <?php if (!empty($data['products'])): ?>
            <?php foreach ($data['products'] as $product): ?>
            <div class="product-card">
                <div class="product-image">
                    <!-- Default image (you can change this if you have a dynamic image URL in the database) -->
                    <img src="<?php echo URLROOT; ?>/<?php echo $product->media; ?>" alt="Corn Product">
                </div>
                <div class="product-info">
                    <!-- Default name -->
                    <div class="product-name">Corn</div>

                    <!-- Product details from the database -->
                    <div class="product-code">Product ID:
                        <?php echo htmlspecialchars($product->productid); ?>
                    </div>
                    <div class="product-code">Quantity :
                        <?php echo htmlspecialchars($product->quantity); ?>(Kg)
                    </div>
                    <div class="product-price">Rs.
                        <?php echo htmlspecialchars($product->price); ?>
                    </div>

                    <div class="countdown-timer" data-expiry-date="<?php echo $product->expiry_date; ?>">
                        Expires in: <span id="countdown-<?php echo $product->productid; ?>"></span>
                    </div>

                    <div class="low-stock-label">
                        <?php echo htmlspecialchars($product->type); ?>
                    </div>


                    <!-- Action buttons -->
                    <div class="action-label">
                        <a href="<?php echo URLROOT; ?>/FarmerController/DeleteProducts/<?php echo $product->productid; ?>"
                            onclick="return confirm('Are you sure you want to delete this product?');">Delete </a>
                    </div>
                    <div class="action-label">
                        <a href="#" onclick="openPopup('<?php echo $product->productid; ?>'); return false;">Update</a>
                    </div>

                </div>
            </div>
            <?php endforeach; ?>
            <?php else: ?>
            <p>No products available.</p>

            <?php endif; ?>
        </div>

    </div>
    </div>

    <div class="popup-overlay" id="popup-overlay">
        <div class="popup-content">
            <h2 class="popup-title">Add Corn for Auction </h2>

            <form id="create-product-form"
                action="<?php echo !empty($data['id']) ? URLROOT . '/FarmerController/UpdateProducts/' . $data['id'] : URLROOT . '/FarmerController/AddProduct'; ?>"
                method="POST" enctype="multipart/form-data">
                
                <div class="form-group">
                    <label for="price">Starting Price (LKR)</label>
                    <input type="number" name="price" class="form-control" id="price"
                        placeholder="Enter price" value="<?php echo $data['price']?>" required>
                    <span class="form-invalid">
                        <?php echo $data['price_err'];?>
                    </span>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity (Kg)</label>
                    <input type="number" name="quantity" class="form-control" id="quantity"
                        placeholder="Enter quantity" value="<?php echo $data['quantity']?>" required>
                    <span class="form-invalid">
                        <?php echo $data['quantity_err'];?>
                    </span>
                </div>
                <div class="form-group">
                    <label for="expiry-date">Closing Date & Time</label>
                    <input type="datetime-local" id="auction-end" name="auction-end" class="form-control">
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
    <div class="prices-popup" id="pricesPopupMessage">
        <h2>Company Purchase Rates</h2>
        <table>
            <thead>
                <tr>
                    <th>Company Name</th>
                    <th>Unit Price (LKR)</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Prima</td>
                    <td>150</td>
                </tr>
                <tr>
                    <td>XYZ Manufacturing</td>
                    <td>145</td>
                </tr>
                <tr>
                    <td>Sri Lanka Foods</td>
                    <td>160</td>
                </tr>
                <tr>
                    <td>Ceylon Agro Industries</td>
                    <td>155</td>
                </tr>
                <tr>
                    <td>Premier Products</td>
                    <td>150</td>
                </tr>
            </tbody>
        </table>
        <button class="prices-close-btn" id="pricesPopupMessage" onclick="closePricesPopup()">Close</button>
    </div>

    <script src="<?php echo URLROOT;?>/js/Farmer/AddProducts.js"></script>

</body>
</html>