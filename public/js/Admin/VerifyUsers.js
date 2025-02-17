const moderatorsTable = document.querySelector("#userTable tbody");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const pageInfo = document.getElementById("pageInfo");

let currentPage = 1;
const rowsPerPage = 10;
let moderators = [];  // This will store all the fetched moderators

// Fetch all moderators from the controller
function fetchModerators() {
    fetch(`${URLROOT}/AdminController/getPendingUsers`)
        .then(response => response.json())
        .then(data => {
            users = data;  // Store all moderators in the array
            renderTable();  // Initial table render
            updatePagination();
        })
        .catch(error => console.log('Error fetching moderators:', error));
}

// Render table rows for moderators based on current page
function renderTable() {
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedUserss = users.slice(start, end);

    moderatorsTable.innerHTML = "";  // Clear the existing table

    paginatedUserss.forEach(user => {
        console.log(user);
        const row = document.createElement("tr");
        row.innerHTML = `
            <td data-label="Moderator ID">${user.user_id}</td>
            <td data-label="Name">${user.name}</td>
            <td data-label="Email">${user.email}</td>
            <td data-label="Status">${user.user_type}</td>
             <td data-label="Status">${user.otp_status}</td>
               <td data-label="Status">${user.user_status}</td>
               <td data-label="Actions">
                <a href="${URLROOT}/AdminController/ViewDocument/${user.user_id}">
                    <button class="confirm-btn">View Document</button>
                </a>
                <a href="${URLROOT}/AdminController/VerifyUser/${user.user_id}">
                    <button class="activate-btn">Verify User</button>
                </a>
            </td>
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
