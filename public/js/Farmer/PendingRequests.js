const requestsTable = document.querySelector("#Table tbody");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const pageInfo = document.getElementById("pageInfo");

let currentPage = 1;
const rowsPerPage = 10;
let jobRequests = [];  // This will store all the fetched job requests

// Fetch all pending job requests from the controller
function fetchJobRequests() {
    fetch(`${URLROOT}/FarmerController/getPendingJobRequests`)
        .then(response => response.json())
        .then(data => {
            jobRequests = data;  // Store all job requests in the array
            renderTable();  // Initial table render
            updatePagination();
        })
        .catch(error => console.log('Error fetching job requests:', error));
}

// Render table rows for job requests based on current page
function renderTable() {
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedRequests = jobRequests.slice(start, end);
    console.log(paginatedRequests);

    requestsTable.innerHTML = "";  // Clear the existing table

    if (paginatedRequests.length === 0) {
        const row = document.createElement("tr");
        row.innerHTML = `<td colspan="6" class="text-center">No data available</td>`;
        requestsTable.appendChild(row);
    } else {
        paginatedRequests.forEach(request => {
            const row = document.createElement("tr");
            row.innerHTML = `
                <td data-label="Request ID">${request.job_id}</td>
                <td data-label="Worker Name">${request.worker_name}</td>
                <td data-label="Status">${request.status}</td>
                <td data-label="Action">
                  <button class="action-btn confirm">Contact</button>
                </td>
            `;
            requestsTable.appendChild(row);
        });
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

// Initial fetch and render
fetchJobRequests();
