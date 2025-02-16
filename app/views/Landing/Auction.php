<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Corn Auction System - How It Works</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Auction.css">
    <style>
      @import url("./components/Header.css");
@import url("./components/Footer.css");
:root {
  --color-primary: #1f6246;
  --color-secondary: #f4d03f;
  --color-tertiary: #8b4513;
  --color-background: #fff;
  --color-text: #333;
}

* {
  margin: 0;
  padding: 0;
  box-sizing: border-box;
}

body {
  font-family: "Poppins", sans-serif;
  line-height: 1.6;
  color: var(--color-text);
}

/* Hero Section */
.hero {
  margin-top: 90px;
  height: 100vh;
  background: linear-gradient(rgba(0, 0, 0, 0.5), rgba(0, 0, 0, 0.5)),
    url("../images/explain.png");
  background-size: cover;
  background-position: center;
  display: flex;
  align-items: center;
  justify-content: center;
  text-align: center;
  color: white;
}

.hero-content h1 {
  font-size: 3.5rem;
  margin-bottom: 1rem;
}

/* Timeline Steps */
.steps {
  padding: 5rem 2rem;
  background-color: var(--color-background);
}

.timeline {
  max-width: 800px;
  margin: 0 auto;
  position: relative;
}

.step {
  display: flex;
  margin-bottom: 3rem;
  opacity: 0;
  transform: translateY(20px);
  transition: all 0.5s ease;
}

.step-number {
  width: 50px;
  height: 50px;
  background-color: var(--color-primary);
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.5rem;
  margin-right: 2rem;
}

/* Rules Section */
.rules {
  padding: 5rem 2rem;
  background-color: #f9f9f9;
}

.rules-container {
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
  gap: 2rem;
  max-width: 1200px;
  margin: 0 auto;
}

.rule-card {
  background: white;
  padding: 2rem;
  border-radius: 10px;
  box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
  transition: transform 0.3s ease;
}

.rule-card:hover {
  transform: translateY(-5px);
}

/* CTA Section */
.cta {
  text-align: center;
  padding: 5rem 2rem;
  background-color: var(--color-primary);
  color: white;
}

.btn {
  display: inline-block;
  padding: 1rem 2rem;
  border-radius: 5px;
  text-decoration: none;
  transition: all 0.3s ease;
  margin: 0.5rem;
  animation: bounce 2s infinite;
}

@keyframes bounce {
  0%, 20%, 50%, 80%, 100% {
    transform: translateY(0);
  }
  40% {
    transform: translateY(-10px);
  }
  60% {
    transform: translateY(-10px);
  }
}

/* Add hover effect to stop animation */
.btn:hover {
  animation: none;
  transform: translateY(-5px);
}

.btn-primary {
  background-color: var(--color-secondary);
  color: var(--color-text);
}

.btn-secondary {
  background-color: transparent;
  border: 2px solid white;
  color: white;
}

/* Responsive Design */
@media (max-width: 768px) {
  .hero-content h1 {
    font-size: 2.5rem;
  }

  .step {
    flex-direction: column;
    text-align: center;
  }

  .step-number {
    margin: 0 auto 1rem;
  }
}

    </style>
  
</head>

<body>
<?php require APPROOT . '/views/inc/components/Header.php'; ?>
    <!-- Hero Section -->
    <section class="hero">
        <div class="hero-content">
            <h1>How the System Works</h1>
            <p>Your trusted platform for online corn auctions</p>
            <a href="#how-it-works" class="scroll-down">
                <i class="fas fa-chevron-down"></i>
            </a>
        </div>
    </section>

   

    <!-- Step-by-Step Process Section -->
<section id="how-it-works" class="steps">
    <h2>Step-by-Step Process</h2>
    <div class="timeline">
        <div class="step" data-aos="fade-up">
            <div class="step-number">1</div>
            <div class="step-content">
                <h3>Listing</h3>
                <p>Farmers list their corn products with details like quantity, starting price, and auction duration.</p>
            </div>
        </div>

        <div class="step" data-aos="fade-up">
            <div class="step-number">2</div>
            <div class="step-content">
                <h3>Bidding Starts</h3>
                <p>Buyers place bids starting from the minimum price. Bids must increase by at least LKR 1.00.</p>
            </div>
        </div>

        <div class="step" data-aos="fade-up">
            <div class="step-number">3</div>
            <div class="step-content">
                <h3>Auction Ends</h3>
                <p>The highest bid at the end wins. If a bid is placed in the last 15 minutes, the auction extends by 5 minutes.</p>
            </div>
        </div>

        <div class="step" data-aos="fade-up">
            <div class="step-number">4</div>
            <div class="step-content">
                <h3>Payment</h3>
                <p>The winner must pay 30% of the total amount within 24 hours via bank transfer.</p>
            </div>
        </div>

        <div class="step" data-aos="fade-up">
            <div class="step-number">5</div>
            <div class="step-content">
                <h3>Delivery</h3>
                <p>Buyers are responsible for arranging pickup or paying for delivery.</p>
            </div>
        </div>
    </div>
</section>

<!-- Rules & Regulations Section -->
<section class="rules">
    <h2>Rules & Regulations</h2>
    <div class="rules-container">
        <div class="rule-card" data-aos="fade-up">
            <i class="fas fa-gavel"></i>
            <h3>Minimum Bid Increment</h3>
            <p>The minimum bid increment is LKR 1.00.</p>
        </div>

        <div class="rule-card" data-aos="fade-up">
            <i class="fas fa-clock"></i>
            <h3>Last-Minute Bidding</h3>
            <p>If a bid is placed within the last 15 minutes, the auction will be extended by 5 minutes to prevent last-second sniping.</p>
        </div>

        <div class="rule-card" data-aos="fade-up">
            <i class="fas fa-shipping-fast"></i>
            <h3>Shipping Costs</h3>
            <p>The winning bid does not include shipping costs.</p>
        </div>

        <div class="rule-card" data-aos="fade-up">
            <i class="fas fa-ban"></i>
            <h3>Payment Deadline</h3>
            <p>Failure to complete payment within 24 hours will result in account suspension, and the item will be relisted.</p>
        </div>
    </div>
</section>
<!-- CTA Section -->
<section class="cta">
    <h2>Ready to Get Started?</h2>
    <p>Join our corn auction platform today</p>
    <div class="cta-buttons">
        <a href="#" class="btn btn-primary">Start Bidding</a>
        <a href="#" class="btn btn-secondary">List Your Corn</a>
    </div>
</section>


<?php require APPROOT . '/views/inc/components/Footer.php'; ?>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script src="script.js"></script>

    <script>
        // Initialize AOS (Animate On Scroll)
AOS.init({
    duration: 800,
    once: true
});

// Smooth scroll functionality
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();
        document.querySelector(this.getAttribute('href')).scrollIntoView({
            behavior: 'smooth'
        });
    });
});

// Reveal elements on scroll
const revealElements = document.querySelectorAll('.step, .rule-card');
const revealOnScroll = () => {
    revealElements.forEach(element => {
        const elementTop = element.getBoundingClientRect().top;
        const windowHeight = window.innerHeight;
        
        if (elementTop < windowHeight - 100) {
            element.style.opacity = '1';
            element.style.transform = 'translateY(0)';
        }
    });
};

window.addEventListener('scroll', revealOnScroll);
window.addEventListener('load', revealOnScroll);
    </script>
</body>

</html>