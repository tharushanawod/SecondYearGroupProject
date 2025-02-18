const moderatorsTable = document.querySelector("#moderatorTable tbody");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const pageInfo = document.getElementById("pageInfo");

let currentPage = 1;
const rowsPerPage = 10;
let moderators = [];  // This will store all the fetched moderators

// Fetch all moderators from the controller
function fetchModerators() {
    fetch(`${URLROOT}/AdminController/getAllModerators`)
        .then(response => response.json())
        .then(data => {
            moderators = data;  // Store all moderators in the array
            renderTable();  // Initial table render
            updatePagination();
        })
        .catch(error => console.log('Error fetching moderators:', error));
}

// Render table rows for moderators based on current page
function renderTable() {
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedModerators = moderators.slice(start, end);

    moderatorsTable.innerHTML = "";  // Clear the existing table

    paginatedModerators.forEach(moderator => {
        console.log(moderator);
        const row = document.createElement("tr");
        row.innerHTML = `
            <td data-label="Moderator ID">${moderator.moderator_id}</td>
            <td data-label="Name">${moderator.name}</td>
            <td data-label="Email">${moderator.email}</td>
            <td data-label="Status">${moderator.status}</td>
        `;
        moderatorsTable.appendChild(row);
    });
}

// Update pagination info (current page and total pages)
function updatePagination() {
    const totalPages = Math.ceil(moderators.length / rowsPerPage);
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
    const totalPages = Math.ceil(moderators.length / rowsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        renderTable();
        updatePagination();
    }
});

// Initial fetch and render
fetchModerators();
