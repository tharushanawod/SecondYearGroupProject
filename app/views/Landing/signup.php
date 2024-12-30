<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration Options</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/SignUp.css">
</head>
<body>
    <div class="container">
        <h1>Choose Your Registration Type</h1>
        <form method="GET" action="<?php echo URLROOT;?>/LandingController/signup">
            <div class="cards-grid">
                <!-- Farmer Card -->
                <div class="card">
                    <div class="card-icon"><img width="100" height="100" src="https://img.icons8.com/plasticine/100/farmer-male.png" alt="farmer-male"/></div>
                    <h2>Register as a Farmer</h2>
                    <p>Join our platform as a farmer and connect with buyers, access market insights, and grow your business.</p>
            
                    <button type="submit" name="user_type" value="farmer" class="register-btn">Register Now</button>
                  
                </div>

                <!-- Buyer Card -->
                <div class="card">
                    <div class="card-icon"><img width="96" height="96" src="https://img.icons8.com/color/96/budget.png" alt="budget"/></div>
                    <h2>Register as a Buyer</h2>
                    <p>Source quality products directly from farmers and suppliers for your business needs.</p>
       
                    <button type="submit" name="user_type" value="buyer" class="register-btn">Register Now</button>
                </div>

                <!-- Manufacturer Card -->
                <div class="card">
                    <div class="card-icon"><img width="100" height="100" src="https://img.icons8.com/officel/100/manufacturing.png" alt="manufacturing"/></div>
                    <h2>Register as a Manufacturer</h2>
                    <p>Connect with suppliers and streamline your manufacturing process with our platform.</p>
              
                    <button type="submit" name="user_type" value="manufacturer" class="register-btn">Register Now</button>
                </div>

                <!-- Ingredient Supplier Card -->
                <div class="card">
                    <div class="card-icon"><img width="64" height="64" src="https://img.icons8.com/external-filled-outline-geotatah/64/external-chemical-free-eco-friendly-lifestyle-filled-outline-filled-outline-geotatah-5.png" alt="ingredient-supplier"/></div>
                    <h2>Register as an Ingredient Supplier</h2>
                    <p>Reach manufacturers and businesses looking for quality ingredients and supplies.</p>
              
                    <button type="submit" name="user_type" value="supplier" class="register-btn">Register Now</button>
                </div>

                <!-- Farmworker Card -->
                <div class="card">
                    <div class="card-icon"><img width="96" height="96" src="https://img.icons8.com/color/96/worker-beard.png" alt="worker-beard"/></div>
                    <h2>Register as a Farmworker</h2>
                    <p>Find opportunities to work with farmers and contribute to agricultural success.</p>
             
                    <button type="submit" name="user_type" value="farmworker" class="register-btn">Register Now</button>
                </div>
            </div>
        </form>
    </div>
</body>
</html>
