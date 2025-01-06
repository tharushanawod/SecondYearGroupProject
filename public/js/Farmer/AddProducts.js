function openPricesPopup() {
    document.getElementById("pricesPopupMessage").style.display = "block";
    document.body.classList.add("blurred-background"); // Add the blur effect to the body
}

// Function to close the popup
function closePricesPopup() {
    document.getElementById("pricesPopupMessage").style.display = "none";
    document.body.classList.remove("blurred-background"); // Remove the blur effect from the body
}
//  document.addEventListener('DOMContentLoaded', function () {
// <?php if (!empty($data['show_popup']) && $data['show_popup'] === true): ?>
//     openPopup(); // Call your JavaScript function to show the popup
// <?php endif; ?>
// });

// document.getElementsByClassName('')

function openPopup(productId) {
const popup = document.getElementById('popup-overlay');
const form = document.getElementById('create-product-form');

if (productId) {
// Set the form action for the update (UpdateProducts)
form.action = `<?php echo URLROOT; ?>/FarmerController/UpdateProducts/${productId}`;

// Prepopulate the form with the current product data
// You can do an AJAX request here to fetch product details if needed
// For now, let's assume product details are passed to the popup.
// Example:
fetchProductData(productId);  // Function to fetch and fill the form (you'll need to implement it)
} else {
// Set the form action for the create (AddProduct)
form.action = `<?php echo URLROOT; ?>/FarmerController/AddProduct`;
}

// Show the popup
popup.style.opacity = '1';
popup.style.visibility = 'visible';
}
function fetchProductData(productId) {
fetch(`<?php echo URLROOT; ?>/FarmerController/getProductDetails/${productId}`)
.then(response => response.json())
.then(data => {
    document.getElementById('product-type').value = data.type;
    document.getElementById('price').value = data.price;
    document.getElementById('quantity').value = data.quantity;
    document.getElementById('expiry-period').value = data.expiry_period;

    // Update image preview
    const mediaPreview = document.getElementById('media-preview');
    if (data.media) {
        mediaPreview.src = `<?php echo URLROOT; ?>/${data.media}`;
        mediaPreview.style.display = 'block';
    } else {
        mediaPreview.style.display = 'none';
    }
})
.catch(error => console.log('Error fetching product data:', error));
}



function closePopup() {
    const popup = document.getElementById('popup-overlay');
    popup.style.opacity = '0';
    popup.style.visibility = 'hidden';
}

document.addEventListener('DOMContentLoaded', function () {
const timers = document.querySelectorAll('.countdown-timer');
timers.forEach(timer => {
    const expiryDate = new Date(timer.getAttribute('data-expiry-date'));
    const countdownElement = timer.querySelector('span');

    function updateCountdown() {
        const now = new Date();
        const timeRemaining = expiryDate - now;

        if (timeRemaining > 0) {
            const days = Math.floor(timeRemaining / (1000 * 60 * 60 * 24));
            const hours = Math.floor((timeRemaining % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((timeRemaining % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((timeRemaining % (1000 * 60)) / 1000);

            countdownElement.textContent = 
                `${days}d ${hours}h ${minutes}m ${seconds}s`;
        } else {
            countdownElement.textContent = "Expired";
        }
    }

    // Update countdown every second
    setInterval(updateCountdown, 1000);
    updateCountdown(); // Initial call
});
});