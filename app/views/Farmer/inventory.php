<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Table with Pagination</title>
  <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/Checkout.css">
  <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
  <link rel="stylesheet" href="styles.css">
  <style>
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        background-color: #f8f9fa;
    }

    .table-container {
        max-width: 1200px;
        margin-left: 250px;
        padding: 30px;
        background-color: white;
        border-radius: 10px;
        margin-top: 20px;
    }

    table {
        width: 100%;
        border-collapse: separate;
        border-spacing: 0;
        margin-bottom: 20px;
        border-radius: 8px;
        overflow: hidden;
    }

    thead {
        background-color: #1f6146;
        color: white;
    }

    th, td {
        padding: 15px 20px;
        text-align: left;
        border: none;
        border-bottom: 1px solid #eee;
    }

    th {
        font-weight: 600;
        text-transform: uppercase;
        font-size: 14px;
        letter-spacing: 0.5px;
    }

    td {
        font-size: 14px;
        color: #333;
    }

    tbody tr {
        transition: all 0.3s ease;
    }

    tbody tr:hover {
        background-color: #f5f8ff;
        transform: scale(1.003);
        box-shadow: 0 3px 10px rgba(0, 0, 0, 0.1);
    }

    tbody tr:nth-child(even) {
        background-color: #f8f9fa;
    }

    .pagination {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 15px;
        margin-top: 30px;
    }

    button {
        padding: 10px 20px;
        background-color: #1f6146;
        color: white;
        border: none;
        cursor: pointer;
        border-radius: 5px;
        font-weight: 500;
        transition: all 0.3s ease;
    }

    button:hover:not(:disabled) {
        background-color: #34495e;
        transform: translateY(-2px);
    }

    button:disabled {
        background-color: #95a5a6;
        cursor: not-allowed;
    }

    #pageInfo {
        font-size: 14px;
        font-weight: 500;
        color: #2c3e50;
    }

    h1 {
        text-align: center;
        color: #2c3e50;
        font-size: 28px;
        font-weight: 600;
        padding-top:40px;
        font-size:2rem;
    }

    .confirm-btn, .cancel-btn {
        padding: 8px 12px;
        margin: 2px;
        font-size: 12px;
    }

    .confirm-btn {
        background-color: #28a745;
    }

    .cancel-btn {
        background-color: #dc3545;
    }

    .confirm-btn:hover {
        background-color: #218838;
    }

    .cancel-btn:hover {
        background-color: #c82333;
    }
  </style>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?> 
<h1>Orders</h1>
  <div class="table-container">
    <table id="orderTable">
      <thead>
        <tr>
          <th>Order ID</th>
          <th>Product</th>
          <th>Supplier</th>
          <th>Price</th>
          <th>Items</th>
          <th>Status</th>
          <th>Actions</th>  
        </tr>
      </thead>
      <tbody>
        <!-- Rows will be dynamically inserted here -->
      </tbody>
    </table>
    <div class="pagination">
      <button id="prevBtn">Previous</button>
      <span id="pageInfo"></span>
      <button id="nextBtn">Next</button>
    </div>
  </div>

  <script src="script.js"></script>
  <script>
    // Sample data
    const orders = [
  { id: 1, product: "UREA", supplier: "Dasanayaka", price: 2900, items: 2, status: "Pending" },
  { id: 2, product: "FABIA PestControl", supplier: "N.M Herath", price: 1200, items: 5, status: "Accepted" },
  { id: 3, product: "666 Hybrid seeds", supplier: "H.K Gajasinghe", price: 8989, items: 2, status: "Accepted" },
  { id: 4, product: "ACELA liquid Fertilizer", supplier: "N.B Asanka", price: 9670, items: 3, status: "Pending" }
];


// Pagination variables
const rowsPerPage = 10;
let currentPage = 1;

// DOM elements
const tableBody = document.querySelector("#orderTable tbody");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const pageInfo = document.getElementById("pageInfo");

// Function to render table rows for the current page
function renderTable() {
  const start = (currentPage - 1) * rowsPerPage;
  const end = start + rowsPerPage;
  const paginatedOrders = orders.slice(start, end);

  tableBody.innerHTML = "";

  paginatedOrders.forEach(order => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td data-label="Order ID">${order.id}</td>
      <td data-label="Product">${order.product}</td>
      <td data-label="Buyer">${order.supplier}</td>
      <td data-label="Unit Price (Rs)">${order.price}</td>
      <td data-label="Quantity">${order.items}</td>
      <td data-label="Status">${order.status}</td>
      <td data-label="Actions">
        <button class="confirm-btn" onclick="confirmDelivery(${order.id})">Confirm Delivery</button>
        <button class="cancel-btn" onclick="cancelOrder(${order.id})">Cancel Order</button>
      </td>
    `;
    tableBody.appendChild(row);
  });

  pageInfo.textContent = `Page ${currentPage} of ${Math.ceil(orders.length / rowsPerPage)}`;
  prevBtn.disabled = currentPage === 1;
  nextBtn.disabled = currentPage === Math.ceil(orders.length / rowsPerPage);
}

// Event listeners for pagination buttons
prevBtn.addEventListener("click", () => {
  if (currentPage > 1) {
    currentPage--;
    renderTable();
  }
});

nextBtn.addEventListener("click", () => {
  if (currentPage < Math.ceil(orders.length / rowsPerPage)) {
    currentPage++;
    renderTable();
  }
});

// Initial render
renderTable();

// Add these new functions
function confirmDelivery(orderId) {
  // Add your confirmation logic here
  console.log(`Confirming delivery for order ${orderId}`);
}

function cancelOrder(orderId) {
  // Add your cancellation logic here
  console.log(`Cancelling order ${orderId}`);
}
  </script>
</body>
</html>Z