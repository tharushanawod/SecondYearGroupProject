

document.getElementById('myForm').addEventListener('submit', function (e) {
    e.preventDefault(); // Prevent the default form submission

    const formData = new FormData(this); // Collect form data

    fetch(`${URLROOT}/LandingController/OTP`, { // Send data to PHP backend
        method: 'POST',
        body: formData
    })
    .then(response => response.text()) // Convert response to text
    .then(data => {
        document.getElementById('response').innerHTML = data; // Show the response from the server
    })
    .catch(error => console.error('Error:', error)); // Handle error if any
    
});

console.log("OTP.js loaded"); // Log a message to the console