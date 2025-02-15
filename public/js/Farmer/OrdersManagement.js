const ordersTable = document.querySelector("#orderTable tbody");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const pageInfo = document.getElementById("pageInfo");

let currentPage = 1;
const rowsPerPage = 10;
let orders = [];  // This will store all the fetched orders

// Fetch all orders from the controller
function fetchOrders() {
  fetch(`${URLROOT}/FarmerController/getAllOrders`)
    .then(response => response.json())
    .then(data => {
      orders = data;  // Store all orders in the array
      renderTable();  // Initial table render
      updatePagination();
    })
    .catch(error => console.log('Error fetching orders:', error));
}

// Render table rows for orders based on current page
function renderTable() {
  const start = (currentPage - 1) * rowsPerPage;
  const end = start + rowsPerPage;
  const paginatedOrders = orders.slice(start, end);

  ordersTable.innerHTML = "";  // Clear the existing table

  paginatedOrders.forEach(order => {
    console.log(order);
    const row = document.createElement("tr");
    row.innerHTML = `
      <td data-label="Order ID">${order.order_id}</td>
      <td data-label="Product">Corn</td>
      <td data-label="Buyer">${order.buyer_id}</td>
      <td data-label="Unit Price (Rs)">${order.bid_price}</td>
      <td data-label="Quantity">${order.quantity}</td>
      <td data-label="Status">${order.payment_status}</td>
    `;
    ordersTable.appendChild(row);
  });
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

// Initial fetch and render
fetchOrders();
