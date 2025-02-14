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
<h1>Bid Control</h1>
  <div class="table-container">
    <table id="orderTable">
      <thead>
        <tr>
          <th>Bid ID</th>
          <th>Your Bid</th>
          <th>Current Highest Bid</th>
          <th>Status</th>
          <th>Remaining Time</th>
          <th>Qunatity</th>
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
    const bids = [
  { bidId: 1, yourBid: 99, highestBid: 102, status: "Active", remainingTime: "2h 15m", quantity: "150 kg" },
  { bidId: 2, yourBid: 101, highestBid: 105, status: "Active", remainingTime: "3h 30m", quantity: "200 kg" },
  { bidId: 3, yourBid: 98, highestBid: 100, status: "Outbid", remainingTime: "1h 45m", quantity: "180 kg" },
  { bidId: 4, yourBid: 107, highestBid: 107, status: "Winning", remainingTime: "5h 10m", quantity: "250 kg" },
  { bidId: 5, yourBid: 103, highestBid: 108, status: "Active", remainingTime: "6h 25m", quantity: "220 kg" },
  { bidId: 6, yourBid: 100, highestBid: 104, status: "Outbid", remainingTime: "4h 50m", quantity: "130 kg" },
  { bidId: 7, yourBid: 102, highestBid: 103, status: "Winning", remainingTime: "2h 5m", quantity: "190 kg" },
  { bidId: 8, yourBid: 105, highestBid: 109, status: "Active", remainingTime: "7h 40m", quantity: "210 kg" },
  { bidId: 9, yourBid: 99, highestBid: 101, status: "Outbid", remainingTime: "3h 20m", quantity: "175 kg" },
  { bidId: 10, yourBid: 108, highestBid: 109, status: "Active", remainingTime: "5h 55m", quantity: "160 kg" },
  { bidId: 11, yourBid: 98, highestBid: 100, status: "Outbid", remainingTime: "4h 35m", quantity: "140 kg" },
  { bidId: 12, yourBid: 106, highestBid: 106, status: "Winning", remainingTime: "1h 10m", quantity: "230 kg" },
  { bidId: 13, yourBid: 100, highestBid: 105, status: "Active", remainingTime: "8h 20m", quantity: "195 kg" },
  { bidId: 14, yourBid: 109, highestBid: 109, status: "Winning", remainingTime: "2h 50m", quantity: "225 kg" },
  { bidId: 15, yourBid: 104, highestBid: 107, status: "Active", remainingTime: "6h 15m", quantity: "185 kg" }
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
  const paginatedBids = bids.slice(start, end);

  tableBody.innerHTML = "";

  paginatedBids.forEach(bid => {
    const row = document.createElement("tr");
    row.innerHTML = `
      <td data-label="Bid ID">${bid.bidId}</td>
      <td data-label="Your Bid (Rs)">${bid.yourBid}</td>
      <td data-label="Current Highest Bid (Rs)">${bid.highestBid}</td>
      <td data-label="Status">${bid.status}</td>
      <td data-label="Remaining Time">${bid.remainingTime}</td>
      <td data-label="Quantity">${bid.quantity}</td>
      <td>
            <button class="cancel-btn" onclick="cancelOrder(${bid.bidId})">Cancel Bid</button>
            <button class="confirm-btn" onclick="confirmDelivery(${bid.bidId})">Adjust Bid</button>
        </td>
    `;
    tableBody.appendChild(row);
});


  pageInfo.textContent = `Page ${currentPage} of ${Math.ceil(bids.length / rowsPerPage)}`;
  prevBtn.disabled = currentPage === 1;
  nextBtn.disabled = currentPage === Math.ceil(bids.length / rowsPerPage);
}

// Event listeners for pagination buttons
prevBtn.addEventListener("click", () => {
  if (currentPage > 1) {
    currentPage--;
    renderTable();
  }
});

nextBtn.addEventListener("click", () => {
  if (currentPage < Math.ceil(bids.length / rowsPerPage)) {
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