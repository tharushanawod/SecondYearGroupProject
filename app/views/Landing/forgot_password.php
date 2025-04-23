<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
    <style>
        :root {
            --primary-color: #4CAF50;
            --primary-hover: #3e9142;
            --accent-color: #ff6b6b;
            --text-color: #333;
            --light-gray: #f5f5f5;
            --medium-gray: #e0e0e0;
            --dark-gray: #757575;
            --shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            --card-radius: 8px;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #e4e9f2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }

        .container {
            width: 100%;
            max-width: 450px;
            background: white;
            border-radius: var(--card-radius);
            box-shadow: var(--shadow);
            padding: 40px;
            overflow: hidden;
            position: relative;
            animation: fadeIn 0.6s ease-out;
        }

        .container::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: var(--primary-color);
        }

        h1 {
            color: var(--text-color);
            margin-bottom: 10px;
            font-size: 1.8rem;
        }

        p {
            color: var(--dark-gray);
            margin-bottom: 30px;
            font-size: 0.95rem;
            line-height: 1.5;
        }

        form {
            display: flex;
            flex-direction: column;
        }

        label {
            color: var(--text-color);
            margin-bottom: 8px;
            font-weight: 500;
            font-size: 0.95rem;
        }

        input {
            padding: 15px;
            border: 1px solid var(--medium-gray);
            border-radius: var(--card-radius);
            margin-bottom: 25px;
            font-size: 1rem;
            transition: border-color 0.3s, box-shadow 0.3s;
        }

        input:focus {
            outline: none;
            border-color: var(--primary-color);
            box-shadow: 0 0 0 3px rgba(76, 175, 80, 0.2);
        }

        button {
            background-color: var(--primary-color);
            color: white;
            border: none;
            padding: 15px;
            border-radius: var(--card-radius);
            cursor: pointer;
            font-size: 1rem;
            font-weight: 500;
            transition: background-color 0.3s, transform 0.2s;
            margin-bottom: 20px;
        }

        button:hover {
            background-color: var(--primary-hover);
        }

        button:active {
            transform: scale(0.98);
        }

        .links {
            display: flex;
            justify-content: center;
            margin-top: 15px;
        }

        .links a {
            color: var(--primary-color);
            text-decoration: none;
            font-size: 0.9rem;
            transition: color 0.3s;
        }

        .links a:hover {
            color: var(--primary-hover);
            text-decoration: underline;
        }

        .icon {
            text-align: center;
            margin-bottom: 20px;
        }

        .icon i {
            font-size: 3rem;
            color: var(--primary-color);
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 480px) {
            .container {
                padding: 30px 20px;
            }

            h1 {
                font-size: 1.5rem;
            }

            button,
            input {
                padding: 12px;
            }
        }
    </style>
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet">
</head>

<body>
    <div class="container">
        <div class="icon">
            <i class="fa-solid fa-lock"></i>
        </div>
        <h1>Reset Your Password</h1>
        <p>Enter your email address, and we'll send you instructions to reset your password.</p>

        <form method="POST" action="<?php echo URLROOT; ?>/LandingController/handleForgotPassword">
            <label for="email">Email Address</label>
            <input type="email" id="email" name="email" placeholder="Enter your registered email" required>
            <span style="color: red; font-weight: bold;"><?php if(isset($data['email_err'])) echo $data['email_err'];?></span>
            <span style="color: red; font-weight: bold;"><?php if(isset($data['success'])) echo $data['success'];?></span>
            <button type="submit">
                <span>Send Reset Link</span>
            </button>
        </form>

        <div class="links">
            <a href="<?php echo URLROOT; ?>/LandingController/Login">Return to Login</a>
        </div>
    </div>
</body>

</html>