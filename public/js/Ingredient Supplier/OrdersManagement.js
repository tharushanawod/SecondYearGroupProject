const ordersTable = document.querySelector("#orderTable tbody");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const pageInfo = document.getElementById("pageInfo");

let currentPage = 1;
const rowsPerPage = 10;
let orders = []; // This will store all the fetched orders
let A; // This will store the status of the order

// Fetch all orders from the controller
function fetchOrders() {
  fetch(`${URLROOT}/SupplierController/getAllOrders/${USERID}`)
    .then((response) => response.json())
    .then((data) => {
      orders = data; // Store all orders in the array
      renderTable(); // Initial table render
      updatePagination();
    })
    .catch((error) => console.log("Error fetching orders:", error));
}

async function renderTable() {
  const start = (currentPage - 1) * rowsPerPage;
  const end = start + rowsPerPage;
  const paginatedOrders = orders.slice(start, end);

  ordersTable.innerHTML = ""; // Clear the table

  for (const order of paginatedOrders) {
    const row = document.createElement("tr");

    const statusHTML = await getDeliveryConfirmationStatus(order.order_id); // Wait for result

    row.innerHTML = `
      <td data-label="Order ID">${order.order_id}</td>
      <td data-label="Buyer's Details">
      <button onclick="viewOrderDetails(${order.order_id})" class="details-btn">View Details</button>
      </td>
      <td data-label="Buyer's Details">
      <button onclick="viewBuyerDetails(${order.order_id})" class="details-btn">View Details</button>
      </td>
      <td data-label="Status">${order.status}</td>
      <td data-label="Farmer Confirmation">${statusHTML}</td>
      <td data-label="Send Code">
      ${order.code_id === null ? 
        `<a href="${URLROOT}/SupplierController/sendDeliveryCode/${order.order_id}" class="details-btn">Send Code</a>` : 
        `<span class="code-sent-text">Code Sent</span>`}
      </td>
    `;

    ordersTable.appendChild(row);
  }
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

async function getDeliveryConfirmationStatus(orderId) {
  try {
    const response = await fetch(
      `${URLROOT}/SupplierController/getDeliveryConfirmationStatus/${orderId}`
    );

    if (!response.ok) {
      throw new Error(`HTTP error! status: ${response.status}`);
    }

    const data = await response.json();

    const A = data.delivery_confirmed;

    // Return the appropriate HTML based on the status
    if (A === null) {
      return `<span class="not-paid"><i class="fa-solid fa-xmark"></i> Not Paid</span>`;
    }
    return A === 1
      ? `<span class="confirmed"><i class="fa-solid fa-check"></i> Confirmed</span>`
      : `<span class="pending"><i class="fa-solid fa-clock"></i> Pending</span>`;
    
  } catch (error) {
    console.error("Error fetching delivery confirmation status:", error);
    return `<span class="error"><i class="fa-solid fa-exclamation-triangle"></i> Error</span>`;
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
  fetch(`${URLROOT}/SupplierController/confirmOrder/${orderId}`, {
    method: "POST",
  })
    .then((response) => response.json())
    .then((data) => {
      fetchOrders(); // Refresh data after confirmation
    })
    .catch((error) => console.error("Error confirming payment:", error));
}

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
                        <p>${data.first_name}</p>
                         <p>${data.last_name}</p>
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

function viewOrderDetails(orderId) {
  fetch(`${URLROOT}/SupplierController/getOrderDetails/${orderId}`)
    .then((response) => response.json())
    .then((data) => {
      console.log(data); // Log the data for debugging
      const modal = document.getElementById("orderDetailsModal");
      const orderItemsContainer = document.querySelector(
        ".order-item-container"
      );

      // Fill in order items only
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

      // Show modal
      modal.style.display = "block";
      document.body.style.overflow = "hidden";
    })
    .catch((error) => console.error("Error fetching order details:", error));
}

function closeBuyerModal() {
  const modal = document.getElementById("buyerModal");
  modal.style.display = "none";
  document.body.style.overflow = "auto"; // Re-enable scrolling
}

function closeOrderDetailsModal() {
  const modal = document.getElementById("orderDetailsModal");
  modal.style.display = "none";
  document.body.style.overflow = "auto"; // Re-enable scrolling
}
// Close modal when clicking outside
window.onclick = function (event) {
  const modal = document.getElementById("buyerModal");
  if (event.target == modal) {
    closeBuyerModal();
    closeOrderDetailsModal();
  }
};

// Initial fetch and render
fetchOrders();
