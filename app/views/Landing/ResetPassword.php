<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background-color: #f0f5f0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
        }

        .container {
            background-color: white;
            padding: 2rem;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            margin: 1rem;
        }

        h1 {
            color: #2e7d32;
            text-align: center;
            margin-bottom: 1.5rem;
            font-size: 24px;
        }

        p {
            color: #4a4a4a;
            text-align: center;
            margin-bottom: 2rem;
            font-size: 14px;
        }

        .form-group {
            margin-bottom: 1.5rem;
        }

        input[type="email"] {
            width: 100%;
            padding: 12px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }

        input[type="email"]:focus {
            outline: none;
            border-color: #2e7d32;
        }

        .btn {
            width: 100%;
            padding: 12px;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .btn-primary {
            background-color: #2e7d32;
            color: white;
            margin-bottom: 1rem;
        }

        .btn-primary:hover {
            background-color: #1b5e20;
        }

        .btn-secondary {
            display: block;
            background-color: transparent;
            color: #2e7d32;
            border: 1px solid #2e7d32;
            text-decoration: none;
            width: 100%;
            text-align: center;
        }

        .btn-secondary:hover {
            background-color: #e8f5e9;
        }

        @media (max-width: 480px) {
            .container {
                margin: 1rem;
                padding: 1.5rem;
            }

            h1 {
                font-size: 20px;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Reset Password</h1>
        <p>Enter your email address and we'll send you instructions to reset your password.</p>

        <form action="/reset-password" method="POST">
            <div class="form-group">
                <input type="email" name="email" placeholder="Enter your email" required>
            </div>

            <button type="submit" class="btn btn-primary">Reset Password</button>
            <a href="/login" class="btn btn-secondary">Back to Login</a>
        </form>
    </div>
</body>

</html>