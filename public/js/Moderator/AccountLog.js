const logTable = document.querySelector("#logTable tbody");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const pageInfo = document.getElementById("pageInfo");

let currentPage = 1;
const rowsPerPage = 10;
let logs = []; // This will store all the fetched logs

// Fetch all logs from the controller
function fetchLogs() {
    fetch(`${URLROOT}/ModeratorController/getAccountLog/`)
        .then((response) => response.json())
        .then((data) => {
            logs = data; // Store all logs in the array
            renderTable(); // Initial table render
            updatePagination();
        })
        .catch((error) => console.log("Error fetching logs:", error));
}

// Render table rows for logs based on current page
function renderTable() {
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedLogs = logs.slice(start, end);

    logTable.innerHTML = ""; // Clear the table

    // Check if there is no data
    if (paginatedLogs.length === 0) {
        const row = document.createElement("tr");
        row.innerHTML = `<td colspan="4" style="text-align:center;">No logs to show</td>`;
        logTable.appendChild(row);
        return; // Stop here, don't try to render
    }

    paginatedLogs.forEach((log) => {
        const row = document.createElement("tr");
        const logTime = new Date(log.logged_at);
        row.innerHTML = `
            <td data-label="LOG ID">${log.log_id}</td>
            <td data-label="Buyer ID">${log.user_id}</td>
            <td data-label="Reason">${log.reason}</td>
            <td data-label="Log Time">${formatDate(logTime)}</td>
        `;
        logTable.appendChild(row);
    });
}

// Format date to a readable string
function formatDate(date) {
    return date.toLocaleString();
}

// Update pagination info (current page and total pages)
function updatePagination() {
    const totalPages = Math.ceil(logs.length / rowsPerPage);
    pageInfo.textContent = `Page ${currentPage} of ${totalPages}`;

    prevBtn.disabled = currentPage === 1;
    nextBtn.disabled = currentPage === totalPages || totalPages === 0;
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
    const totalPages = Math.ceil(logs.length / rowsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        renderTable();
        updatePagination();
    }
});

// Initial fetch and render
fetchLogs();
