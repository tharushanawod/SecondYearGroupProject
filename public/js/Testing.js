const sendOtpBtn = document.getElementById("sendOtpBtn");
const verifyBtn = document.getElementById("verifyBtn");
const otpForm = document.getElementById("myForm");
const timerDisplay = document.getElementById("timer");
const otpInputs = document.querySelectorAll(".otp-input input");
const inputform = document.getElementById("inputform");
const verifyForm = document.getElementById("verifyForm");
let isFirstSend = true;
let timerInterval;



// Function to start the OTP timer
function startTimer(duration) {
  let timer = duration;
  sendOtpBtn.disabled = true;

  timerInterval = setInterval(() => {
    const minutes = Math.floor(timer / 60);
    const seconds = timer % 60;

    timerDisplay.textContent = `Resend OTP in ${minutes}:${seconds
      .toString()
      .padStart(2, "0")}`;

    if (--timer < 0) {
      clearInterval(timerInterval);
      timerDisplay.textContent = "";
      sendOtpBtn.disabled = false;
    }
  }, 1000);
}

otpForm.addEventListener("submit", function (e) {
  e.preventDefault(); // Prevent the default form submission

  const formData = new FormData(this); // Collect form data

  fetch(`${URLROOT}/LandingController/OTP`, {
    // Send data to PHP backend
    method: "POST",
    body: formData,
  })
    .then((response) => response.text()) // Convert response to text
    .then((data) => {
      document.getElementById("response").innerHTML = data; // Show the response from the server
    })
    .catch((error) => console.error("Error:", error)); // Handle error if any

    if (isFirstSend) {
      inputform.style.display = "block";
      verifyBtn.style.display = "block";
      sendOtpBtn.textContent = "Resend OTP";
      isFirstSend = false;
    }
  
    startTimer(30); // Set timer for 30 seconds cooldown
});

verifyForm.addEventListener("submit", function (e) {
  e.preventDefault(); // Prevent the default form submission

  const VerifyData = new FormData(verifyForm); // Collect form data

  fetch(`${URLROOT}/LandingController/VerifyOTP`, {
    method: "POST",
    body: VerifyData,
  })
    .then((response) => response.json()) // Expect JSON response
    .then((data) => {
      if (data.status === 'success') {
        document.getElementById("response").innerHTML = data.message;
        setTimeout(() => {
          window.location.href = data.redirect; // Redirect to the dashboard
        }, 2000); // Add slight delay for better UX
      } else {
        document.getElementById("response").innerHTML = data.message;
      }
    })
    .catch((error) => console.error("Error:", error));
});


