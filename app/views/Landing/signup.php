<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up Form</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Signup.css">
</head>
<body>
    <div class="container">
        <div class="image-section"><p>Create<br>
            A<br>
            <strong>CornCradle</strong><br>
            Account<br>
            Today
         </p>

         <div class="login-link">
            Already have an account? <a href="<?php echo URLROOT;?>/LandingController/Login"><button class="submit">Log in</button></a>
        </div>
        <div class="login-link">
        A Company
        <a href="<?php echo URLROOT;?>/LandingController/RegisterManufacturer"><button class="submit">Register As A Manufacturer</button></a>
        </div>
        </div>
        <div class="form-section">
            
            <form action="<?php echo URLROOT;?>/LandingController/signup" method="POST">
                <div class="form-group">
                    <label for="name">Name</label>
                    <div class="input-wrapper">
                        <input type="text" id="name" name="name" placeholder="Enter name" value="<?php echo $data['name'];?>">
                    </div>
                    <span class="form-invalid">
                        <?php echo $data['name_err'];?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <input type="email" id="email"  name="email" placeholder="Enter email" value="<?php echo $data['email'];?>">
                    </div>
                    <span class="form-invalid">
                        <?php echo $data['email_err'];?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="phone">Contact Number</label>
                    <div class="input-wrapper">
                        <input type="tel" id="phone" name="phone" placeholder="Enter phone number" value="<?php echo $data['phone'];?>">
                    </div>
                    <span class="form-invalid">
                        <?php echo $data['phone_err'];?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <div class="input-wrapper">
                        <input type="text" id="address" name="address" placeholder="Enter your address" value="<?php echo $data['address'];?>">
                    </div>
                    <span class="form-invalid">
                        <?php echo $data['address_err'];?>
                    </span>
                </div>

                <div class="form-group">
                        <label for="title">Choose a Title :</label>
                        <select id="title" name="title">
                            <option value="farmer">Farmer</option>
                            <option value="buyer">Buyer</option>
                            <option value="supplier">Ingredient Supplier</option>
                            <option value="farmworker">Farm Worker</option>
                        </select>
                        <span class="form-invalid">
                            <?php echo $data['title_err']; ?>
                        </span>
                    </div>


                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="Enter password" value="<?php echo $data['password'];?>">
                    </div>
                    <span class="form-invalid">
                        <?php echo $data['password_err'];?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="confirm-password">Confirm Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="confirm-password" name="confirm_password" placeholder="Enter password" value="<?php echo $data['confirm_password'];?>">
                    </div>
                    <span class="form-invalid">
                        <?php echo $data['confirm_password_err'];?>
                    </span>
                </div>

                <button type="submit">Sign Up</button>
            </form>

           
        </div>
    </div>
</body>
</html>