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
  fetch(`${URLROOT}/SupplierController/getAllOrders/${USERID}`)
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
      <td>${getStatusHTML(order)}</td>
      <td>${getDeliveryConfirmationStatus(order)}</td>
      <td>${getCodeSendStatus(order)}</td>
    `;
    ordersTable.appendChild(row);
  });
}

// Get status HTML based on order data
function getStatusHTML(order) {
  if (order.farmer_confirmed === 1) {
    return `<span class="confirmed"><i class="fa-solid fa-check"></i> Confirmed</span>`;
  } else if (order.payment_status === "paid") {
    return `<button onclick="confirmOrder(${order.order_id})" class="confirm-btn">Confirm</button>`;
  } else {
    return `<span class="rejected"><i class="fa-solid fa-xmark"></i> Wait till payment</span>`;
  }
}

// Get delivery confirmation status
function getDeliveryConfirmationStatus(order) {
  if (order.delivery_confirmed === null) {
    return `<span class="not-paid"><i class="fa-solid fa-xmark"></i> Not Paid</span>`;
  } else if (order.delivery_confirmed === 1) {
    return `<span class="confirmed"><i class="fa-solid fa-check"></i> Confirmed</span>`;
  } else {
    return `<span class="pending"><i class="fa-solid fa-clock"></i> Pending</span>`;
  }
}

// Get code send status
function getCodeSendStatus(order) {
  let result;

  if (order.code_id === null && order.payment_status === "paid") {
    result = `<a href="${URLROOT}/SupplierController/sendDeliveryCode/${order.order_id}"> <button>Send Code</button></a>`;
  }
  else if (order.code_id) {
    result = `<span>Code Sent</span>`;
  }
  else{
    result = `<span>X wait till payment</span>`;
  }
  return result;
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
function confirmOrder(orderId) {
  fetch(`${URLROOT}/SupplierController/confirmOrder/${orderId}`, {
    method: "POST",
  })
    .then(() => fetchOrders()) // Refresh data after confirmation
    .catch((error) => console.error("Error confirming order:", error));
}

// View buyer details
function viewBuyerDetails(orderId) {
  fetch(`${URLROOT}/SupplierController/getBuyerDetails/${orderId}`)
    .then((response) => response.json())
    .then((data) => {
      alert(
        `Buyer Details:\nName: ${data.first_name} ${data.last_name}\nPhone: ${data.phone}\nAddress: ${data.address}, ${data.city}, ${data.postcode}`
      );
    })
    .catch((error) => console.error("Error fetching buyer details:", error));
}

// View order details
function viewOrderDetails(orderId) {
  fetch(`${URLROOT}/SupplierController/getOrderDetails/${orderId}`)
    .then((response) => response.json())
    .then((data) => {
      let details = "Order Items:\n";
      data.forEach((item) => {
        details += `- Product: ${item.product_name}, Quantity: ${item.quantity}, Price: ${item.price}\n`;
      });
      alert(details);
    })
    .catch((error) => console.error("Error fetching order details:", error));
}

// Initial fetch and render
fetchOrders();
