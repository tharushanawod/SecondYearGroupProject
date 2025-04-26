<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Supplier Registration</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Register.css">
</head>
<body>
   
    <div class="container">
        <div class="left-section">
            <div class="logo"><a href="<?php echo URLROOT;?>/LandingController/index"><img src="<?php echo URLROOT; ?>/images/logo.png" alt="" style="width:150px;"></a></div>
            <div class="icons-container">
                <div class="icon icon-1"></div>
                <div class="icon icon-2"></div>
                <div class="icon icon-3"></div>
            </div>
            <h1 class="typing"> Register As A Supplier</h1>
            <p>Register today to connect with farmers in need of high-quality ingredients for their crops. Showcase your products, receive direct orders, and grow your business by supplying essential materials to the agricultural community. Join Corn Cradle and be part of a smarter, more efficient marketplace!</p>
        </div>
        <div class="form-container">
        <form action="<?php echo URLROOT;?>/LandingController/signup" method="POST" enctype="multipart/form-data">

            <input type="hidden" name="user_type" value="supplier">
                <div class="form-group">
                    <label for="name">Full name</label>
                    <input type="text" id="name" name="name" placeholder="Enter name" value="<?php echo $data['name'];?>">
                    <span class="form-invalid">
                        <?php echo $data['name_err'];?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email"  name="email" placeholder="Enter email" value="<?php echo $data['email'];?>">
                    <span class="form-invalid">
                        <?php echo $data['email_err'];?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" name="phone" placeholder="Enter phone number" 
                                value="<?php echo $data['phone'];?>" 
                                pattern="0\d{9}" 
                                title="Phone number must start with 0 and be exactly 10 digits.">
                
                                <span class="form-invalid">
                            <?php echo $data['phone_err']; ?>
                        </span>
                </div> 

                <div class="form-group">
                    <label for="document">Verificaton Document (license to sell agricultural chemicals) </label>
                    <input type="file" id="document" name="document" placeholder="Upload your license to sell agricultural chemicals" required>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" placeholder="Enter At least 8 characters" minlength="8" value="<?php echo $data['password'];?>">
                    <span class="form-invalid">
                        <?php echo $data['password_err'];?>
                    </span>
                </div>

                <div class="form-group">
                    <label for="confirm-password">Re Type Password</label>
                    <input type="password" id="confirm-password" name="confirm_password" placeholder="Enter At least 8 characters" minlength="8" value="<?php echo $data['confirm_password'];?>">
                    <span class="form-invalid">
                        <?php echo $data['confirm_password_err'];?>
                    </span>
                </div>

                <div class="form-group terms-checkbox">
                    <input type="checkbox" id="terms" name="terms" required>
                    <label for="terms">I agree to the <a href="<?php echo URLROOT;?>/LandingController/terms" target="_blank">Terms and Conditions</a></label>
                </div>

                <button type="submit" class="signup-btn">Sign up</button>
                <p class="login-text">Been here before? <a href="<?php echo URLROOT;?>/LandingController/Login">Log in</a></p>
            </form>
        </div>
    </div>
</body>
</html>