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
});
