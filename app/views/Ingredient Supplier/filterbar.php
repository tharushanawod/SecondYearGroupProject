<aside class="sidebar">
            <div class="search-box">
                <input type="text" placeholder="Search products...">
                <button>Search</button>
            </div>
            <div class="filter">
                <h2>Filter by price</h2>
                <input type="range" min="100" max="5000" value="100" class="slider">
                <div class="price-range">
                    <span>LKR 100</span>
                    <span>LKR 5000</span>
                </div>
            </div>
            <div class="categories">
                <h2>Categories</h2>
                <ul>
                    <li><a href="<?php echo URLROOT;?>/SupplierController/seeds">Seeds (<?php echo count($data['products']); ?>)</a></li>
                    <li><a href="<?php echo URLROOT;?>/SupplierController/fertilizer">Fertilizer (<?php echo count($data['fertilizerProducts']); ?>)</a></li>
                    <li><a href="<?php echo URLROOT;?>/SupplierController/pestControl">Pest Control (<?php echo count($data['pestControlProducts']); ?>)</a></li>
                </ul>
            </div>
</aside>