<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Home</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referrerpolicy="no-referrer" />
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/HomePagestyles.css?v=<?php echo time(); ?>" />
 
<style>
  /* Animate child elements */
  section > * {
      opacity: 0;
      transform: translateX(-50%);
      transition: all 1s ease-in-out;
    }

    /* Active class to trigger animation */
    section.scroll > * {
      opacity: 1;
      transform: translateX(0);
    }
</style>

</head>

<body>
<?php require APPROOT . '/views/inc/components/Header.php'; ?>
  <section class="home animate">
    <div class="home-content">
      <h1>Corn  Cradle</h1>
      <h2>Empowering Sri Lankan corn farmers to trade and thrive</h2>
      <a href="#"><button class="stylish-button">Get Started</button></a>
    </div>
  </section>

  <section class="About-us animate">
    <div class="About-us-content">
      <h2>About US</h2>
      <p>
        We are dedicated to connecting Sri Lankan corn farmers with buyers,
        ensuring fair prices, high-quality produce, and streamlined services
        for selling, hiring, and purchasing essentials
      </p>
    </div>
    <div class="user-details">
      <button class="verified-user-button">Our Verified Users</button>
      <div class="user-icons">
        <div class="user">
          <img src="<?php echo URLROOT; ?>/images/farmer.png" alt="farmer" />
          <h2>Farmers</h2>
          <button>456+</button>
        </div>

        <div class="user">
          <img src="<?php echo URLROOT; ?>/images/buyer.png" alt="farmer" />
          <h2>Buyers</h2>
          <button>456+</button>
        </div>

        <div class="user">
          <img src="<?php echo URLROOT; ?>/images/worker.png" alt="farmer" />
          <h2>Workers</h2>
          <button>456+</button>
        </div>
      </div>
    </div>
  </section>

  <!-- third section our services -->

  <section class="our-services animate">
    <div class="our-services-content">
      <div class="services-button">
        <button>Our Features & Services</button>
      </div>
      <div class="service-boxes">
        <div class="service">
          <img src="<?php echo URLROOT; ?>/images/service1.png" alt="service1" />
          <h2>All In One</h2>
          <p>Buy ingredients,Buy products,Hire Workers.</p>
          <a href="#"><button>More</button></a>
        </div>

        <div class="service">
          <img src="<?php echo URLROOT; ?>/images/service2.png" alt="service2" />
          <h2>Bidding System</h2>
          <p>Buyers are allowed to bid for the products.</p>
          <a href="#"><button>More</button></a>
        </div>

        <div class="service">
          <img src="<?php echo URLROOT; ?>/images/service3.png" alt="service3" />
          <h2>Fair Pricing</h2>
          <p>
            Through bidding system both farmers and buyers get fair prices.
          </p>
          <a href="#"><button>More</button></a>
        </div>
      </div>
    </div>
  </section>

  <!-- feedback section -->

  <section class="feedback animate">
    <div class="feedback-heading">
      <h1>What They Say About Us</h1>
    </div>

    <div class="carousel-container">
      <div class="carousel">
        <div class="card">
          <div class="quote-icon">
            <img src="<?php echo URLROOT; ?>/images/quotation-mark.png" alt="quote icon" />
          </div>
          <p class="testimonial-text">
            Corn Cradle has transformed the way I sell my corn. The bidding
            system helped me get a much better price than I expected. I feel
            empowered and connected with buyers who truly value my produce!
          </p>
          <div class="profile">
            <img class="profile-img" src="<?php echo URLROOT; ?>/images/card-pic-2.jpg" alt="Juliana Silva" />
            <div class="profile-info">
              <h4>Ravi S</h4>
              <p>Anuradhapura</p>
            </div>
          </div>
        </div>

        <div class="card">
          <div class="quote-icon">
            <img src="<?php echo URLROOT; ?>/images/quotation-mark.png" alt="quote icon" />
          </div>
          <p class="testimonial-text">
            I love using Corn Cradle! It's so easy to navigate, and I
            appreciate being able to bid on fresh corn directly from farmers.
            The quality of the corn has always been excellent, and I feel good
            supporting local farmers
          </p>
          <div class="profile">
            <img class="profile-img" src="<?php echo URLROOT; ?>/images/card-pic-1.jpg" alt="Juliana Silva" />
            <div class="profile-info">
              <h4>Nimali P</h4>
              <p>Polonnaruwa</p>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="quote-icon">
            <img src="<?php echo URLROOT; ?>/images/quotation-mark.png" alt="quote icon" />
          </div>
          <p class="testimonial-text">
            I was hesitant at first, but Corn Cradle has made selling my corn
            a breeze. The platform is user-friendly, and the support team is
            always there to help. I'm grateful for this opportunity!
          </p>
          <div class="profile">
            <img class="profile-img" src="<?php echo URLROOT; ?>/images/card-pic-3.jpg" alt="Juliana Silva" />
            <div class="profile-info">
              <h4>Sanjeewa T.</h4>
              <p>Kandy</p>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="quote-icon">
            <img src="<?php echo URLROOT; ?>/images/quotation-mark.png" alt="quote icon" />
          </div>
          <p class="testimonial-text">
            Corn Cradle has changed my grocery shopping experience. I can find
            the freshest corn at competitive prices, and I love knowing I'm
            buying directly from farmers. Highly recommend it to everyone!
          </p>
          <div class="profile">
            <img class="profile-img" src="<?php echo URLROOT; ?>/images/card-pic-4.jpg" alt="Juliana Silva" />
            <div class="profile-info">
              <h4>Lakshmi R.</h4>
              <p>Mathale</p>
            </div>
          </div>
        </div>
        <div class="card">
          <div class="quote-icon">
            <img src="<?php echo URLROOT; ?>/images/quotation-mark.png" alt="quote icon" />
          </div>
          <p class="testimonial-text">
            I never thought selling corn could be so straightforward. Corn
            Cradle's bidding system is transparent and fair. I've built great
            relationships with my buyers, and it's all thanks to this
            fantastic platform!
          </p>
          <div class="profile">
            <img class="profile-img" src="<?php echo URLROOT; ?>/images/card-pic-5.jpg" alt="Juliana Silva" />
            <div class="profile-info">
              <h4>Shayan s.</h4>
              <p>Jaffna</p>
            </div>
          </div>
        </div>
      </div>
    </div>
    <button class="prev">←</button>
    <button class="next">→</button>
  </section>

  <!-- Frequently asked questions part -->

  <section class="faqpart animate">
    <div class="faq-container">
      <h1>Frequently Asked Questions</h1>
      <div class="heading-underline"></div>
      <div class="wrapper">
        <div class="faq">
          <button class="question">
            What is Corn Cradle?
            <i class="fa-solid fa-chevron-down icon"></i>
          </button>
          <div class="pannel">
            <p>
              Corn Cradle is an online platform designed to connect Sri Lankan
              corn farmers with buyers. Through our bidding system, farmers can
              sell their corn harvest directly to buyers, ensuring fair prices
              and promoting sustainable agriculture.
            </p>
          </div>
        </div>
        <div class="faq">
          <button class="question">
            How does the bidding system work?
            <i class="fa-solid fa-chevron-down icon"></i>
          </button>
          <div class="pannel">
            <p>
              Buyers place bids on corn products listed by farmers. The highest
              bid at the end of the bidding period wins the product.
            </p>
          </div>
        </div>
        <div class="faq">
          <button class="question">
            What types of corn can I sell on Corn Cradle?
            <i class="fa-solid fa-chevron-down icon"></i>
          </button>
          <div class="pannel">
            <p>
              Farmers can sell various types of corn, including sweet corn,
              field corn, and organic corn, depending on what they grow.
            </p>
          </div>
        </div>
        <div class="faq">
          <button class="question">
            How do I register as a farmer or buyer?
            <i class="fa-solid fa-chevron-down icon"></i>
          </button>
          <div class="pannel">
            <p>
              To register, simply click on the "Sign Up" button on the homepage
              and fill out the required information. Farmers need to provide
              details about their farm, while buyers just need to create an
              account.
            </p>
          </div>
        </div>
        <div class="faq">
          <button class="question">
            Are there any fees to use Corn Cradle?
            <i class="fa-solid fa-chevron-down icon"></i>
          </button>
          <div class="pannel">
            <p>
              Currently, there are no fees for farmers to list their corn.
              Buyers may incur a small transaction fee when their bid is
              accepted.
            </p>
          </div>
        </div>
      </div>
    </div>
  </section>

  <style>
    /* FAQ Section Styling */
    .faqpart {
      background-color: white;
      padding: 100px 0;
      position: relative;
      overflow: hidden;
    }
    
    .faqpart::before {
      content: '';
      position: absolute;
      width: 200px;
      height: 200px;
      border-radius: 50%;
      background: rgba(100, 170, 30, 0.05);
      top: -100px;
      left: -100px;
    }
    
    .faqpart::after {
      content: '';
      position: absolute;
      width: 250px;
      height: 250px;
      border-radius: 50%;
      background: rgba(254, 183, 0, 0.05);
      bottom: -125px;
      right: -125px;
    }
    
    .faq-container {
      max-width: 900px;
      margin: 0 auto;
      padding: 0 20px;
      position: relative;
      z-index: 2;
    }
    
    .faqpart h1 {
      text-align: center;
      font-size: 2.5rem;
      font-weight: 700;
      color: var(--text-dark);
      margin-bottom: 15px;
    }
    
    .faqpart .heading-underline {
      width: 80px;
      height: 4px;
      background: var(--primary-color);
      margin: 0 auto 50px;
      position: relative;
    }
    
    .faqpart .heading-underline::before {
      content: '';
      position: absolute;
      top: 0;
      left: 0;
      width: 30%;
      height: 100%;
      background: var(--secondary-color);
    }
    
    .wrapper {
      display: flex;
      flex-direction: column;
      gap: 15px;
    }
    
    .faq {
      background: white;
      border-radius: 15px;
      overflow: hidden;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.05);
      transition: all 0.3s ease;
      border-left: 5px solid var(--primary-color);
    }
    
    .faq:hover {
      box-shadow: 0 10px 25px rgba(0, 0, 0, 0.1);
      transform: translateY(-3px);
    }
    
    .question {
      display: flex;
      justify-content: space-between;
      align-items: center;
      width: 100%;
      padding: 20px 30px;
      font-size: 1.1rem;
      font-weight: 600;
      color: var(--text-dark);
      background: none;
      border: none;
      text-align: left;
      cursor: pointer;
      transition: all 0.3s ease;
    }
    
    .question:hover {
      color: var(--primary-color);
    }
    
    .icon {
      font-size: 1rem;
      color: var(--text-dark);
      transition: all 0.3s ease;
    }
    
    .active .icon {
      transform: rotate(180deg);
      color: var(--primary-color);
    }
    
    .active .question {
      color: var(--primary-color);
    }
    
    .pannel {
      max-height: 0;
      overflow: hidden;
      transition: max-height 0.5s ease;
    }
    
    .pannel p {
      padding: 0 30px 20px;
      font-size: 1rem;
      line-height: 1.7;
      color: var(--text-gray);
    }
    
    .faq.active {
      border-left: 5px solid var(--secondary-color);
    }
    
    .faq.active .question {
      border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }
    
    @media (max-width: 768px) {
      .faqpart {
        padding: 60px 0;
      }
      
      .faqpart h1 {
        font-size: 2rem;
      }
      
      .question {
        font-size: 1rem;
        padding: 15px 20px;
      }
      
      .pannel p {
        padding: 0 20px 15px;
      }
    }
  </style>

  <?php require APPROOT . '/views/inc/components/Footer.php'; ?>

  <!-- Enhanced JavaScript -->
  <script>
    // Intersection Observer for animations
    const sections = document.querySelectorAll('.animate');
    
    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('scroll');
        } else {
          // Keep animations when scrolling away on mobile
          if (window.innerWidth > 768) {
            entry.target.classList.remove('scroll');
          }
        }
      });
    }, {
      threshold: 0.2 // Trigger when 20% of the section is visible
    });
    
    // Observe each section
    sections.forEach(section => {
      observer.observe(section);
    });
    
    // Counter Animation
    const counters = document.querySelectorAll('.counter');
    
    counters.forEach(counter => {
      const target = parseInt(counter.getAttribute('data-target'));
      const duration = 2000; // 2 seconds
      const step = Math.ceil(target / (duration / 30)); // Update every 30ms
      let current = 0;
      
      function updateCount() {
        current += step;
        if (current >= target) {
          current = target;
          clearInterval(timer);
        }
        counter.innerText = current + '+';
      }
      
      // Only start counter when visible
      const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            const timer = setInterval(updateCount, 30);
            counterObserver.unobserve(entry.target);
          }
        });
      }, { threshold: 0.5 });
      
      counterObserver.observe(counter);
    });
  </script>

  <script src="<?php echo URLROOT; ?>/js/carousel.js"></script>
  <script src="<?php echo URLROOT; ?>/js/FAQ.js"></script>
</body>

</html>