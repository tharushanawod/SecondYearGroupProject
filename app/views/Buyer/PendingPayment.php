<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Table with Pagination</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/Checkout.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
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
<h1>Pending Payments</h1>
    <div class="table-container">
        <table id="orderTable">
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
        // Sample data
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
</html>
