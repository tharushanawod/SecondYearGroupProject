<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/AddProducts.css">
</head>
<style>
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

        /* Styling for the background blur effect */
        .blurred-background {
          
           
        }
</style>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="container">
        <div class="header">
            <h1>PRODUCTS</h1>
            <?php echo $data['userid'];?>
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
                    <div class="product-code">Product ID: <?php echo htmlspecialchars($product->productid); ?></div>
                    <div class="product-code">Quantity : <?php echo htmlspecialchars($product->quantity); ?>(Kg)</div>
                    <div class="product-price">Rs. <?php echo htmlspecialchars($product->price); ?></div>

                    <div class="countdown-timer" data-expiry-date="<?php echo $product->expiry_date; ?>">
    Expires in: <span id="countdown-<?php echo $product->productid; ?>"></span>
</div>

                    <div class="low-stock-label"><?php echo htmlspecialchars($product->type); ?></div>
                    

                    <!-- Action buttons -->
                    <div class="action-label">
                        <a href="<?php echo URLROOT; ?>/FarmerController/DeleteProducts/<?php echo $product->productid; ?>" onclick="return confirm('Are you sure you want to delete this product?');">Delete </a>
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
            <h2 class="popup-title">Create New Product<?php echo empty($data['id']); ?></h2>
            
            <form id="create-product-form" action="<?php echo !empty($data['id']) ? URLROOT . '/FarmerController/UpdateProducts/' . $data['id'] : URLROOT . '/FarmerController/AddProduct'; ?>" method="POST" enctype="multipart/form-data">


                <div class="form-group">
                    <label for="product-type">Product Type</label>
                    <select class="form-control select" id="product-type" name="type">
                        <option value="SweetCorn">Sweet Corn</option>
                        <option value="DryCorn">Dry Corn</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="price">Price (LKR)</label>
                    <input type="number" name="price" class="form-control" id="price" placeholder="Enter price" value="<?php echo $data['price']?>" required>
                     <span class="form-invalid">
                        <?php echo $data['price_err'];?>
                    </span>
                </div>
                <div class="form-group">
                    <label for="quantity">Quantity (Kg)</label>
                    <input type="number"  name="quantity" class="form-control" id="quantity" placeholder="Enter quantity" value="<?php echo $data['quantity']?>" required>
                    <span class="form-invalid">
                        <?php echo $data['quantity_err'];?>
                    </span>
                </div>
                <div class="form-group">
    <label for="expiry-date">Expiry Period (Days)</label>
    <select name="expiry_period" id="expiry-period" class="form-control" required>
        <option value="1">1 Day</option>
        <option value="2">2 Days</option>
        <option value="3">3 Days</option>
        <option value="4">4 Days</option>
        <option value="5">5 Days</option>
        <option value="6">6 Days</option>
        <option value="7">7 Days</option>
    </select>
    </div>
    <div class="form-group">
    <label for="media">Media (images, video, or 3D models)</label>
    <input type="file" class="form-control" id="media" name="media" accept="image/*,video/*,model/*">
    <img id="media-preview" src="#" alt="Current Media" style="display:none; max-width: 200px; margin-top: 10px;">
</div>

                <div class="btn-group">
                    <button type="button" class="btn btn-secondary" onclick="closePopup()">Cancel</button>
                    <button type="submit" class="btn btn-primary">Save</button>
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
            function openPricesPopup() {
            document.getElementById("pricesPopupMessage").style.display = "block";
            document.body.classList.add("blurred-background"); // Add the blur effect to the body
        }

        // Function to close the popup
        function closePricesPopup() {
            document.getElementById("pricesPopupMessage").style.display = "none";
            document.body.classList.remove("blurred-background"); // Remove the blur effect from the body
        }
         document.addEventListener('DOMContentLoaded', function () {
        <?php if (!empty($data['show_popup']) && $data['show_popup'] === true): ?>
            openPopup(); // Call your JavaScript function to show the popup
        <?php endif; ?>
    });

    function openPopup(productId) {
    const popup = document.getElementById('popup-overlay');
    const form = document.getElementById('create-product-form');
    
    if (productId) {
        // Set the form action for the update (UpdateProducts)
        form.action = `<?php echo URLROOT; ?>/FarmerController/UpdateProducts/${productId}`;
        
        // Prepopulate the form with the current product data
        // You can do an AJAX request here to fetch product details if needed
        // For now, let's assume product details are passed to the popup.
        // Example:
        fetchProductData(productId);  // Function to fetch and fill the form (you'll need to implement it)
    } else {
        // Set the form action for the create (AddProduct)
        form.action = `<?php echo URLROOT; ?>/FarmerController/AddProduct`;
    }

    // Show the popup
    popup.style.opacity = '1';
    popup.style.visibility = 'visible';
}
function fetchProductData(productId) {
    fetch(`<?php echo URLROOT; ?>/FarmerController/getProductDetails/${productId}`)
        .then(response => response.json())
        .then(data => {
            document.getElementById('product-type').value = data.type;
            document.getElementById('price').value = data.price;
            document.getElementById('quantity').value = data.quantity;
            document.getElementById('expiry-period').value = data.expiry_period;

            // Update image preview
            const mediaPreview = document.getElementById('media-preview');
            if (data.media) {
                mediaPreview.src = `<?php echo URLROOT; ?>/${data.media}`;
                mediaPreview.style.display = 'block';
            } else {
                mediaPreview.style.display = 'none';
            }
        })
        .catch(error => console.log('Error fetching product data:', error));
}



function closePopup() {
    const popup = document.getElementById('popup-overlay');
    popup.style.opacity = '0';
    popup.style.visibility = 'hidden';
}


        function closePopup() {
            const popup = document.getElementById('popup-overlay');
            popup.style.opacity = '0';
            popup.style.visibility = 'hidden';
        }

        document.addEventListener('DOMContentLoaded', function () {
        const timers = document.querySelectorAll('.countdown-timer');
        timers.forEach(timer => {
            const expiryDate = new Date(timer.getAttribute('data-expiry-date'));
            const countdownElement = timer.querySelector('span');

            function updateCountdown() {
                const now = new Date();
                const timeRemaining = expiryDate - now;

                if (timeRemaining > 0) {
                    const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
                    const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
                    const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

                    countdownElement.textContent = 
                        `${days}d ${hours}h ${minutes}m ${seconds}s`;
                } else {
                    countdownElement.textContent = "Expired";
                }
            }

            // Update countdown every second
            setInterval(updateCountdown, 1000);
            updateCountdown(); // Initial call
        });
    });

        // document.getElementById('create-product-form').addEventListener('submit', (event) => {
        //     event.preventDefault();
        //     // Handle form submission here
        //     console.log('Form submitted:', {
        //         productType: document.getElementById('product-type').value,
        //         price: document.getElementById('price').value,
        //         quantity: document.getElementById('quantity').value,
        //         media: document.getElementById('media').files[0]
        //     });
        //     closePopup();
        // });
    </script>
    <!-- <script>
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
</script> -->
</body>
</html>