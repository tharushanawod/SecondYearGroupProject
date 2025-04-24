const bidsTable = document.querySelector("#orderTable tbody");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const pageInfo = document.getElementById("pageInfo");

let currentPage = 1;
const rowsPerPage = 10;
let PendingPayments = []; // This will store all the fetched bids

// Fetch all bids from the controller
function fetchBids() {
  fetch(`${URLROOT}/ManufacturerController/getPendingPayments/${USERID}`)
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
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

  if (paginatedPendingPayments.length === 0) {
    const row = document.createElement("tr");
    row.innerHTML = `<td colspan="7" style="text-align:center;">No data to show</td>`;
    bidsTable.appendChild(row);
    return;
  }

  paginatedPendingPayments.forEach((PendingPayment) => {
    const totalpayment = PendingPayment.bid_price * PendingPayment.quantity;
    const advancepayment = totalpayment * 0.2;
    const countdownId = `countdown-${PendingPayment.order_id}`;

    const row = document.createElement("tr");
    row.innerHTML = `
      <td data-label="Order ID">${PendingPayment.order_id}</td>
      <td data-label="Product">${PendingPayment.bid_price}</td>
      <td data-label="Quantity">${PendingPayment.quantity} kg</td>
      <td data-label="Remaining Time"><span id="${countdownId}">Calculating...</span></td>
      <td data-label="Total">${totalpayment.toFixed(2)}</td>
      <td data-label="Advance">${advancepayment.toFixed(2)}</td>
      <td data-label="Action">
        <button onclick="Payment(${PendingPayment.order_id})" class="action-btn confirm">Pays</button>
      </td>
    `;
    bidsTable.appendChild(row);

    // Start countdown
    startCountdown(PendingPayment.order_closing_date, countdownId);
  });
}



// Update pagination info (current page and total pages)
function updatePagination() {
  const totalPages = Math.ceil(PendingPayments.length / rowsPerPage);
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
  const totalPages = Math.ceil(PendingPayments.length / rowsPerPage);
  if (currentPage < totalPages) {
    currentPage++;
    renderTable();
    updatePagination();
  }
});

// Initial fetch and render
fetchBids();


function Payment(order_id) {
  window.location.href = `${URLROOT}/ManufacturerController/getPaymentDetailsForOrder/${order_id}`;
}

function startCountdown(targetDateStr, elementId) {
  const targetDate = new Date(targetDateStr);

  function updateCountdown() {
    const now = new Date();
    const diff = targetDate - now;

    const element = document.getElementById(elementId);
    if (!element) return;

    if (diff <= 0) {
      element.textContent = "Expired";
      return;
    }

    const days = Math.floor(diff / (1000 * 60 * 60 * 24));
    const hours = Math.floor((diff / (1000 * 60 * 60)) % 24);
    const minutes = Math.floor((diff / (1000 * 60)) % 60);
    const seconds = Math.floor((diff / 1000) % 60);

    element.textContent = `${days}d ${hours}h ${minutes}m ${seconds}s`;
  }

  updateCountdown(); // Initial call
  setInterval(updateCountdown, 1000); // Update every second
}
