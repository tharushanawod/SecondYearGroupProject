<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>404 Not Found</title>
    <style>
        /* General Styling */
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            color: #2c3e50;
        }

        .container {
            text-align: center;
            padding: 2rem;
            max-width: 600px;
        }

        h1 {
            font-size: 8rem;
            margin: 0;
            background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            line-height: 1;
            text-shadow: 2px 2px 10px rgba(0, 0, 0, 0.1);
        }

        p {
            font-size: 1.5rem;
            margin: 1rem 0 2rem;
            color: #666;
        }

        .back-button {
            display: inline-block;
            padding: 15px 30px;
            background: linear-gradient(135deg, #43cea2 0%, #185a9d 100%);
            color: white;
            text-decoration: none;
            border-radius: 30px;
            font-size: 1.1rem;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
        }

        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.3);
        }

        /* Animation */
        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .error-code {
            animation: float 4s ease-in-out infinite;
            margin-bottom: 2rem;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            h1 {
                font-size: 6rem;
            }

            p {
                font-size: 1.2rem;
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="error-code">
            <h1>404</h1>
        </div>
        <p>Oops! The page you're looking is not available.</p>
        <a href="<?php echo URLROOT;?>/LandingController/index" class="back-button">Return Home</a>
    </div>
</body>

</html>