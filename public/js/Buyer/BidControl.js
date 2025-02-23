const bidsTable = document.querySelector("#bidsTable tbody");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const pageInfo = document.getElementById("pageInfo");

let currentPage = 1;
const rowsPerPage = 10;
let bids = []; // This will store all the fetched bids

// Fetch all bids from the controller
function fetchBids() {
  fetch(`${URLROOT}/BuyerController/getAllActiveBidsForBuyer/${USERID}`)
    .then((response) => response.json())
    .then((data) => {
      bids = data; // Store all bids in the array
      renderTable(); // Initial table render
      updatePagination();
    })
    .catch((error) => console.log("Error fetching bids:", error));
}

// Render table rows for bids based on current page
function renderTable() {
  const start = (currentPage - 1) * rowsPerPage;
  const end = start + rowsPerPage;
  const paginatedBids = bids.slice(start, end);

  bidsTable.innerHTML = ""; // Clear the existing table

  paginatedBids.forEach((bid) => {
    const row = document.createElement("tr");
    const targetDate = new Date(`${bid.closing_date}`); // Set the target date and time
 
    row.innerHTML = `
      <td data-label="Bid ID">${bid.bid_id}</td>
      <td data-label="Product">${bid.bid_amount}</td>
      <td data-label="Buyer">${bid.highest_bid}</td>
      <td data-label="Unit Price (Rs)">${startCountdown(targetDate)}</td>
      <td data-label="Quantity">${bid.quantity}</td>
      <td data-label="Status">${bid.payment_status}</td>
    `;
    bidsTable.appendChild(row);
  });
}

// Update pagination info (current page and total pages)
function updatePagination() {
  const totalPages = Math.ceil(bids.length / rowsPerPage);
  pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;

  prevBtn.disabled = currentPage === 1;
  nextBtn.disabled = currentPage === totalPages;
}

// Handle previous page button click
prevBtn.addEventListener("click", () => {
  if (currentPage > 1) {
    currentPage--;
    renderTable();
    updatePagination();
  }
});

// Handle next page button click
nextBtn.addEventListener("click", () => {
  const totalPages = Math.ceil(bids.length / rowsPerPage);
  if (currentPage < totalPages) {
    currentPage++;
    renderTable();
    updatePagination();
  }
});

// Initial fetch and render
fetchBids();

function calculateRemainingTime(targetDate) {
  const now = new Date();
  const timeDifference = targetDate - now;

  // If the target date is in the past, return "Time is up!"
  if (timeDifference <= 0) {
      return "Time is up!";
  }

  const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24)); // Days
  const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)); // Hours
  const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60)); // Minutes
  const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000); // Seconds

  return `${days}d ${hours}h ${minutes}m ${seconds}s`;
}

function startCountdown(targetDate) {
  const countdownElement = document.getElementById('countdown'); // Element to display the time

  // Update the countdown every second
  const interval = setInterval(() => {
      const remainingTime = calculateRemainingTime(targetDate);

      // Display the remaining time
      countdownElement.innerHTML = remainingTime;

      // Stop the countdown when time is up
      if (remainingTime === "Time is up!") {
          clearInterval(interval);
      }
  }, 1000); // Update every second
}

// Example usage:

