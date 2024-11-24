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
          
            <div class="heading">
                <h2>Welcome Back 👋</h2>
                <p>Login to your account</p>
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

                <button type="submit">Log in</button>
            </form>
        </div>

        <div class="image-section">
            <p>Create<br>
                A<br>
                <strong>CornCradle</strong><br>
                Account<br>
                Today
            </p>

            <div class="login-link">
                Don't have an account? <a href="<?php echo URLROOT;?>/LandingController/signup"><button class="new" type="submit">Sign up</button></a>
            </div>
        </div>

    </div>



    </div>
</body>

</html>