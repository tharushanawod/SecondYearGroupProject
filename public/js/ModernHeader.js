// Modern Header JavaScript functionality

function toggleMobileMenu() {
  const mobileNav = document.getElementById("mobileNav");
  const mobileMenuBtn = document.querySelector(".mobile-menu-btn");

  // Toggle the active class on mobile nav
  mobileNav.classList.toggle("active");

  // Toggle the active class on mobile menu button for animation
  mobileMenuBtn.classList.toggle("active");
}

// Close mobile menu when clicking outside
document.addEventListener("click", function (event) {
  const mobileNav = document.getElementById("mobileNav");
  const mobileMenuBtn = document.querySelector(".mobile-menu-btn");
  const header = document.querySelector(".modern-header");

  // Check if click is outside the header
  if (!header.contains(event.target)) {
    mobileNav.classList.remove("active");
    mobileMenuBtn.classList.remove("active");
  }
});

// Close mobile menu when window is resized to desktop
window.addEventListener("resize", function () {
  if (window.innerWidth >= 768) {
    const mobileNav = document.getElementById("mobileNav");
    const mobileMenuBtn = document.querySelector(".mobile-menu-btn");

    mobileNav.classList.remove("active");
    mobileMenuBtn.classList.remove("active");
  }
});

// Add active state to current page navigation link
document.addEventListener("DOMContentLoaded", function () {
  const currentPath = window.location.pathname;
  const navLinks = document.querySelectorAll(".nav-link, .mobile-nav-link");

  navLinks.forEach((link) => {
    if (
      link.getAttribute("href") &&
      currentPath.includes(link.getAttribute("href"))
    ) {
      link.style.color = "#059669";
      if (link.classList.contains("nav-link")) {
        link.style.fontWeight = "600";
      }
    }
  });
});
