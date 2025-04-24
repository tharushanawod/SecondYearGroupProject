<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login to CornCradle</title>
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --primary: #22c55e;
            --primary-dark: #16a34a;
            --primary-light: #dcfce7;
            --text-dark: #333;
            --text-light: #666;
            --gray-light: #f8f8f8;
            --gray-medium: #ddd;
            --white: #ffffff;
            --shadow: 0 8px 30px rgba(0, 0, 0, 0.12);
            --border-radius: 16px;
            --transition: all 0.3s ease;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
        }
        
        body {
            min-height: 100vh;
            display: flex;
            background-color: #f5f5f5;
            background-image: url("../images/SignUpBackground.png");
            background-size: cover;
            background-position: center;
        }
        
        .container {
            display: flex;
            width: 60%;
            margin: auto;
            border-radius: var(--border-radius);
            overflow: hidden;
            box-shadow: var(--shadow);
        }
        
        a {
            text-decoration: none;
            color: inherit;
            transition: var(--transition);
        }
        
        .home-link {
            display: flex;
            align-items: center;
            color: var(--text-dark);
            gap: 8px;
            font-weight: 500;
            transition: var(--transition);
        }
        
        .home-link:hover {
            color: var(--primary);
            transform: translateY(-2px);
        }
        
        .home-link img {
            width: 24px;
            height: 24px;
        }
        
        .form-section {
            flex: 1;
            background: var(--white);
            padding: 40px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            border-top-left-radius: var(--border-radius);
            border-bottom-left-radius: var(--border-radius);
            position: relative;
            z-index: 1;
        }
        
        .form-section::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            height: 100%;
            width: 30px;
            background: linear-gradient(to left, rgba(0,0,0,0.03), transparent);
            z-index: -1;
        }
        
        .header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 40px;
        }
        
        .heading h2 {
            font-size: 28px;
            color: var(--text-dark);
            margin-bottom: 8px;
            font-weight: 600;
        }
        
        .heading p {
            color: var(--text-light);
            font-size: 16px;
        }
        
        .form-group {
            margin-bottom: 24px;
        }
        
        label {
            display: block;
            margin-bottom: 8px;
            color: var(--text-dark);
            font-weight: 500;
            font-size: 14px;
        }
        
        .input-wrapper {
            position: relative;
        }
        
        input {
            width: 100%;
            padding: 14px 16px;
            border: 1px solid var(--gray-medium);
            border-radius: 12px;
            font-size: 15px;
            transition: var(--transition);
            background: var(--gray-light);
        }
        
        input:focus {
            outline: none;
            border-color: var(--primary);
            background: var(--white);
            box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.1);
        }
        
        .form-invalid {
            color: #e53e3e;
            font-size: 13px;
            margin-top: 6px;
            display: block;
        }
        
        button {
            width: 100%;
            padding: 14px;
            background: var(--primary);
            color: var(--white);
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: var(--transition);
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }
        
        button:hover {
            background: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(34, 197, 94, 0.2);
        }
        
        button:active {
            transform: translateY(0);
        }
        
        .forgot-password {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            font-size: 14px;
        }
        
        .forgot-password a {
            color: var(--primary);
            font-weight: 500;
        }
        
        .forgot-password a:hover {
            text-decoration: underline;
        }
        
        .image-section {
            flex: 1;
            background-image: linear-gradient(rgba(0, 0, 0, 0.65), rgba(0, 0, 0, 0.55)), url("../images/signup.jpeg");
            background-size: cover;
            background-position: center;
            color: var(--white);
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            padding: 60px 40px;
            border-top-right-radius: var(--border-radius);
            border-bottom-right-radius: var(--border-radius);
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }
        
        .image-title {
            font-size: 3.5rem;
            font-weight: 700;
            line-height: 1.2;
            margin-bottom: 20px;
        }
        
        .image-title span {
            color: var(--primary);
        }
        
        .signup-section {
            text-align: center;
        }
        
        .signup-section p {
            margin-bottom: 16px;
            font-size: 16px;
            opacity: 0.9;
        }
        
        .signup-button {
            max-width: 200px;
            margin: 0 auto;
            background-color: transparent;
            border: 2px solid var(--white);
        }
        
        .signup-button:hover {
            background-color: var(--white);
            color: var(--text-dark);
            border-color: var(--white);
        }
        
        .verify-button {
            margin-top: 16px;
            background-color: #4299e1;
        }
        
        .verify-button:hover {
            background-color: #3182ce;
            box-shadow: 0 4px 12px rgba(66, 153, 225, 0.2);
        }
        
        /* Animation */
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .form-section {
            animation: fadeIn 0.6s ease-out;
        }
        
        .image-section {
            animation: fadeIn 0.6s ease-out 0.2s both;
        }
        
        /* Responsive styles */
        @media (max-width: 992px) {
            .container {
                max-width: 70%;
            }
            
            .image-title {
                font-size: 2.8rem;
            }
        }
        
        @media (max-width: 768px) {
            .container {
                flex-direction: column-reverse;
                max-width: 75%;
            }
            
            .form-section, .image-section {
                border-radius: var(--border-radius);
                width: 100%;
            }
            
            .form-section {
                padding: 30px;
            }
            
            .image-section {
                padding: 40px 30px;
                text-align: center;
            }
            
            .image-title {
                font-size: 2.2rem;
                margin-bottom: 16px;
            }
        }
        
        @media (max-width: 480px) {
            .container {
                max-width: 100%;
                margin: 0;
                border-radius: 0;
            }
            
            .form-section, .image-section {
                border-radius: 0;
                padding: 24px;
            }
            
            .forgot-password {
                flex-direction: column;
                align-items: flex-start;
                gap: 8px;
            }
            
            .header {
                margin-bottom: 24px;
            }
            
            .heading h2 {
                font-size: 24px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="form-section">
            <div class="header">
                <div class="heading">
                    <h2>Welcome Back 👋</h2>
                    <p>Login to your account</p>
                </div>
                <a href="<?php echo URLROOT;?>/LandingController/index" class="home-link">
                    <img src="https://img.icons8.com/ios-filled/50/home.png" alt="home"/>
                    <span>Home</span>
                </a>
            </div>

            <form action="<?php echo URLROOT;?>/LandingController/Login" method="POST">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" placeholder="Enter your email" name="email" value="<?php echo $data['email'];?>">
                        <span class="form-invalid"><?php echo $data['email_err'];?></span>
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" placeholder="Enter your password" name="password" value="<?php echo $data['password'];?>">
                        <span class="form-invalid"><?php echo $data['password_err'];?></span>
                    </div>
                </div>

                <span class="form-invalid">
                    <?php if (isset($data['verified_err'])) echo $data['verified_err']; ?>
                </span>

                <?php $_SESSION['user_email'] = $data['email']; ?>

                <div class="forgot-password">
                    <p>Forgot your password?</p>
                    <a href="<?php echo URLROOT;?>/LandingController/ForgotPassword">Reset password here</a>
                </div>

                <button type="submit">
                    <i class="fas fa-sign-in-alt"></i> Log in
                </button>
            </form>

            <?php if (isset($data['verified_err']) && !empty($data['verified_err'])): ?>
                <?php if ($data['verified_err'] == 'Your account is not verified. Please verify account using OTP.'): ?>
                    <form action="<?php echo URLROOT; ?>/LandingController/verifyAccount" method="POST">
                        <button type="submit" class="verify-button">
                            <i class="fas fa-check-circle"></i> Verify your account
                        </button>
                    </form>
                <?php endif; ?>
            <?php endif; ?>
        </div>

        <div class="image-section">
            <div>
                <h1 class="image-title">Join <br><span>CornCradle</span></br> Today</h1>
            </div>

            <div class="signup-section">
                <p>Don't have an account yet?</p>
                <a href="<?php echo URLROOT;?>/LandingController/Register">
                    <button class="signup-button">
                        <i class="fas fa-user-plus"></i> Sign up
                    </button>
                </a>
            </div>
        </div>
    </div>
</body>

</html>