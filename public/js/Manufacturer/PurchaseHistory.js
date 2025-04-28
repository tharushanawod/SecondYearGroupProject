const PaymentsTable = document.querySelector("#orderTable tbody");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const pageInfo = document.getElementById("pageInfo");

let currentPage = 1;
const rowsPerPage = 10;
let PendingPayments = []; // Store all payments here

// Fetch all payment history from the controller
function fetchpayments() {
  fetch(`${URLROOT}/ManufacturerController/getPurchaseHistory/${USERID}`)
    .then((response) => response.json())
    .then((data) => {
      PendingPayments = data; // Corrected
      renderTable();
      updatePagination();
    })
    .catch((error) => console.log("Error fetching payment history:", error));
}

// Render table rows
function renderTable() {
  const start = (currentPage - 1) * rowsPerPage;
  const end = start + rowsPerPage;
  const paginatedPayments = PendingPayments.slice(start, end);

  PaymentsTable.innerHTML = "";

  paginatedPayments.forEach((payment) => {
    const totalAmount = payment.bid_price * payment.quantity;
    const paidAmount = totalAmount * 0.2;

    const row = document.createElement("tr");
    row.innerHTML = `
      <td data-label="Transaction ID">${payment.transaction_id}</td>
      <td data-label="Quantity">${payment.quantity} kg</td>
      <td data-label="Paid Amount">Rs. ${paidAmount.toFixed(2)}</td>
      <td data-label="Total Amount">Rs. ${totalAmount.toFixed(2)}</td>
      <td data-label="Farmer's Details">
        <button onclick="viewFarmerDetails(${payment.farmer_id})" class="details-btn">
          View Details
        </button>
      </td>
      <td data-label="Your Confirmation">${getBuyerConfirmationStatus(payment)}</td>
    `;
    PaymentsTable.appendChild(row);
  });
}

// Get buyer confirmation status
function getBuyerConfirmationStatus(payment) {
  if (payment.buyer_confirmed === 1) {
    return '<span class="confirmed"><i class="fa-solid fa-check"></i> Confirmed</span>';
  } else if (payment.buyer_confirmed === 0 && payment.refund_status === "yes") {
    return '<span class="confirmed" style="color:red;"><i class="fa-solid fa-check"></i> Refunded</span>';
  } else {
    return `<button onclick="confirmOrder(${payment.order_id})" class="confirm-btn">
      <i class="fa-solid fa-square-check"></i> Confirm
    </button>`;
  }
}

// Pagination update
function updatePagination() {
  const totalPages = Math.ceil(PendingPayments.length / rowsPerPage);
  pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;

  prevBtn.disabled = currentPage === 1;
  nextBtn.disabled = currentPage === totalPages || totalPages === 0;
}

// Previous button
prevBtn.addEventListener("click", () => {
  if (currentPage > 1) {
    currentPage--;
    renderTable();
    updatePagination();
  }
});

// Next button
nextBtn.addEventListener("click", () => {
  const totalPages = Math.ceil(PendingPayments.length / rowsPerPage);
  if (currentPage < totalPages) {
    currentPage++;
    renderTable();
    updatePagination();
  }
});

// Show confirmation modal
function showConfirmationModal(orderId) {
  const modal = document.getElementById("confirmationModal");
  const confirmBtn = document.getElementById("confirmOrderBtn");

  if (!modal || !confirmBtn) {
    console.error("Modal or confirm button not found!");
    return;
  }

  confirmBtn.dataset.orderId = orderId;
  modal.style.display = "block";
  document.body.style.overflow = "hidden";
}

// Close confirmation modal
function closeConfirmationModal() {
  const modal = document.getElementById("confirmationModal");
  if (modal) {
    modal.style.display = "none";
    document.body.style.overflow = "auto";
  }
}

// Confirm order
function confirmOrder(orderId) {
  showConfirmationModal(orderId);
}

// Attach event listener to confirm button
const confirmBtnElement = document.getElementById("confirmOrderBtn");
if (confirmBtnElement) {
  confirmBtnElement.addEventListener("click", function () {
    const orderId = this.dataset.orderId;
    fetch(`${URLROOT}/ManufacturerController/confirmOrder/${orderId}`, { method: "POST" })
      .then((response) => response.json())
      .then(() => {
        closeConfirmationModal();
        fetchpayments(); // Refresh after confirm
      })
      .catch((error) => {
        console.error("Error confirming payment:", error);
        closeConfirmationModal();
      });
  });
}

// Reject purchase
function rejectPurchase(orderId) {
  fetch(`${URLROOT}/ManufacturerController/rejectPurchase/${orderId}`, { method: "POST" })
    .then((response) => response.json())
    .then(() => fetchpayments())
    .catch((error) => console.error("Error rejecting payment:", error));
}

// View farmer details
function viewFarmerDetails(farmerId) {
  fetch(`${URLROOT}/ManufacturerController/getFarmerDetails/${farmerId}`)
    .then((response) => response.json())
    .then((data) => {
      const modal = document.getElementById("farmerModal");
      const content = document.getElementById("farmerDetailsContent");

      if (!modal || !content) {
        console.error("Farmer modal or content area not found!");
        return;
      }

      content.innerHTML = `
        <div class="farmer-detail">
          <div class="detail-icon"><i class="fas fa-user"></i></div>
          <div class="detail-content">
            <h4>Name</h4><p>${data.name}</p>
          </div>
        </div>
        <div class="farmer-detail">
          <div class="detail-icon"><i class="fas fa-phone"></i></div>
          <div class="detail-content">
            <h4>Contact Number</h4><p>${data.contact_number}</p>
          </div>
        </div>
        <div class="farmer-detail">
          <div class="detail-icon"><i class="fas fa-map-marker-alt"></i></div>
          <div class="detail-content">
            <h4>Pickup Location</h4><p>${data.pickup_location}</p>
          </div>
        </div>
      `;

      modal.style.display = "block";
      document.body.style.overflow = "hidden";
    })
    .catch((error) => console.error("Error fetching farmer details:", error));
}

// Close farmer modal
function closeFarmerModal() {
  const modal = document.getElementById("farmerModal");
  if (modal) {
    modal.style.display = "none";
    document.body.style.overflow = "auto";
  }
}

// Close modals if clicking outside
window.onclick = function (event) {
  const farmerModal = document.getElementById("farmerModal");
  const confirmationModal = document.getElementById("confirmationModal");

  if (event.target === farmerModal) closeFarmerModal();
  if (event.target === confirmationModal) closeConfirmationModal();
};

// Initial fetch
fetchpayments();
