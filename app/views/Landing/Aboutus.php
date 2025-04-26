<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Aboutus.css">
</head>
<body>
<?php require APPROOT . '/views/inc/components/Header.php'; ?>
<section class="hero">
<div class="image-grid">
<div class="image-item large">
    <div class="overlay">
        <h2>Empowering Sri Lankan corn farmers to trade and thrive</h2>
       
        <a href="<?php echo URLROOT;?>/LandingController/Login"><button class="cta-button">Join Now </button></a>
      </div>
      <img src="<?php echo URLROOT;?>/images/CornField.jpeg" alt="test Field">
    </div>
  <div class="image-item"><img src="<?php echo URLROOT;?>/images/Cornpot.jpg" alt="Corn"></div>
  <div class="image-item"><img src="<?php echo URLROOT;?>/images/Cornwithroad.jpeg" alt="Pathway"></div>
  <div class="image-item "><img src="<?php echo URLROOT;?>/images/aman.jpeg" alt="Person in Field"></div>
</div>
</section>
<section class="mission-section">

  <div class="mission-grid">
    <div class="mission-item">
      <h2>Our Mission</h2>
      <p>To empower Sri Lankan corn farmers by creating a sustainable, accessible, and fair marketplace that enhances their economic stability, supports rural development, and promotes ethical trade practices</p>
    </div>
    <div class="mission-item"><img src="<?php echo URLROOT;?>/images/plants.jpeg" alt=""></div>
    <div class="mission-item"><img src="<?php echo URLROOT;?>/images/ocean.jpeg" alt=""></div>
    <div class="mission-item">
    <h2>Our Vision</h2>
      <p>To provide Sri Lankan corn farmers with a user-friendly digital platform that connects them directly with buyers, allowing for fair pricing through a bidding system, access to resources and labor, and an opportunity to thrive in a competitive market.</p>
    </div>
    </div>
  </div>

</section>

<section class="new-section">
  <div class="main-text">
    <h1>Together, We Find A Way</h1>
    <p>Supporting Sustainable Growth: A Fair and Profitable Future for Sri Lankan Corn Farmers</p>
  </div>
  <div class="info-grid">
    <div class="info-item">
      <h3>Who we are</h3>
      <p>Empowering Farmers Nationwide: Enhancing Income and Opportunities for Rural Communities</p>
    </div>
    <div class="info-item">
      <h3>How to help</h3>
      <p>Support the Cause: Buy, Bid, or Sponsor for Farmer Success</p>
    </div>
    <div class="info-item">
      <h3>What we do</h3>
      <p>Transforming Agriculture: Providing Resources, Fair Pricing, and Market Access</p>
    </div>
    <div class="info-item">
      <h3>Where we work</h3>
      <p>Across Sri Lanka: Reaching Farmers in Rural Villages and Farming Communities</p>
    </div>
  </div>
</section>

<section class="stay-connected-section">
  <div class="form-container">
    <h2>Stay Connected</h2>
    <p>Join us and give your help in the efforts to protect our green forest today so the earth may keep breathing.</p>
    <form action="<?php echo URLROOT;?>/LandingController/SendEmail" method="POST">
      <input type="email" placeholder="Your email" name="email" required>
      <textarea name="message" placeholder="Your message" required></textarea>
      <button type="submit">Submit</button>
    </form>
  </div>
  
  <div class="images-container">
    <div class="image-box-1"><img src="<?php echo URLROOT;?>/images/left.jpg" alt="Corn image 1"></div>
    <div class="image-box-2"><img src="<?php echo URLROOT;?>/images/top.jpg" alt="Corn image 2"></div>
    <div class="image-box-3"><img src="<?php echo URLROOT;?>/images/bottom.jpg" alt="Corn image 3"></div>
  </div>
</section>

<?php require APPROOT . '/views/inc/components/Footer.php'; ?>
</body>
</html>

