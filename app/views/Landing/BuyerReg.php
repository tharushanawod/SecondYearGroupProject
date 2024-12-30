<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buyer Registration</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Register.css">
</head>
<body>
   
    <div class="container">
        <div class="left-section">
        <div class="logo"><img src="<?php echo URLROOT; ?>/images/logo.png" alt="" style="width:150px;"></div>
            <div class="icons-container">
                <div class="icon icon-1"></div>
                <div class="icon icon-2"></div>
                <div class="icon icon-3"></div>
            </div>
            <h1 class="typing"> Register As A Buyer</h1>
            <p>Register today to connect directly with trusted Sri Lankan farmers, participate in fair bidding, and secure the freshest corn at competitive prices. Enjoy a seamless experience with transparent transactions and real-time updates. Don’t miss out—be a part of a smarter agricultural marketplace!</p>
        </div>
        <div class="form-container">
            <form>
                <div class="form-group">
                    <label for="name">Full name</label>
                    <input type="text" id="name" placeholder="Example Name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" placeholder="example.email@gmail.com" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="tel" id="phone" placeholder="ex:- 07-xxxxxxxx" required>
                </div> 

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="password-field">
                        <input type="password" id="password" placeholder="Enter at least 8+ characters" minlength="8" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="confirm-password">Re Type Password</label>
                    <div class="password-field">
                        <input type="password" id="confirm-password" placeholder="Retype your password" minlength="8" required>
                    </div>
                </div>

                <button type="submit" class="signup-btn">Sign up</button>
                <p class="login-text">Been here before? <a href="#">Log in</a></p>
            </form>
        </div>
    </div>
</body>
</html>