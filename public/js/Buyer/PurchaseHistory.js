const PaymentsTable = document.querySelector("#orderTable tbody");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const pageInfo = document.getElementById("pageInfo");

let currentPage = 1;
const rowsPerPage = 10;
let PendingPayments = []; // This will store all the fetched payment history

// Fetch all payment history from the controller
function fetchpayments() {
  fetch(`${URLROOT}/BuyerController/getPurchaseHistory/${USERID}`)
    .then((response) => response.json())
    .then((data) => {
      Payments = data; // Store all payment history in the array
      renderTable(); // Initial table render
      updatePagination();
    })
    .catch((error) => console.log("Error fetching payment history:", error));
}

// Render table rows based on current page
function renderTable() {
  const start = (currentPage - 1) * rowsPerPage;
  const end = start + rowsPerPage;
  const paginatedPayments = Payments.slice(start, end);

  PaymentsTable.innerHTML = ""; // Clear the table

  paginatedPayments.forEach((payment) => {
    const row = document.createElement("tr");
    const totalAmount = payment.bid_price * payment.quantity;
    const paidAmount = totalAmount * 0.3; // Assuming paid amount is 30% as advance payment

    row.innerHTML = `
            <td data-label="Transaction ID">${payment.transaction_id}</td>
            <td data-label="Quantity">${payment.quantity} kg</td>
            <td data-label="Paid Amount">Rs. ${paidAmount.toFixed(2)}</td>
            <td data-label="Total Amount">Rs. ${totalAmount.toFixed(2)}</td>
            <td data-label="Farmer's Details">
                <button onclick="viewFarmerDetails(${
                  payment.farmer_id
                })" class="details-btn">
                    View Details
                </button>
            </td>
            <td data-label="Your Confirmation">${getBuyerConfirmationStatus(
              payment
            )}</td>
        `;
    PaymentsTable.appendChild(row);
  });
}

// Helper function to display farmer confirmation status
function getFarmerConfirmationStatus(payment) {
  // Replace with your actual data structure
  if (payment.farmer_confirmed === true) {
    return '<span class="confirmed"><i class="fa-solid fa-check"></i> Confirmed</span>';
  } else if (payment.farmer_confirmed === false) {
    return '<span class="rejected"><i class="fa-solid fa-xmark"></i> Rejected</span>';
  } else {
    return '<span class="pending"><i class="fa-solid fa-clock"></i> Pending</span>';
  }
}

// Helper function to display buyer confirmation status
function getBuyerConfirmationStatus(payment) {
  // Replace with your actual data structure
  if (payment.buyer_confirmed === 1) {
    return '<span class="confirmed"><i class="fa-solid fa-check"></i> Confirmed</span>';
  } else if( payment.buyer_confirmed === 0 && payment.refund_status === "yes") {
    return '<span class="confirmed" style="color:red;"><i class="fa-solid fa-check"></i> Refunded</span>';
  }
  else{
    return `<button onclick="confirmOrder(${payment.order_id})" class="confirm-btn"><i class="fa-solid fa-square-check"></i>  Confirm</button>`;
  }
}

// Update pagination info
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

// Function to confirm a payment
function confirmOrder(orderId) {
  fetch(`${URLROOT}/BuyerController/confirmOrder/${orderId}`, {
    method: "POST",
  })
    .then((response) => response.json())
    .then((data) => {
      fetchpayments(); // Refresh data after confirmation
    })
    .catch((error) => console.error("Error confirming payment:", error));
}

// Function to reject a payment
function rejectPurchase(orderId) {
  fetch(`${URLROOT}/BuyerController/rejectPurchase/${orderId}`, {
    method: "POST",
  })
    .then((response) => response.json())
    .then((data) => {
      fetchpayments(); // Refresh data after rejection
    })
    .catch((error) => console.error("Error rejecting payment:", error));
}

// Function to view farmer details
function viewFarmerDetails(farmerId) {
  fetch(`${URLROOT}/BuyerController/getFarmerDetails/${farmerId}`)
    .then((response) => response.json())
    .then((data) => {
      const modal = document.getElementById("farmerModal");
      const content = document.getElementById("farmerDetailsContent");

      content.innerHTML = `
                <div class="farmer-detail">
                    <div class="detail-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="detail-content">
                        <h4>Name</h4>
                        <p>${data.name}</p>
                    </div>
                </div>
                <div class="farmer-detail">
                    <div class="detail-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="detail-content">
                        <h4>Contact Number</h4>
                        <p>${data.contact_number}</p>
                    </div>
                </div>
                <div class="farmer-detail">
                    <div class="detail-icon">
                        <i class="fas fa-map-marker-alt"></i>
                    </div>
                    <div class="detail-content">
                        <h4>Pickup Location</h4>
                        <p>${data.pickup_location}</p>
                    </div>
                </div>
                <div class="location-map">
                    <!-- You can add a map here if you have the coordinates -->
                </div>
            `;

      modal.style.display = "block";
      document.body.style.overflow = "hidden"; // Prevent scrolling when modal is open
    })
    .catch((error) => console.error("Error fetching farmer details:", error));
}

function closeFarmerModal() {
  const modal = document.getElementById("farmerModal");
  modal.style.display = "none";
  document.body.style.overflow = "auto"; // Re-enable scrolling
}

// Close modal when clicking outside
window.onclick = function (event) {
  const modal = document.getElementById("farmerModal");
  if (event.target == modal) {
    closeFarmerModal();
  }
};

// Initial fetch and render
fetchpayments();
