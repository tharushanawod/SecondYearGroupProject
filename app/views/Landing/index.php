<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>CornCradle - Sri Lanka's Premier Corn Trading Platform</title>  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css"
    integrity="sha512-Kc323vGBEqzTmouAECnVceyQqyqdsSiqLQISBL29aUW4U/M7pSPA/gEUZQqv1cwx4OnYxTxve5UMg5GT6L4JJg=="
    crossorigin="anonymous" referreferrerPolicy="no-referrer" />
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/ModernHeader.css?v=<?php echo time(); ?>" />
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/ModernFooter.css?v=<?php echo time(); ?>" />
  <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/NewLandingPage.css?v=<?php echo time(); ?>" />
</head>

<body>
  <div class="min-h-screen">
    <?php require APPROOT . '/views/inc/components/Header.php'; ?>
    
    <!-- Hero Section -->
    <div class="hero-section">
      <!-- Background Image -->
      <div class="hero-background"></div>

      <!-- Content Overlay -->
      <div class="hero-content">
        <div class="hero-container animate-fade-up">
          <!-- Main Heading -->
          <h1 class="hero-title">
            Welcome to <span class="text-yellow">CornCradle</span>
          </h1>

          <!-- Subheading -->
          <p class="hero-subtitle">
            Sri Lanka's Premier Corn Trading Platform
          </p>

          <!-- Description -->
          <div class="hero-description-box">
            <p class="hero-description">
              Connect farmers, buyers, suppliers, and manufacturers in one
              unified marketplace. Experience transparent auctions, real-time
              pricing, and secure transactions that revolutionize the corn
              industry in Sri Lanka.
            </p>

            <!-- Key Features -->
            <div class="hero-features">
              <div class="feature-item">
                <i class="fas fa-leaf text-green"></i>
                <span>Quality Assured</span>
              </div>
              <div class="feature-item">
                <i class="fas fa-chart-line text-blue"></i>
                <span>Live Market Prices</span>
              </div>
              <div class="feature-item">
                <i class="fas fa-handshake text-orange"></i>
                <span>Secure Trading</span>
              </div>
            </div>
          </div>

          <!-- Action Buttons -->
          <div class="hero-buttons">
            <button class="btn-primary animate-hover">
              Start Trading Now
            </button>
            <button class="btn-secondary animate-hover">
              Learn More
            </button>
          </div>

          <!-- Trust Indicators -->
          <div class="trust-indicators">
            <div class="trust-item">
              <div class="trust-number">1000+</div>
              <div class="trust-label">Registered Farmers</div>
            </div>
            <div class="trust-item">
              <div class="trust-number">500+</div>
              <div class="trust-label">Active Buyers</div>
            </div>
            <div class="trust-item">
              <div class="trust-number">Rs 5M+</div>
              <div class="trust-label">Monthly Trading Volume</div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Features Section -->
    <div class="features-section">
      <div class="container">
        <div class="features-header animate-fade-up">
          <h2 class="features-title">
            Why Choose <span class="text-green">CornCradle</span>?
          </h2>
          <p class="features-subtitle">
            Experience the future of corn trading with our comprehensive
            platform designed for the Sri Lankan agricultural market.
          </p>
        </div>

        <div class="features-grid animate-fade-up">
          <div class="feature-card animate-hover-lift">
            <div class="feature-icon">
              <i class="fas fa-leaf text-green-600"></i>
            </div>
            <h3 class="feature-card-title">Quality Assured</h3>
            <p class="feature-card-description">
              Premium corn quality verification and certification with expert inspection
            </p>
          </div>

          <div class="feature-card animate-hover-lift">
            <div class="feature-icon">
              <i class="fas fa-chart-line text-blue-600"></i>
            </div>
            <h3 class="feature-card-title">Real-time Pricing</h3>
            <p class="feature-card-description">
              Live market prices and comprehensive trend analysis for informed decisions
            </p>
          </div>

          <div class="feature-card animate-hover-lift">
            <div class="feature-icon">
              <i class="fas fa-users text-purple-600"></i>
            </div>
            <h3 class="feature-card-title">Local Network</h3>
            <p class="feature-card-description">
              Connect with verified farmers, buyers, and suppliers across Sri Lanka
            </p>
          </div>

          <div class="feature-card animate-hover-lift">
            <div class="feature-icon">
              <i class="fas fa-handshake text-orange-600"></i>
            </div>
            <h3 class="feature-card-title">Secure Trading</h3>
            <p class="feature-card-description">
              Safe and transparent auction process with guaranteed payment security
            </p>
          </div>        </div>
      </div>
    </div>

    <!-- User-Specific Features Section -->
    <div class="user-features-section">
      <div class="container">
        <div class="user-features-header animate-fade-up">
          <h2 class="user-features-title">
            Tailored Solutions for Every <span class="text-green">Stakeholder</span>
          </h2>
          <p class="user-features-subtitle">
            Discover how CornCradle empowers each member of the corn trading ecosystem with specialized tools and features
          </p>
        </div>

        <!-- User Types Tabs -->
        <div class="user-tabs animate-fade-up">
          <button class="user-tab active" onclick="showUserFeatures('farmers')">
            <i class="fas fa-seedling"></i>
            <span>Farmers</span>
          </button>
          <button class="user-tab" onclick="showUserFeatures('buyers')">
            <i class="fas fa-shopping-cart"></i>
            <span>Buyers</span>
          </button>
          <button class="user-tab" onclick="showUserFeatures('suppliers')">
            <i class="fas fa-truck"></i>
            <span>Ingredient Suppliers</span>
          </button>
          <button class="user-tab" onclick="showUserFeatures('workers')">
            <i class="fas fa-tools"></i>
            <span>Farm Workers</span>
          </button>
          <button class="user-tab" onclick="showUserFeatures('manufacturers')">
            <i class="fas fa-industry"></i>
            <span>Manufacturers</span>
          </button>
        </div>

        <!-- Features Content -->
        <div class="user-features-content">
          <!-- Farmers Features -->
          <div id="farmers-features" class="user-features-panel active animate-fade-up">
            <div class="features-grid-user">
              <div class="user-feature-card">
                <div class="user-feature-icon">
                  <i class="fas fa-gavel text-green-600"></i>
                </div>
                <h4 class="user-feature-title">Smart Auction System</h4>
                <p class="user-feature-desc">List your corn harvest and let buyers compete with transparent bidding for the best prices</p>
              </div>
              <div class="user-feature-card">
                <div class="user-feature-icon">
                  <i class="fas fa-chart-area text-blue-600"></i>
                </div>
                <h4 class="user-feature-title">Market Analytics</h4>
                <p class="user-feature-desc">Access real-time market trends, price forecasts, and demand analysis to optimize your sales</p>
              </div>
              <div class="user-feature-card">
                <div class="user-feature-icon">
                  <i class="fas fa-user-plus text-purple-600"></i>
                </div>
                <h4 class="user-feature-title">Farm Worker Hiring</h4>
                <p class="user-feature-desc">Hire skilled (watering,harvesting,planting) farm workers for your farming needs</p>
              </div>
              <div class="user-feature-card">
                <div class="user-feature-icon">
                  <i class="fa-solid fa-cart-shopping text-orange-600"></i>
                </div>
                <h4 class="user-feature-title">Farming Inputs Purchase</h4>
                <p class="user-feature-desc">Buy seeds, fertilizer, and other supplies directly from ingredient suppliers with fair pricing</p>
              </div>
            </div>
          </div>

          <!-- Buyers Features -->
          <div id="buyers-features" class="user-features-panel animate-fade-up">
            <div class="features-grid-user">
              <div class="user-feature-card">
                <div class="user-feature-icon">
                  <i class="fas fa-search text-green-600"></i>
                </div>
                <h4 class="user-feature-title">Advanced Search</h4>
                <p class="user-feature-desc">Find corn by quality grade, quantity, location, and price range with powerful filtering options</p>
              </div>
              <div class="user-feature-card">
                <div class="user-feature-icon">
                  <i class="fas fa-handshake text-blue-600"></i>
                </div>
                <h4 class="user-feature-title">Competitive Bidding</h4>
                <p class="user-feature-desc">Participate in transparent auctions and secure the best corn at competitive market prices</p>
              </div>
              <div class="user-feature-card">
                <div class="user-feature-icon">
                  <i class="fas fa-shield-alt text-purple-600"></i>
                </div>
                <h4 class="user-feature-title">Secure Transactions</h4>
                <p class="user-feature-desc">Protected payments and escrow services ensure safe and reliable trading experiences</p>
              </div>
              <div class="user-feature-card">
                <div class="user-feature-icon">
                  <i class="fas fa-truck-loading text-orange-600"></i>
                </div>
                <h4 class="user-feature-title">Manufacturer Contact</h4>
                <p class="user-feature-desc">Manufacturers will contact buyers to buy bulk products</p>
              </div>
            </div>
          </div>

          <!-- Suppliers Features -->
          <div id="suppliers-features" class="user-features-panel animate-fade-up">
            <div class="features-grid-user">
              <div class="user-feature-card">
                <div class="user-feature-icon">
                  <i class="fas fa-seedling text-green-600"></i>
                </div>
                <h4 class="user-feature-title">Ingredient Marketplace</h4>
                <p class="user-feature-desc">Supply fertilizers, seeds, pesticides, and farming equipment to registered farmers</p>
              </div>
              <div class="user-feature-card">
                <div class="user-feature-icon">
                  <i class="fas fa-calendar-alt text-blue-600"></i>
                </div>
                <h4 class="user-feature-title">Manage Inventory</h4>
                <p class="user-feature-desc">Update stock levels, prices, and product info easily.</p>
              </div>
              <div class="user-feature-card">
                <div class="user-feature-icon">
                  <i class="fas fa-credit-card text-purple-600"></i>
                </div>
                <h4 class="user-feature-title">Payment Options</h4>
                <p class="user-feature-desc">Offer onlinetransaction option to farmers with automated payment tracking</p>
              </div>
              <div class="user-feature-card">
                <div class="user-feature-icon">
                  <i class="fas fa-users text-orange-600"></i>
                </div>
                <h4 class="user-feature-title">Farmer Network</h4>
                <p class="user-feature-desc">Build relationships with verified farmers and create long-term supply partnerships</p>
              </div>
            </div>
          </div>

          <!-- Workers Features -->
          <div id="workers-features" class="user-features-panel animate-fade-up">
            <div class="features-grid-user">
              <div class="user-feature-card">
                <div class="user-feature-icon">
                  <i class="fas fa-briefcase text-green-600"></i>
                </div>
                <h4 class="user-feature-title">Job Marketplace</h4>
                <p class="user-feature-desc">Find seasonal and permanent farming jobs with competitive wages and fair working conditions</p>
              </div>
              <div class="user-feature-card">
                <div class="user-feature-icon">
                  <i class="fas fa-star text-blue-600"></i>
                </div>
                <h4 class="user-feature-title">Skill Verification</h4>
                <p class="user-feature-desc">Showcase your expertise in planting, harvesting, machinery operation, and other farm skills</p>
              </div>
              <div class="user-feature-card">
                <div class="user-feature-icon">
                  <i class="fas fa-money-bill-wave text-purple-600"></i>
                </div>
                <h4 class="user-feature-title">Fair Wages</h4>
                <p class="user-feature-desc">Transparent pricing and secure payment systems ensure you receive fair compensation</p>
              </div>
              <div class="user-feature-card">
                <div class="user-feature-icon">
                  <i class="fas fa-map-marker-alt text-orange-600"></i>
                </div>
                <h4 class="user-feature-title">Location-Based Jobs</h4>
                <p class="user-feature-desc">Find work opportunities near your location by registering with prefered area.</p>
              </div>
            </div>
          </div>

          <!-- Manufacturers Features -->
          <div id="manufacturers-features" class="user-features-panel animate-fade-up">
            <div class="features-grid-user">
              <div class="user-feature-card">
                <div class="user-feature-icon">
                  <i class="fas fa-industry text-green-600"></i>
                </div>
                <h4 class="user-feature-title">Bulk Procurement</h4>
                <p class="user-feature-desc">Source large quantities of corn directly from farmers at wholesale prices with volume discounts</p>
              </div>
              <div class="user-feature-card">
                <div class="user-feature-icon">
                  <i class="fas fa-clipboard-check text-blue-600"></i>
                </div>
                <h4 class="user-feature-title">Quality Assurance</h4>
                <p class="user-feature-desc">Access detailed quality reports, certifications, and lab test results for all corn batches</p>
              </div>
              <div class="user-feature-card">
                <div class="user-feature-icon">
                  <i class="fas fa-handshake text-blue-600"></i>
                </div>
                <h4 class="user-feature-title">Competitive Bidding</h4>
                <p class="user-feature-desc">Participate in transparent auctions and secure the best corn at competitive market prices with buyers</p>
              </div>
                <div class="user-feature-card">
                <div class="user-feature-icon">
                  <i class="fas fa-shield-alt text-purple-600"></i>
                </div>
                <h4 class="user-feature-title">Secure Transactions</h4>
                <p class="user-feature-desc">Protected payments and escrow services ensure safe and reliable trading experiences</p>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Stats Section -->
    <div class="stats-section">
      <div class="container">
        <div class="stats-grid animate-fade-up">
          <div class="stat-card">
            <h3 class="stat-number">10K+</h3>
            <p class="stat-label">Active Traders</p>
          </div>
          <div class="stat-card">
            <h3 class="stat-number">$50M+</h3>
            <p class="stat-label">Monthly Volume</p>
          </div>
          <div class="stat-card">
            <h3 class="stat-number">100+</h3>
            <p class="stat-label">Countries</p>
          </div>
        </div>
      </div>
    </div>

    <!-- CTA Section -->
    <div class="cta-section">
      <div class="container">
        <div class="cta-content animate-scale-up">
          <h2 class="cta-title">
            Ready to Transform Your Business?
          </h2>
          <p class="cta-subtitle">
            Join thousands of successful traders, farmers, and buyers who
            trust CornCradle for their corn trading needs across Sri Lanka.
          </p>

          <div class="cta-buttons">
            <button class="btn-cta-primary animate-hover">
              Register as Farmer
            </button>
            <button class="btn-cta-secondary animate-hover">
              Register as Buyer
            </button>
          </div>
        </div>
      </div>
    </div>

    <?php require APPROOT . '/views/inc/components/Footer.php'; ?>
  </div>
  <!-- JavaScript for animations and interactions -->
  <script src="<?php echo URLROOT; ?>/js/ModernHeader.js"></script>
  <script>
    // Intersection Observer for animations
    const observerOptions = {
      threshold: 0.2,
      rootMargin: '0px 0px -50px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          entry.target.classList.add('in-view');
        }
      });
    }, observerOptions);

    // Observe all animated elements
    document.querySelectorAll('.animate-fade-up, .animate-scale-up').forEach(el => {
      observer.observe(el);
    });

    // Counter animation for stats
    function animateCounters() {
      const counters = document.querySelectorAll('.stat-number');
      
      counters.forEach(counter => {
        const target = parseInt(counter.textContent.replace(/[^\d]/g, ''));
        const suffix = counter.textContent.replace(/[\d]/g, '');
        let current = 0;
        const increment = target / 100;
        const timer = setInterval(() => {
          current += increment;
          if (current >= target) {
            current = target;
            clearInterval(timer);
          }
          counter.textContent = Math.floor(current) + suffix;
        }, 20);
      });
    }

    // Trigger counter animation when stats section is visible
    const statsObserver = new IntersectionObserver((entries) => {
      entries.forEach(entry => {
        if (entry.isIntersecting) {
          animateCounters();
          statsObserver.unobserve(entry.target);
        }
      });
    }, { threshold: 0.5 });

    const statsSection = document.querySelector('.stats-section');
    if (statsSection) {
      statsObserver.observe(statsSection);
    }    // Add smooth scrolling for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
      anchor.addEventListener('click', function (e) {
        e.preventDefault();
        const target = document.querySelector(this.getAttribute('href'));
        if (target) {
          target.scrollIntoView({
            behavior: 'smooth',
            block: 'start'
          });
        }
      });
    });

    // User Features Tab Functionality
    function showUserFeatures(userType) {
      // Hide all panels
      document.querySelectorAll('.user-features-panel').forEach(panel => {
        panel.classList.remove('active');
      });
      
      // Remove active class from all tabs
      document.querySelectorAll('.user-tab').forEach(tab => {
        tab.classList.remove('active');
      });
      
      // Show selected panel
      const selectedPanel = document.getElementById(userType + '-features');
      if (selectedPanel) {
        selectedPanel.classList.add('active');
      }
      
      // Add active class to clicked tab
      event.target.closest('.user-tab').classList.add('active');
    }

    // Make showUserFeatures globally available
    window.showUserFeatures = showUserFeatures;
  </script>
</body>

</html>
