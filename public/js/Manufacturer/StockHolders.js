const PaymentsTable = document.querySelector("#orderTable tbody");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const pageInfo = document.getElementById("pageInfo");

let currentPage = 1;
const rowsPerPage = 10;
let PendingPayments = []; // This will store all the fetched payment history

// Fetch all payment history from the controller
function fetchpayments() {
  fetch(`${URLROOT}/ManufacturerController/getStockHolders`)
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
    console.log(payment);
    row.innerHTML = `
            <td data-label="USer ID">${payment.order_id}</td>
            <td data-label="Quantity">${payment.name} kg</td>
            <td data-label="Paid Amount"> ${payment.quantity} Kg</td>
            <td data-label="Farmer's Details">
                <button onclick="viewFarmerDetails(${payment.user_id})" class="details-btn">
                    View Details
                </button>
            </td>
        `;
    PaymentsTable.appendChild(row);
  });
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

function viewFarmerDetails(buyerId) {
   
  fetch(`${URLROOT}/ManufacturerController/getBuyerDetails/${buyerId}`)
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
              <p>${data.phone}</p>
            </div>
          </div>
          <div class="farmer-detail">
            <div class="detail-icon">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="detail-content">
              <h4>E-mail</h4>
              <p>${data.email}</p>
            </div>
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
