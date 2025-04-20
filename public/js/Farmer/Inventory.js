const ordersTable = document.querySelector("#orderTable tbody");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const pageInfo = document.getElementById("pageInfo");

let currentPage = 1;
const rowsPerPage = 10;
let inventoryItems = []; // This will store all the fetched inventory items

// Fetch all inventory items from the controller
function fetchInventory() {
    fetch(`${URLROOT}/FarmerController/getIngredientInventory/${USERID}`)
        .then((response) => response.json())
        .then((data) => {
                inventoryItems = data; // Store all inventory items in the array
                renderTable(); // Initial table render
                updatePagination();
        })
        .catch((error) => console.log("Error fetching inventory:", error));
}

// Render table rows for inventory items based on current page
function renderTable() {
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedInventory = inventoryItems.slice(start, end);

    ordersTable.innerHTML = ""; // Clear the table

    // Check if there is no data
    if (paginatedInventory.length === 0) {
        const row = document.createElement("tr");
        row.innerHTML = `<td colspan="7" style="text-align:center;">No inventory items to show</td>`;
        ordersTable.appendChild(row);
        return; // Stop here, don't try to render
    }

    paginatedInventory.forEach((item) => {
        const row = document.createElement("tr");
        
        row.innerHTML = `
            <td data-label="Item ID">${item.order_id}</td>
            <td data-label="Item Name">${item.product_name}</td>
            <td data-label="Quantity">${item.quantity} </td>
            <td data-label="Price">${item.price}</td>
            <td data-label="Date Added">${new Date(item.order_date).toLocaleDateString()}</td>
            <td data-label="Action">
                <button onclick="updateInventoryItem(${item.inventory_id})" class="action-btn edit">Confirm Delivery</button>
            </td>
        `;
        ordersTable.appendChild(row);
    });
}

// Update pagination info (current page and total pages)
function updatePagination() {
    const totalPages = Math.ceil(inventoryItems.length / rowsPerPage);
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
    const totalPages = Math.ceil(inventoryItems.length / rowsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        renderTable();
        updatePagination();
    }
});

// Initial fetch and render
fetchInventory();
