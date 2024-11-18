<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/Contact us.css">
</head>
<body>
    <div class="container">
        <div class="contact-form">
            <h1>Contact Us</h1>
            <p class="header-subtitle">We'd Love to Hear From You!</p>
            <form action="#" method="post">
                <div class="input-field">
                    <i class="fas fa-user"></i>
                    <input type="text" name="name" placeholder="Your Name" required>
                </div>
                <div class="input-field">
                    <i class="fas fa-envelope"></i>
                    <input type="email" name="email" placeholder="Your Email" required>
                </div>
                <div class="input-field">
                    <i class="fas fa-phone"></i>
                    <input type="text" name="phone" placeholder="Your Phone Number" required>
                </div>
                <div class="input-field">
                    <i class="fas fa-comment"></i>
                    <textarea name="message" placeholder="Your Message" required></textarea>
                </div>
                <button type="submit" class="btn">Send Message</button>
            </form>
        </div>
    </div>
</body>
</html>