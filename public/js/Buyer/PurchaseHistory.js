
const bidsTable = document.querySelector("#orderTable tbody");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const pageInfo = document.getElementById("pageInfo");

let currentPage = 1;
const rowsPerPage = 10;
let PendingPayments = []; // This will store all the fetched bids

// Fetch all bids from the controller
function fetchBids() {
  fetch(`${URLROOT}/BuyerController/getPurchaseHistory/${USERID}`)
    .then((response) => response.json())
    .then((data) => {
        PendingPayments = data; // Store all bids in the array
      renderTable(); // Initial table render
      updatePagination();
    })
    .catch((error) => console.log("Error fetching bids:", error));
}

// Render table rows for bids based on current page
function renderTable() {
  const start = (currentPage - 1) * rowsPerPage;
  const end = start + rowsPerPage;
  const paginatedPendingPayments = PendingPayments.slice(start, end);

  bidsTable.innerHTML = ""; // Clear the table

  paginatedPendingPayments.forEach((PendingPayment) => {
    const row = document.createElement("tr");
    const targetDate = new Date(PendingPayment.order_closing_date);
    const totalpayment = PendingPayment.bid_price * PendingPayment.quantity;
    const advancepayment = totalpayment * 0.3;

    row.innerHTML = `
      <td data-label="Order ID">${PendingPayment.order_id}</td>
      <td data-label="Product">${PendingPayment.bid_price}</td>
      <td data-label="Quantity">${PendingPayment.quantity} kg</td>
      <td data-label="Remaining Time" id="countdown-${PendingPayment.order_id}">Calculating...</td>
      <td data-label="Total">${totalpayment.toFixed(2)}</td>
      <td data-label="Advance">${advancepayment.toFixed(2)}</td>
      <td data-label="Action">
        <button onclick="Payment(${PendingPayment.order_id})" class="action-btn confirm">Pays</button>
      </td>
    `;
    bidsTable.appendChild(row);

    startCountdown(targetDate, `countdown-${PendingPayment.order_id}`);
  });
}

function calculateRemainingTime(targetDate) {
  const now = new Date();
  const timeDifference = targetDate - now;

  if (timeDifference <= 0) return "Time is up!";

  const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24));
  const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
  const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60));
  const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000);

  return `${days}d ${hours}h ${minutes}m ${seconds}s`;
}

function startCountdown(targetDate, elementId) {
  function updateCountdown() {
    const countdownElement = document.getElementById(elementId);
    if (!countdownElement) return;

    const remainingTime = calculateRemainingTime(targetDate);
    countdownElement.innerHTML = remainingTime;

    if (remainingTime === "Time is up!") clearInterval(interval);
  }

  updateCountdown();
  const interval = setInterval(updateCountdown, 1000);
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

function Payment(order_id){
  window.location.href = `${URLROOT}/BuyerController/getPaymentDetailsForOrder/${order_id}`;
}