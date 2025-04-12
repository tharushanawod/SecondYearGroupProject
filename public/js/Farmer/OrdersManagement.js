const ordersTable = document.querySelector("#orderTable tbody");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const pageInfo = document.getElementById("pageInfo");

let currentPage = 1;
const rowsPerPage = 10;
let orders = []; // This will store all the fetched orders

// Fetch all orders from the controller
function fetchOrders() {
  fetch(`${URLROOT}/FarmerController/getAllOrders/${USERID}`)
    .then((response) => response.json())
    .then((data) => {
      orders = data; // Store all orders in the array
      renderTable(); // Initial table render
      updatePagination();
    })
    .catch((error) => console.log("Error fetching orders:", error));
}

// Render table rows for orders based on current page
function renderTable() {
  const start = (currentPage - 1) * rowsPerPage;
  const end = start + rowsPerPage;
  const paginatedOrders = orders.slice(start, end);

  ordersTable.innerHTML = ""; // Clear the existing table

  paginatedOrders.forEach((order) => {
    const row = document.createElement("tr");
    const totalAmount = order.bid_price * order.quantity;
    const paymenttoreceive = totalAmount * 0.7; // Assuming paid amount is 30% as advance order
    row.innerHTML = `
      <td data-label="Order ID">${order.order_id}</td>
       <td data-label="Quantity">${order.quantity}</td>
        <td data-label="Unit Price (Rs)">${order.bid_price}</td>
         <td data-label="order To Receive (Rs)">${paymenttoreceive.toFixed(
           2
         )}</td>
   <td data-label="Buyers's Details">
                <button onclick="viewBuyerDetails(${
                  order.buyer_id
                })" class="details-btn">
                    View Details
                </button>
            </td>
      <td data-label="Status">${order.payment_status}</td>
       <td data-label="Farmer Confirmation">${getBuyerConfirmationStatus(
         order
       )}</td>
            <td data-label="Your Confirmation">${getFarmerConfirmationStatus(
              order
            )}</td>
    `;
    ordersTable.appendChild(row);
  });
}

function getFarmerConfirmationStatus(order) {
  // Replace with your actual data structure
  if (order.farmer_confirmed === 1) {
    return `<span class="confirmed"><i class="fa-solid fa-check"></i> Confirmed</span>`;
  } else if (order.farmer_confirmed === 0 && order.payment_status === "paid") {
    return `<button onclick="confirmOrder(${order.order_id})" class="confirm-btn"><i class="fa-solid fa-square-check"></i>  Confirm</button>`;
  } else {
    return `<span class="rejected"><i class="fa-solid fa-xmark"></i> Wait till payment</span>`;
  }
}

// Helper function to display buyer confirmation status
function getBuyerConfirmationStatus(order) {
  // Replace with your actual data structure
  if (order.buyer_confirmed === 1) {
    return `<span class="confirmed"><i class="fa-solid fa-check"></i> Confirmed</span>`;
  } else {
    return `<span class="pending"><i class="fa-solid fa-clock"></i> Pending</span>`;
  }
}

// Update pagination info (current page and total pages)
function updatePagination() {
  const totalPages = Math.ceil(orders.length / rowsPerPage);
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
  const totalPages = Math.ceil(orders.length / rowsPerPage);
  if (currentPage < totalPages) {
    currentPage++;
    renderTable();
    updatePagination();
  }
});

function confirmOrder(orderId) {
  console.log("Confirming order with ID:", orderId);
  fetch(`${URLROOT}/FarmerController/confirmOrder/${orderId}`, {
    method: "POST",
  })
    .then((response) => response.json())
    .then((data) => {
      fetchOrders(); // Refresh data after confirmation
    })
    .catch((error) => console.error("Error confirming payment:", error));
}

function viewBuyerDetails(buyerId) {
  fetch(`${URLROOT}/FarmerController/getBuyerDetails/${buyerId}`)
    .then((response) => response.json())
    .then((data) => {
      const modal = document.getElementById("buyerModal");
      const content = document.getElementById("buyerDetailsContent");

      content.innerHTML = `
                <div class="buyer-detail">
                    <div class="detail-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="detail-content">
                        <h4>Name</h4>
                        <p>${data.name}</p>
                    </div>
                </div>
                <div class="buyer-detail">
                    <div class="detail-icon">
                        <i class="fas fa-phone"></i>
                    </div>
                    <div class="detail-content">
                        <h4>Contact Number</h4>
                        <p>${data.phone}</p>
                    </div>
                </div>
            `;

      modal.style.display = "block";
      document.body.style.overflow = "hidden"; // Prevent scrolling when modal is open
    })
    .catch((error) => console.error("Error fetching buyer details:", error));
}

function closeBuyerModal() {
  const modal = document.getElementById("buyerModal");
  modal.style.display = "none";
  document.body.style.overflow = "auto"; // Re-enable scrolling
}

// Close modal when clicking outside
window.onclick = function (event) {
  const modal = document.getElementById("buyerModal");
  if (event.target == modal) {
    closeBuyerModal();
  }
};

// Initial fetch and render
fetchOrders();
