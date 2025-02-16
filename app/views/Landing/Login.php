<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Login.css">
</head>

<body>
    <div class="container">
        <div class="form-section">
          
        <div class="Home">
        <div class="heading">
                <h2>Welcome Back 👋</h2>
                <p>Login to your account</p>
            </div>
            <a href="<?php echo URLROOT;?>/LandingController/index"><img width="40" height="40" src="https://img.icons8.com/ios-filled/50/home.png" alt="home"/></a>
        </div>
           

            <form action="<?php echo URLROOT;?>/LandingController/Login" method="POST">

                <div class="form-group">
                    <label for="email">Email</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" placeholder="Enter email" name="email" value="<?php echo $data['email'];?>">
                        <span class="form-invalid" ><?php echo $data['email_err'];?></span>
                    </div>
                </div>
               


                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" placeholder="Enter password" name="password" value="<?php echo $data['password'];?>">
                        <span class="form-invalid" ><?php echo $data['password_err'];?></span>
                    </div>
                </div>

                 <span class="form-invalid">
                 <?php echo $data['verified_err'];?>
                 </span>

                <?php $_SESSION['user_email'] = $data['email']; ?>

                <div class="forgot-password" >
                    <p>Forgot Your Password</p>
                <a href="<?php echo URLROOT;?>/LandingController/ForgotPassword">Reset Password From Here</a>
            </div>



                <button type="submit">Log in</button>
                <?php
                echo $_SESSION['user_email'];
                ?>
            </form>

            <?php if (isset($data['verified_err']) && !empty($data['verified_err'])): ?>
    <!-- Display the "Verify Account" button if the error is related to unverified status -->
    <?php if ($data['verified_err'] == 'Your account is not verified. Please verify account using OTP.'): ?>
        <form action="<?php echo URLROOT; ?>/LandingController/verifyAccount" method="POST">
            <button type="submit" class="verify-button">Click here to verify your account</button>
        </form>
    <?php endif; ?>
<?php endif; ?>


            

        </div>

        <div class="image-section">
            <p>Create<br>
                A<br>
                <strong>CornCradle</strong><br>
                Account<br>
                Today
            </p>

            <div class="login-link">
                Don't have an account? <a href="<?php echo URLROOT;?>/LandingController/Register"><button class="new" >Sign up</button></a>
            </div>
        </div>

    </div>



    </div>
</body>

</html>