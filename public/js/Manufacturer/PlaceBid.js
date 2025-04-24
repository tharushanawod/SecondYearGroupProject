// The PHP variables are now accessible because they were passed from the HTML
function updateCountdown() {
    var now = new Date().getTime();
    var remainingTime = closingDate - now;
  
    if (remainingTime > 0) {
      var days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
      var hours = Math.floor(
        (remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)
      );
      var minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
      var seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);
  
      document.getElementById("countdown").innerHTML =
        days +
        " days, " +
        hours +
        " hours, " +
        minutes +
        " minutes, " +
        seconds +
        " seconds";
    } else {
      document.getElementById("countdown").innerHTML = "Auction Closed";
      clearInterval(countdownInterval);
    }
  }
  
  // Update countdown every second
  var countdownInterval = setInterval(updateCountdown, 1000);
  updateCountdown(); // Run immediately
  
  function showAlert(message) {
    var alertDiv = document.getElementById("alert");
    alertDiv.innerHTML = message;
    alertDiv.style.display = "block";
    setTimeout(function () {
      alertDiv.style.display = "none";
    }, 4000);
  }
  
  function validateBid() {
    var bidAmount = document.getElementById("bid_amount").value;
  
    if (bidAmount < startingPrice || (highestBid && bidAmount <= highestBid)) {
      showAlert(
        "Your bid must be higher than the current highest bid and the starting price."
      );
      return false;
    }
    return true;
  }
  
  document.getElementById("bidForm").addEventListener("submit", function (event) {
    event.preventDefault(); // Prevent the default form submission
  
    if (!validateBid()) {
      return;
    }
  
    var formData = new FormData(this);
  
    fetch(this.action, {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          showAlert("Your bid has been submitted successfully!");
  
          setTimeout(function () {
            window.location.href = URLROOT + "/ManufacturerController/bidProduct"; // Redirect to the desired URL
          }, 3000); // 3000 milliseconds = 3 seconds
        } else {
          alert(
            "There was an error submitting your bid: " +
              (data.error || "Unknown error")
          );
        }
      })
      .catch((error) => {
        alert("There was an error submitting your bid: " + error.message);
      });
  });
  
  // Add this new function for real-time calculation
  document.getElementById("bid_amount").addEventListener("input", function () {
    const bidAmount = parseFloat(this.value) || 0;
    const totalPayment = bidAmount * quantity;
  
    const totalCalculationDiv = document.getElementById("totalCalculation");
  
    if (bidAmount > 0) {
      totalCalculationDiv.style.display = "block";
      totalCalculationDiv.innerHTML = `
              <strong>Payment Summary</strong><br>
              Bid Amount per kg: LKR ${bidAmount.toFixed(2)}<br>
              Quantity: ${quantity} kg<br>
              <strong>Total Payment: LKR ${totalPayment.toFixed(2)}</strong>
          `;
    } else {
      totalCalculationDiv.style.display = "none";
    }
  });
  