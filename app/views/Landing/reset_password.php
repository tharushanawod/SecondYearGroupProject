<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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

        .password-container {
            position: relative;
        }

        .toggle-password {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: var(--dark-gray);
            transition: color 0.3s;
        }

        .toggle-password:hover {
            color: var(--primary-color);
        }

        .password-strength {
            height: 5px;
            margin-top: -20px;
            margin-bottom: 20px;
            border-radius: 3px;
            background: var(--medium-gray);
            overflow: hidden;
        }

        .password-strength-meter {
            height: 100%;
            width: 0;
            border-radius: 3px;
            transition: width 0.3s, background-color 0.3s;
        }

        .password-info {
            display: none;
            color: var(--dark-gray);
            font-size: 0.8rem;
            margin-top: -20px;
            margin-bottom: 20px;
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
            <i class="fa-solid fa-key"></i>
        </div>
        <h1>Create New Password</h1>
        <p>Your password must be at least 8 characters and include a mix of letters, numbers, and symbols.</p>

        <form method="POST" action="<?php echo URLROOT;?>/LandingController/resetPassword">
            <label for="password">New Password</label>
            <div class="password-container">
                <input type="password" id="password" name="password" placeholder="Enter your new password" required>
                <i class="toggle-password fa-regular fa-eye" data-target="password"></i>
            </div>
            <div class="password-strength">
                <div class="password-strength-meter"></div>
            </div>
            <div class="password-info">Password should be at least 8 characters</div>

            <label for="confirm_password">Confirm Password</label>
            <div class="password-container">
                <input type="password" id="confirm_password" name="confirm_password"
                    placeholder="Confirm your new password" required>
                <i class="toggle-password fa-regular fa-eye" data-target="confirm_password"></i>
            </div>

            <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">
            <button type="submit">
                <span>Reset Password</span>
            </button>
        </form>

        <div class="links">
            <a href="index.php?controller=auth&action=login">Return to Login</a>
        </div>
    </div>

    <script>
        // Toggle password visibility
        document.querySelectorAll('.toggle-password').forEach(toggle => {
            toggle.addEventListener('click', function () {
                const targetId = this.getAttribute('data-target');
                const input = document.getElementById(targetId);

                if (input.type === 'password') {
                    input.type = 'text';
                    this.classList.remove('fa-eye');
                    this.classList.add('fa-eye-slash');
                } else {
                    input.type = 'password';
                    this.classList.remove('fa-eye-slash');
                    this.classList.add('fa-eye');
                }
            });
        });

        // Password strength meter
        const passwordInput = document.getElementById('password');
        const strengthMeter = document.querySelector('.password-strength-meter');
        const passwordInfo = document.querySelector('.password-info');

        passwordInput.addEventListener('input', function () {
            const value = this.value;
            passwordInfo.style.display = 'block';

            // Very basic strength calculation
            let strength = 0;

            if (value.length >= 8) strength += 25;
            if (value.match(/[a-z]/)) strength += 25;
            if (value.match(/[A-Z]/)) strength += 25;
            if (value.match(/[0-9]/) || value.match(/[^a-zA-Z0-9]/)) strength += 25;

            strengthMeter.style.width = strength + '%';

            if (strength <= 25) {
                strengthMeter.style.backgroundColor = '#ff4757';
                passwordInfo.textContent = 'Weak password';
            } else if (strength <= 50) {
                strengthMeter.style.backgroundColor = '#ffa502';
                passwordInfo.textContent = 'Fair password';
            } else if (strength <= 75) {
                strengthMeter.style.backgroundColor = '#2ed573';
                passwordInfo.textContent = 'Good password';
            } else {
                strengthMeter.style.backgroundColor = '#2ed573';
                passwordInfo.textContent = 'Strong password';
            }

            // Hide info if input is empty
            if (value.length === 0) {
                passwordInfo.style.display = 'none';
            }
        });

        // Confirm password match
        const confirmInput = document.getElementById('confirm_password');
        const form = document.querySelector('form');

        form.addEventListener('submit', function (e) {
            if (passwordInput.value !== confirmInput.value) {
                e.preventDefault();
                alert('Passwords do not match. Please try again.');
                confirmInput.focus();
            }
        });
    </script>
</body>

</html>