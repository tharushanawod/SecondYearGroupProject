<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Table with Pagination</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/PendingPayments.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?> 
<h1>Pending Payments</h1>
    <div class="table-container">
        <table id="orderTable">
        <input type="text" id="searchInput" placeholder="Search by Bid ID or Amount..." style="margin-bottom: 20px; padding: 10px; width: 100%; border-radius: 5px; border: 1px solid #ccc;">
            <thead>
                <tr>
                    <th>Bid ID</th>
                    <th>Bid Amount</th>
                    <th>Quantity</th>
                    <th>Total</th>
                    <th>Advance</th>  
                    <th>Action</th>  
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
 // Sample data (same as in your code)
const orders = [
    { id: 1, pricePerKg: 106, quantity: 100 },
    { id: 2, pricePerKg: 103, quantity: 150 },
    { id: 3, pricePerKg: 107, quantity: 80 },
    { id: 4, pricePerKg: 99, quantity: 80 },
    { id: 5, pricePerKg: 106, quantity: 80 },
    { id: 6, pricePerKg: 107, quantity: 80 },
    { id: 7, pricePerKg: 105, quantity: 80 },
    { id: 8, pricePerKg: 104, quantity: 80 },
    { id: 9, pricePerKg: 102, quantity: 80 },
    { id: 10, pricePerKg: 101, quantity: 80 },
    { id: 11, pricePerKg: 100, quantity: 80 },
    { id: 12, pricePerKg: 98, quantity: 80 },
    { id: 13, pricePerKg: 97, quantity: 80 },
    { id: 14, pricePerKg: 96, quantity: 80 },
    { id: 15, pricePerKg: 95, quantity: 80 },
    { id: 16, pricePerKg: 94, quantity: 80 },
    { id: 17, pricePerKg: 93, quantity: 80 },
    { id: 18, pricePerKg: 92, quantity: 80 },
    { id: 19, pricePerKg: 91, quantity: 80 },
    { id: 20, pricePerKg: 90, quantity: 80 },
    { id: 21, pricePerKg: 89, quantity: 80 },
    { id: 22, pricePerKg: 88, quantity: 80 },
    { id: 23, pricePerKg: 87, quantity: 80 },
    { id: 24, pricePerKg: 86, quantity: 80 },
    { id: 25, pricePerKg: 85, quantity: 80 },
    { id: 26, pricePerKg: 84, quantity: 80 },
    { id: 27, pricePerKg: 83, quantity: 80 },
    { id: 28, pricePerKg: 82, quantity: 80 },
    { id: 29, pricePerKg: 81, quantity: 80 },
    { id: 30, pricePerKg: 80, quantity: 80 },
];

// Pagination variables
const rowsPerPage = 10;
let currentPage = 1;
let filteredOrders = orders;  // Initially all orders are visible

// DOM elements
const tableBody = document.querySelector("#orderTable tbody");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const pageInfo = document.getElementById("pageInfo");
const searchInput = document.getElementById("searchInput");

// Function to render table rows for the current page
function renderTable() {
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedOrders = filteredOrders.slice(start, end);

    tableBody.innerHTML = "";

    paginatedOrders.forEach(order => {
        const total = order.pricePerKg * order.quantity;
        const advance = total * 0.1; // Assuming advance is 10% of total

        const row = document.createElement("tr");
        row.innerHTML = `
            <td data-label="Bid ID">${order.id}</td>
            <td data-label="Bid Amount">${order.pricePerKg}</td>
            <td data-label="Quantity">${order.quantity}</td>
            <td data-label="Total">${total.toFixed(2)}</td>
            <td data-label="Advance">${advance.toFixed(2)}</td>
            <td>
                <button class="cancel-btn" onclick="cancelOrder(${order.id})">Cancel Payment</button>
                <button class="confirm-btn" onclick="confirmDelivery(${order.id})">Pay Advance</button>
            </td>
        `;
        tableBody.appendChild(row);
    });

    pageInfo.textContent = `Page ${currentPage} of ${Math.ceil(filteredOrders.length / rowsPerPage)}`;
    prevBtn.disabled = currentPage === 1;
    nextBtn.disabled = currentPage === Math.ceil(filteredOrders.length / rowsPerPage);
}

// Event listeners for pagination buttons
prevBtn.addEventListener("click", () => {
    if (currentPage > 1) {
        currentPage--;
        renderTable();
    }
});

nextBtn.addEventListener("click", () => {
    if (currentPage < Math.ceil(filteredOrders.length / rowsPerPage)) {
        currentPage++;
        renderTable();
    }
});

// Search filter
searchInput.addEventListener("input", function() {
    const query = this.value.toLowerCase();
    filteredOrders = orders.filter(order => 
        order.id.toString().includes(query) || 
        order.pricePerKg.toString().includes(query)
    );
    currentPage = 1;  // Reset to first page when searching
    renderTable();
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
</html>
