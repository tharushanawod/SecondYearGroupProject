<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bid Landing Page</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Manufacturer/bidProduct.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
    <style>
        @import url(../components/sidebar.css);
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-size: cover;
            background-position: center;
        }

        .content-wrapper {    
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 40px; 
            padding: 40px 20px;
            margin-left: 280px;
            min-height: 80vh;
        }

        .container-card {
            background: rgba(255, 255, 255, 0.95);
            padding: 50px;
            border-radius: 20px;
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;    
            width: 90%;
            box-shadow: 0 10px 30px rgba(96, 179, 117, 0.2);
            transition: transform 0.3s ease;
        }

        .container-card:hover {
            transform: translateY(-5px);
        }

        .container-card img {
            width: 450px; 
            height: 450px;
            object-fit: cover;
            border-radius: 15px;
        }

        .text h1 {
            color: #044424;
            text-shadow: 1px 1px 2px rgba(113, 167, 122, 0.3);
            font-size: 48px;
            margin-bottom: 25px;
            font-weight: 700;
            line-height: 1.2;
        }

        .text p {
            color: #2c584a; 
            font-size: 1.25em;
            margin-bottom: 35px;
            line-height: 1.6;
            font-weight: 300;
        }

        @keyframes jump {
            0% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
            100% { transform: translateY(0); }
        }

        .cta-button {
            background: linear-gradient(135deg, #0eb22c, #089622);
            color: white;
            padding: 16px 35px;
            border: none;
            border-radius: 30px;
            font-size: 18px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(14, 178, 44, 0.2);
            animation: jump 2s ease-in-out infinite;
        }

        .cta-button:hover {
            background: linear-gradient(135deg, #089622, #0eb22c);
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(14, 178, 44, 0.3);
            animation-play-state: paused;
        }

        .button-link {
            text-decoration: none;
        }

        .current-rates {
            padding: 40px;
            background: linear-gradient(135deg, #f7f9e9, #ffffff);
            margin-top: 30px;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.08);
            text-align: center;
            margin-left: 315px;
            width: 73%;
            margin-bottom: 40px;
        }

        .current-rates h2 {
            text-align: center;
            margin-bottom: 30px;
            font-size: 42px;
            color: #1a472c;
            font-weight: 600;
            position: relative;
            padding-bottom: 15px;
        }

        .current-rates h2:after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 3px;
            background: linear-gradient(90deg, #0eb22c, #089622);
            border-radius: 2px;
        }

        .rates-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 25px;
            padding: 20px;
        }

        .rate-card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            transition: all 0.3s ease;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
        }

        .rate-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.1);
        }

        .rate-card img {
            width: 180px;
            height: 180px;
            object-fit: contain;
            border-radius: 12px;
            margin-bottom: 15px;
            padding: 10px;
            background: #f8f9fa;
        }

        .rate-card h3 {
            margin: 15px 0;
            font-size: 1.3em;
            color: #1a472c;
            font-weight: 600;
        }

        .rate-card p {
            margin: 8px 0;
            font-size: 1.1em;
            color: #2c584a;
            font-weight: 400;
        }

        @media (max-width: 1200px) {
            .content-wrapper {
                margin-left: 250px;
            }
            .current-rates {
                margin-left: 285px;
                width: 80%;
            }
        }

        @media (max-width: 991px) {
            .container-card {
                flex-direction: column;
                padding: 30px;
            }
            .container-card img {
                width: 350px;
                height: 350px;
                margin-bottom: 30px;
            }
            .current-rates {
                margin-left: 250px;
                width: 85%;
            }
        }

        @media (max-width: 768px) {
            .content-wrapper {
                margin-left: 0;
                padding: 20px;
            }
            .current-rates {
                margin-left: 0;
                width: 95%;
                padding: 20px;
            }
            .text h1 {
                font-size: 36px;
            }
        }
    </style>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>

    <div class="content-wrapper">        
        <div class="container-card">
            <img src="<?php echo URLROOT;?>/images/images/img39.png" alt="Product Image" class="large-image">
            <div class="text">
            <h1>Bid on Premium Corn Products!</h1>
            <p>Fresh from the farm</p>
            <a href="<?php echo URLROOT;?>/ManufacturerController/bidProduct" class="button-link">
                <button class="cta-button">START BIDDING →</button>
            </a>
            </div>
        </div>
    </div>   
    <div class="current-rates">
        <h2>Current Rates</h2>
        <div class="rates-grid">
            <?php if (empty($data['prices'])): ?>
                <p class="no-rates">No manufacturer prices available</p>
            <?php else: ?>
                <?php foreach ($data['prices'] as $price): ?>
                    <div class="rate-card">
                        <img src="<?php echo URLROOT . '/' . htmlspecialchars($price->profile_image ?: 'images/default_company.png'); ?>" alt="<?php echo htmlspecialchars($price->company_name ?: 'Unknown Manufacturer'); ?> Logo">
                        <h3><?php echo htmlspecialchars($price->company_name ?: 'Unknown Manufacturer'); ?></h3>
                        <p>Product: Dry Corn</p>
                        <p>Rate: LKR <?php echo number_format($price->unit_price, 2); ?> (1Kg)</p>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>    
</body>
</html>