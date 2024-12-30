<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manufacturer Registration</title>
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
            <h1 class="typing"> Register As A <br>Manufacturer</h1>
            <p>Your contributions will empower farmers with valuable pricing insights and support a fairer marketplace for all. Join Corn Cradle and make a meaningful impact on Sri Lanka’s agricultural community!</p>
        </div>
        <div class="form-container">
            <form>
                <div class="form-group">
                    <label for="name">Full name</label>
                    <input type="text" id="name" placeholder="Example Name" required>
                </div>

                <div class="form-group">
                    <label for="companyname">Company name</label>
                    <input type="text" id="companyname" placeholder="Example Company Name" required>
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
                    <label for="ducument">Verificaton Document (Company Registration Document) </label>
                    <input type="file" id="document" placeholder="Upload your license to sell agricultural chemicals" required>
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