<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Successful</title>
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background: #f5f7fa;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .success-container {
            background: white;
            padding: 40px;
            border-radius: 20px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            text-align: center;
            max-width: 500px;
            width: 90%;
            position: relative;
            overflow: hidden;
        }

        .success-icon {
            width: 100px;
            height: 100px;
            background: #2e8b57;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 30px;
            position: relative;
            animation: scaleIn 0.5s ease-out;
        }

        .success-icon::before {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            background: rgba(46, 139, 87, 0.2);
            border-radius: 50%;
            animation: pulse 2s infinite;
        }

        .success-icon i {
            color: white;
            font-size: 50px;
            animation: checkmark 0.5s ease-out;
        }

        .success-title {
            color: #2c3e50;
            font-size: 28px;
            margin-bottom: 15px;
            animation: fadeIn 0.5s ease-out 0.3s both;
        }

        .success-message {
            color: #64748b;
            font-size: 16px;
            line-height: 1.6;
            margin-bottom: 30px;
            animation: fadeIn 0.5s ease-out 0.5s both;
        }

        .payment-details {
            background: #f8fafc;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 30px;
            animation: slideUp 0.5s ease-out 0.7s both;
        }

        .detail-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
            color: #334155;
        }

        .detail-row:last-child {
            margin-bottom: 0;
            font-weight: 600;
            color: #2e8b57;
        }

        .action-buttons {
            display: flex;
            gap: 15px;
            justify-content: center;
            animation: fadeIn 0.5s ease-out 0.9s both;
        }

        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .btn-primary {
            background: #2e8b57;
            color: white;
            border: none;
        }

        .btn-primary:hover {
            background: #246c44;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(46, 139, 87, 0.2);
        }

        .btn-secondary {
            background: #f1f5f9;
            color: #334155;
            border: 1px solid #e2e8f0;
        }

        .btn-secondary:hover {
            background: #e2e8f0;
            transform: translateY(-2px);
        }

        @keyframes scaleIn {
            0% {
                transform: scale(0);
                opacity: 0;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes pulse {
            0% {
                transform: scale(1);
                opacity: 1;
            }
            50% {
                transform: scale(1.2);
                opacity: 0.5;
            }
            100% {
                transform: scale(1);
                opacity: 1;
            }
        }

        @keyframes checkmark {
            0% {
                transform: scale(0);
            }
            50% {
                transform: scale(1.2);
            }
            100% {
                transform: scale(1);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .confetti {
            position: absolute;
            width: 10px;
            height: 10px;
            background: #2e8b57;
            opacity: 0;
        }

        @media (max-width: 480px) {
            .success-container {
                padding: 30px 20px;
            }

            .success-icon {
                width: 80px;
                height: 80px;
            }

            .success-icon i {
                font-size: 40px;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>
<body>
    <div class="success-container">
        <div class="success-icon">
            <i class="fas fa-check"></i>
        </div>
        
        <h1 class="success-title">Payment Successful!</h1>
        <p class="success-message">Your payment has been processed successfully. A confirmation email has been sent to your registered email address.</p>
        
        <div class="payment-details">
            <div class="detail-row">
                <span>Order ID</span>
                <span>#<?php echo $data['order_id']; ?></span>
            </div>
            <div class="detail-row">
                <span>Amount Paid</span>
                <span>Rs. <?php echo $data['amount']; ?></span>
            </div>
            <div class="detail-row">
                <span>Date & Time</span>
                <span><?php echo date('M d, Y h:i A'); ?></span>
            </div>
        </div>

        <div class="action-buttons">
            <a href="<?php echo URLROOT; ?>/BuyerController/dashboard" class="btn btn-primary">
                <i class="fas fa-home"></i> Go to Dashboard
            </a>
            <a href="<?php echo URLROOT; ?>/BuyerController/purchaseHistory" class="btn btn-secondary">
                <i class="fas fa-shopping-bag"></i> View Orders
            </a>
        </div>
    </div>

    <script>
        // Add confetti effect
        function createConfetti() {
            const container = document.querySelector('.success-container');
            for (let i = 0; i < 50; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.left = Math.random() * 100 + '%';
                confetti.style.animation = `confetti-fall ${Math.random() * 3 + 2}s linear forwards`;
                container.appendChild(confetti);
            }
        }

        // Add confetti animation
        const style = document.createElement('style');
        style.textContent = `
            @keyframes confetti-fall {
                0% {
                    transform: translateY(-100px) rotate(0deg);
                    opacity: 1;
                }
                100% {
                    transform: translateY(1000px) rotate(360deg);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);

        // Trigger confetti after a short delay
        setTimeout(createConfetti, 500);
    </script>
</body>
</html>
