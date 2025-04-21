// Function to open the prices popup
function openPricesPopup() {
  document.getElementById("pricesPopupMessage").style.display = "block";
  document.body.classList.add("blurred-background");
}

// Function to close the prices popup
function closePricesPopup() {
  document.getElementById("pricesPopupMessage").style.display = "none";
  document.body.classList.remove("blurred-background");
}

// Function to open the product form popup
function openPopup(productId) {
  const popup = document.getElementById("popup-overlay");
  const form = document.getElementById("create-product-form");

  // Show the popup
  popup.style.opacity = "1";
  popup.style.visibility = "visible";
  popup.style.display = "block";
  document.querySelector(".popup-content").style.transform = "scale(1)";

  if (productId) {
    // Update the form action for updating the product
    form.action = `${URLROOT}/FarmerController/UpdateProducts/${productId}`;
    const updateButton = document.querySelector(".btn-primary");
    updateButton.textContent = "Update";

    // Fetch and populate product data
    fetchProductData(productId);
  } else {
    // Update the form action for adding a new product
    form.action = `${URLROOT}/FarmerController/AddProduct`;
    const addButton = document.querySelector(".btn-primary");
    addButton.textContent = "Add Your Product";

    // Clear all form fields
    form.reset();

    // Hide the media preview
    const mediaPreview = document.getElementById("media-preview");
    mediaPreview.style.display = "none";
  }
}

// Function to fetch and populate product data
function fetchProductData(productId) {
  fetch(`${URLROOT}/FarmerController/getProductDetails/${productId}`)
    .then((response) => response.json())
    .then((data) => {
      document.getElementById("price").value = data.starting_price;
      document.getElementById("quantity").value = data.quantity;
      document.getElementById("closing_date").value = data.closing_date;

      // Update image preview
      const mediaPreview = document.getElementById("media-preview");
      if (data.media) {
        mediaPreview.src = `${URLROOT}/${data.media}`;
        mediaPreview.style.display = "block";
      } else {
        mediaPreview.style.display = "none";
      }
    })
    .catch((error) => console.log("Error fetching product data:", error));
}

// Function to close the product form popup
function closePopup() {
  const popup = document.getElementById("popup-overlay");
  document.querySelector(".popup-content").style.transform = "scale(0.9)";
  popup.style.opacity = "0";
  popup.style.visibility = "hidden";

  // Hide after animation completes
  setTimeout(() => {
    popup.style.display = "none";
  }, 300);
}

// Event listener for DOM content loaded
document.addEventListener("DOMContentLoaded", function () {
  // Countdown timer logic
  const timers = document.querySelectorAll(".countdown-timer");
  const input = document.getElementById("closing_date");

  timers.forEach((timer) => {
    const expiryDate = new Date(timer.getAttribute("data-expiry-date"));
    const countdownElement = timer.querySelector("span");

    function updateCountdown() {
      const now = new Date();
      const timeRemaining = expiryDate - now;

      if (timeRemaining > 0) {
        const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
        const hours = Math.floor(
          (timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
        );
        const minutes = Math.floor(
          (timeRemaining % (1000 * 60 * 60)) / (1000 * 60)
        );
        const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

        countdownElement.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
      } else {
        countdownElement.textContent = "Expired";
      }
    }

    // Update countdown every second
    setInterval(updateCountdown, 1000);
    updateCountdown(); // Initial call
  });

  // Set date range for the closing date input
  const today = new Date();
  const futureDate = new Date();
  futureDate.setDate(today.getDate() + 7); // Max 7 days from today

  // Format date to YYYY-MM-DDTHH:MM
  const formatDateTime = (date) => {
    const pad = (num) => num.toString().padStart(2, "0"); // Add leading zero if needed

    return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(
      date.getDate()
    )}T${pad(date.getHours())}:${pad(date.getMinutes())}`;
  };

  input.min = formatDateTime(today);
  input.max = formatDateTime(futureDate);

  // Setup filtering functionality
  const applyFilters = document.getElementById("applyFilters");
  const resetFilters = document.getElementById("resetFilters");
  const statusFilter = document.getElementById("statusFilter");
  const priceFilter = document.getElementById("priceFilter");
  const sortFilter = document.getElementById("sortFilter");

  // Apply filters
  applyFilters.addEventListener("click", function () {
    const products = document.querySelectorAll(".product-card");

    products.forEach((product) => {
      let showProduct = true;

      // Status filtering
      if (statusFilter.value !== "all") {
        if (product.dataset.status !== statusFilter.value) {
          showProduct = false;
        }
      }

      // Price filtering
      if (priceFilter.value !== "all" && showProduct) {
        const price = parseFloat(product.dataset.price);

        if (priceFilter.value === "low" && price >= 1000) {
          showProduct = false;
        } else if (
          priceFilter.value === "medium" &&
          (price < 1000 || price > 5000)
        ) {
          showProduct = false;
        } else if (priceFilter.value === "high" && price <= 5000) {
          showProduct = false;
        }
      }

      product.style.display = showProduct ? "block" : "none";
    });
  });

  // Reset filters
  resetFilters.addEventListener("click", function () {
    statusFilter.value = "all";
    priceFilter.value = "all";
    sortFilter.value = "default";

    const products = document.querySelectorAll(".product-card");
    products.forEach((product) => {
      product.style.display = "block";
    });
  });
});


