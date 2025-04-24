const bidsTable = document.querySelector("#bidsTable tbody");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const pageInfo = document.getElementById("pageInfo");

let currentPage = 1;
const rowsPerPage = 10;
let bids = []; // This will store all the fetched bids

// Popup elements
const popupOverlay = document.getElementById("popupOverlay");
const closePopup = document.getElementById("closePopup");
const confirmCancel = document.getElementById("confirmCancel");

let cancelBidId = null; // Store the bid ID to be canceled

// Fetch all bids from the controller
function fetchBids() {
  fetch(`${URLROOT}/ManufacturerController/getAllActiveBidsForBuyer/${USERID}`)
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
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

if (paginatedBids.length === 0) {
  const row = document.createElement("tr");
  row.innerHTML = `<td colspan="6" style="text-align: center;">No data to show</td>`;
  bidsTable.appendChild(row);
  return; // Stop the function
}

paginatedBids.forEach((bid) => {

  const countdownId = `countdown-${bid.order_id}`;
  const row = document.createElement("tr");
  row.innerHTML = `
    <td data-label="Bid ID">${bid.bid_id}</td>
    <td data-label="Your Bid">${bid.bid_amount}</td>
    <td data-label="Current Highest Bid">${bid.highest_bid}</td>
     <td data-label="Remaining Time"><span id="${countdownId}">Calculating...</span></td>
    <td data-label="Quantity (kg)">${bid.quantity}</td>
    <td data-label="Actions">
      ${bid.payment_status === 'Pending' ? `
        <button onclick="cancelBid(${bid.bid_id})" class="action-btn cancel">Cancel Bid</button>
        <button onclick="adjustBid(${bid.product_id})" class="action-btn confirm">Adjust Bid</button>
      ` : ''}
    </td>
  `;

  bidsTable.appendChild(row);
   // Start countdown
   startCountdown(bid.closing_date, countdownId);
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

// Show confirmation popup when cancel bid button is clicked
function cancelBid(bidId) {
  cancelBidId = bidId;
  popupOverlay.style.display = "flex"; // Show the popup
}

function adjustBid(product_id) {
  window.location.href = `${URLROOT}/ManufacturerController/PlaceBid/${product_id}`;
}

// Close the popup without canceling the bid
closePopup.addEventListener("click", () => {
  popupOverlay.style.display = "none"; // Hide the popup
});

// Confirm canceling the bid
confirmCancel.addEventListener("click", () => {
  fetch(`${URLROOT}/ManufacturerController/CancelBid/${cancelBidId}`)
    .then((response) => response.json())
    .then((data) => {
      console.log(data);
      fetchBids(); // Fetch bids again to update the table
    })
    .catch((error) => console.log("Error canceling bid:", error));
  popupOverlay.style.display = "none";
});



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
