// DOM Elements
const ordersTable = document.querySelector("#orderTable tbody");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const pageInfo = document.getElementById("pageInfo");

// Variables
let currentPage = 1;
const rowsPerPage = 10;
let orders = []; // Stores all fetched orders

// Fetch all orders and render the table
function fetchOrders() {
  fetch(`${URLROOT}/SupplierController/getPendingOrders/${USERID}`)
    .then((response) => response.json())
    .then((data) => {
      orders = data; // Store fetched orders
      renderTable(); // Render the table
      updatePagination(); // Update pagination info
    })
    .catch((error) => console.error("Error fetching orders:", error));
}

// Render paginated orders in the table
function renderTable() {
  const start = (currentPage - 1) * rowsPerPage;
  const end = start + rowsPerPage;
  const paginatedOrders = orders.slice(start, end);

  ordersTable.innerHTML = ""; // Clear the table

  paginatedOrders.forEach((order) => {
    console.log("Order Data:", order); // Debugging line
    const row = document.createElement("tr");
    row.innerHTML = `
      <td>${order.order_id}</td>
      <td><button onclick="viewOrderDetails(${
        order.order_id
      })">View Order</button></td>
      <td><button onclick="viewBuyerDetails(${
        order.order_id
      })">View Buyer</button></td>
      <td>${getPaymentStatusHTML(order)}</td>
      <td>${getActionButtons(order)}</td>
    
    `;
    ordersTable.appendChild(row);
  });
}

// Get status HTML based on order data
function getPaymentStatusHTML(order) {
  if (order.payment_status === "paid") {
    return `<span class="confirmed"><i class="fas fa-money-bill-wave"></i> Paid </span>`;
  } else if (order.payment_status === "pending") {
    return `<span class="confirmed"><i class="fa-solid fa-clock"></i> Pending </span>`;
  } else {
    return `<span class="rejected"><i class="fa-solid fa-xmark"></i> Cancelled</span>`;
  }
}

function getActionButtons(order) {
  if (order.payment_status === "paid") {
    return `<button onclick="AcceptOrder(${order.order_id})">Accept Order</button>`;
  } else if (order.payment_status === "pending") {
    return `<span class="confirmed"><i class="fa-solid fa-clock"></i> Wait till payment </span>`;
  } else {
    return `<span class="rejected"><i class="fa-solid fa-xmark"></i> Cancelled</span>`;
  }
}

// Update pagination info
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

// Confirm an order
async function AcceptOrder(orderId) {
  try {
    await fetch(`${URLROOT}/SupplierController/ConfirmOrder/${orderId}`, {
      method: "POST",
    });
    await fetchOrders(); // Refresh data after confirmation
  } catch (error) {
    console.error("Error confirming order:", error);
  }
}

// View buyer details
function viewBuyerDetails(orderId) {
  fetch(`${URLROOT}/SupplierController/getBuyerDetails/${orderId}`)
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
            <p>${data.first_name} ${data.last_name}</p>
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
        <div class="buyer-detail">
          <div class="detail-icon">
            <i class="fas fa-map-marker-alt"></i>
          </div>
          <div class="detail-content">
            <h4>Address</h4>
            <p>${data.address}</p>
          </div>
        </div>
        <div class="buyer-detail">
          <div class="detail-icon">
            <i class="fas fa-city"></i>
          </div>
          <div class="detail-content">
            <h4>City</h4>
            <p>${data.city}</p>
            <h4>Postal Code</h4>
            <p>${data.postcode}</p>
          </div>
        </div>
      `;

      modal.style.display = "block";
      document.body.style.overflow = "hidden"; // Prevent scrolling when modal is open
    })
    .catch((error) => console.error("Error fetching buyer details:", error));
}

// View order details in a modal
function viewOrderDetails(orderId) {
  fetch(`${URLROOT}/SupplierController/getOrderDetails/${orderId}`)
    .then((response) => response.json())
    .then((data) => {
      const modal = document.getElementById("orderDetailsModal");
      const orderItemsContainer = document.getElementById(
        "orderDetailsContent"
      );

      // Fill in order items
      orderItemsContainer.innerHTML = Array.isArray(data)
        ? data
            .map(
              (item) => `
                <div class="order-item">
                  <p><strong>Product:</strong> ${item.product_name}</p>
                  <p><strong>Quantity:</strong> ${item.quantity}</p>
                  <p><strong>Price:</strong> ${item.price}</p>
                </div>
              `
            )
            .join("")
        : `<p>No order items found.</p>`;

      modal.style.display = "block";
      document.body.style.overflow = "hidden"; // Prevent scrolling when modal is open
    })
    .catch((error) => console.error("Error fetching order details:", error));
}

// Close buyer modal
function closeBuyerModal() {
  const modal = document.getElementById("buyerModal");
  modal.style.display = "none";
  document.body.style.overflow = "auto"; // Re-enable scrolling
}

// Close order details modal
function closeOrderDetailsModal() {
  const modal = document.getElementById("orderDetailsModal");
  modal.style.display = "none";
  document.body.style.overflow = "auto"; // Re-enable scrolling
}

// Close modal when clicking outside
window.onclick = function (event) {
  const buyerModal = document.getElementById("buyerModal");
  const orderDetailsModal = document.getElementById("orderDetailsModal");

  if (event.target === buyerModal) {
    closeBuyerModal();
  } else if (event.target === orderDetailsModal) {
    closeOrderDetailsModal();
  }
};

// Initial fetch and render
fetchOrders();
