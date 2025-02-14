function openPricesPopup() {
    document.getElementById("pricesPopupMessage").style.display = "block";
    document.body.classList.add("blurred-background"); // Add the blur effect to the body
}

// Function to close the popup
function closePricesPopup() {
    document.getElementById("pricesPopupMessage").style.display = "none";
    document.body.classList.remove("blurred-background"); // Remove the blur effect from the body
}


function openPopup(productId) {



const popup = document.getElementById('popup-overlay');
const form = document.getElementById('create-product-form');

// Show the popup
popup.style.opacity = '1';
popup.style.visibility = 'visible';

if (productId) {
// Set the form action for the update (UpdateProducts)
form.action = `${URLROOT}/FarmerController/UpdateProducts/${productId}`;
const updatebutton=document.querySelector('.btn-primary');
updatebutton.textContent='Update';

// Prepopulate the form with the current product data
// You can do an AJAX request here to fetch product details if needed
// For now, let's assume product details are passed to the popup.
// Example:
fetchProductData(productId);  // Function to fetch and fill the form (you'll need to implement it)
} else {
    const updatebutton=document.querySelector('.btn-primary');
    updatebutton.textContent='Add Your Product';
// Set the form action for the create (AddProduct)
form.action = `${URLROOT}/FarmerController/AddProduct`;

 // Clear all form fields
 form.reset();

  // Hide the media preview
  const mediaPreview = document.getElementById('media-preview');
        mediaPreview.style.display = 'none';
}


}


function fetchProductData(productId) {
fetch(`${URLROOT}/FarmerController/getProductDetails/${productId}`)
.then(response => response.json())
.then(data => {
   
    document.getElementById('price').value = data.starting_price;
    document.getElementById('quantity').value = data.quantity;
    document.getElementById('closing_date').value = data.closing_date;

    // Update image preview
    const mediaPreview = document.getElementById('media-preview');
    if (data.media) {
        mediaPreview.src = `${URLROOT}/${data.media}`;
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
const input = document.getElementById("closing_date");

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


// Get today's date
const today = new Date();
const futureDate = new Date();
futureDate.setDate(today.getDate() + 7); // Set max to 7 days from today

// Format date to YYYY-MM-DDTHH:MM
const formatDateTime = (date) => {
    const pad = (num) => num.toString().padStart(2, '0'); // Add leading zero if needed

    return `${date.getFullYear()}-${pad(date.getMonth() + 1)}-${pad(date.getDate())}T${pad(date.getHours())}:${pad(date.getMinutes())}`;
};

input.min = formatDateTime(today);
input.max = formatDateTime(futureDate);
});

