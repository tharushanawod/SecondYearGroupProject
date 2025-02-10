<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/AddProducts.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
    <style>
        @import url(../components/sidebar.css);

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
  font-family: sans-serif;
}

body {
  background-color: #f4f4f4;
}

.container {
  max-width: 1400px;
  margin-left:250px;
  padding: 40px;
}

.header {
  display: flex;
  justify-content: space-between;
  align-items: center;
  margin-bottom: 32px;
}

.header h1 {
  font-size: 24px;
  color: #333;
}

.create-btn {
  background-color: #2e8f68;
  color: white;
  padding: 8px 16px;
  border-radius: 6px;
  border: none;
  cursor: pointer;
  font-weight: 500;
}

.filters {
  display: flex;
  justify-content: flex-end;
  margin-bottom: 24px;
}

.filter-dropdown {
  position: relative;
  display: inline-block;
}

.filter-btn {
  background-color: white;
  color: #666;
  padding: 8px 16px;
  border: 1px solid #ddd;
  border-radius: 6px;
  cursor: pointer;
  display: flex;
  align-items: center;
  gap: 8px;
}

.filter-menu {
  display: none;
  position: absolute;
  background-color: white;
  border: 1px solid #ccc;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  padding: 10px;
  z-index: 10;
}

.filter-menu.visible {
  display: block;
}

.filter-menu a {
  display: block;
  padding: 5px;
  text-decoration: none;
  color: black;
}

.filter-menu a:hover {
  background-color: #f0f0f0;
}
.product-grid {
  display: grid;
  grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
  gap: 24px;
}

.product-card {
  background-color: white;
  border-radius: 8px;
  overflow: hidden;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
  transition: transform 0.2s ease;
}

.product-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

.product-image {
  background-color: #f8f9fa;
  display: flex;
  justify-content: center;
  align-items: center;
}

.product-image img {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}

.product-info {
  padding: 16px;
}

.product-name {
  font-size: 18px;
  font-weight: 600;
  color: #2c3e50;
  margin-bottom: 8px;
}

.product-code {
  color: #666;
  font-size: 14px;
  margin-bottom: 8px;
}

.product-price {
  font-size: 20px;
  font-weight: bold;
  color: #2e8f68;
  margin-bottom: 16px;
}

.countdown-timer {
  font-size: 14px;
  color: #666;
  margin-bottom: 8px;
  background-color: #f8f9fa;
  border-radius: 4px;
}

/* Updated action buttons styling */
.action-buttons {
  display: flex;
  gap: 8px;
}

.action-label {
  flex: 1;
  text-align: center;
  padding: 8px;
  border-radius: 4px;
  background-color: #2e8f68;
  transition: background-color 0.2s ease;
  cursor: pointer;
}

.action-label:hover {
  background-color:rgb(17, 110, 73);
}

.action-label a {
  display: block;
  width: 100%;
  font-size: 14px;
  font-weight: 500;
  color: white;
}

/* Remove these unused/redundant styles */
.low-stock-label,
.filter-menu,
.filter-menu.visible,
.filter-menu a,
.filter-menu a:hover {
  display: none;
}

.popup-overlay {
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0, 0, 0, 0.5);
    display: flex;
    justify-content: center;
    align-items: center;
    z-index: 999;
    opacity: 0;
    visibility: hidden;
    transition: opacity 0.3s, visibility 0.3s;
}

.popup-content {
    background-color: white;
    padding: 32px;
    border-radius: 12px;
    width: 400px;
    max-width: 90%;
    box-shadow: 0 2px 8px rgba(0, 0, 0, 0.15);
}

.popup-title {
    font-size: 20px;
    font-weight: 600;
    color: #333;
    margin-bottom: 24px;
}

.form-group {
    margin-bottom: 20px;
}

.form-group label {
    display: block;
    font-size: 14px;
    color: #666;
    margin-bottom: 8px;
}

.form-control {
    width: 100%;
    padding: 10px 16px;
    font-size: 16px;
    border: 1px solid #ddd;
    border-radius: 6px;
}

.form-control:focus {
    outline: none;
    border-color: #6c5ce7;
}

.form-control.select {
    appearance: none;
    -webkit-appearance: none;
    background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 24 24' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M7 10l5 5 5-5z'/%3E%3C/svg%3E");
    background-repeat: no-repeat;
    background-position: right 12px center;
    background-size: 18px;
}

.btn-group {
    display: flex;
    justify-content: flex-end;
    gap: 12px;
}

.btn {
    padding: 8px 16px;
    font-size: 14px;
    border-radius: 6px;
    cursor: pointer;
}

.btn-primary {
    background-color: #2e8f68;
    color: white;
    border: none;
}

.btn-secondary {
    background-color: #f4f4f4;
    color: #666;
    border: 1px solid #ddd;
}

.icon{
  display: flex;
  column-gap: 5px;
}

a {
  text-decoration: none;
  color: inherit;
}


.prices-btn {
  padding: 10px 20px;
  background-color: #4CAF50;
  color: white;
  border: none;
  cursor: pointer;
  font-size: 16px;
}

.prices-btn:hover {
  background-color: #45a049;
}

/* Popup message box */
.prices-popup {
  display: none;
  position: fixed;
  top: 50%;
  left: 50%;
  transform: translate(-50%, -50%);
  padding: 20px;
  background-color: white;
  border: 2px solid #4CAF50;
  box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
  z-index: 1000;
  max-width: 500px;
  width: 100%;
  overflow-x: auto;
}

.prices-popup h2 {
  margin: 0;
  font-size: 20px;
}

.prices-popup table {
  width: 100%;
  border-collapse: collapse;
  margin-top: 15px;
}

.prices-popup table, .prices-popup th, .prices-popup td {
  border: 1px solid #ddd;
}

.prices-popup th, .prices-popup td {
  padding: 10px;
  text-align: left;
}

.prices-popup th {
  background-color: #4CAF50;
  color: white;
}

.prices-popup td {
  background-color: #f9f9f9;
}

.prices-popup .prices-close-btn {
  background-color: #f44336;
  color: white;
  border: none;
  padding: 8px 16px;
  cursor: pointer;
  font-size: 16px;
  margin-top: 10px;
}

.prices-popup .prices-close-btn:hover {
  background-color: #e53935;
}

@media (max-width:768px) {
  .container{
    margin-left: 110px;
  }
  .header{
    flex-direction: column;
    align-items: flex-start;
    
  }
  .header *{
    margin-bottom: 10px;
  }
}

@media (max-width: 1024px) {
  .header{
    flex-direction: column;
    align-items: flex-start;
    
  }
  .header *{
    margin-bottom: 10px;
  }
  
}
    </style>
</head>

<body>
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="container">
        <div class="header">
            <h1>PRODUCTS</h1>
            <?php echo $data['user_id'];?>
            <button class="create-btn" onclick="openPopup()">Add New Product</button>
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
                    <div class="product-name">Corn</div>
                    <div class="product-code">Product ID: <?php echo htmlspecialchars($product->product_id); ?></div>
                    <div class="product-code">Quantity: <?php echo htmlspecialchars($product->quantity); ?>(Kg)</div>
                    <div class="product-price">Unit Price: Rs. <?php echo htmlspecialchars($product->starting_price); ?></div>
                    <div class="countdown-timer" data-expiry-date="<?php echo $product->closing_date; ?>">
                        Closing Time: <span id="countdown-<?php echo $product->product_id; ?>"></span>
                    </div>

                    <!-- Updated action buttons structure -->
                    <div class="action-buttons">
                        <div class="action-label">
                            <a href="<?php echo URLROOT; ?>/FarmerController/DeleteProducts/<?php echo $product->product_id; ?>"
                                onclick="return confirm('Are you sure you want to delete this product?');">Delete</a>
                        </div>
                        <div class="action-label">
                            <a href="#" onclick="openPopup('<?php echo $product->product_id; ?>'); return false;">Update</a>
                        </div>
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
                    <input type="datetime-local" id="closing_date" name="closing_date" class="form-control">
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
    
    <script>
    const URLROOT = '<?php echo URLROOT; ?>';
 
</script>
<script src="<?php echo URLROOT;?>/js/Farmer/AddProducts.js"></script>

</body>
</html>