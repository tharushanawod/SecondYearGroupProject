const usersTable = document.querySelector("#userTable tbody");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const pageInfo = document.getElementById("pageInfo");

let currentPage = 1;
const rowsPerPage = 10;
let users = [];  // This will store all the fetched users

// Fetch all users from the controller
async function fetchUsers() {
    try {
        const response = await fetch(`${URLROOT}/AdminController/getAllUsers`);
        const data = await response.json();
        users = data;
        renderTable();  // Initial table render
        updatePagination();
    } catch (error) {
        console.log('Error fetching users:', error);
    }
}


// Render table rows for users based on current page
function renderTable() {
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedUsers = users.slice(start, end);

    usersTable.innerHTML = "";  // Clear the existing table

    paginatedUsers.forEach(user => {
        const isRestricted = user.user_status.toLowerCase() === 'restricted';
        const actionButton = isRestricted 
            ? `<button class="activate-btn" onclick="showRestrictModal('${URLROOT}/AdminController/ActivateUser/${user.user_id}', true)">Activate User</button>`
            : `<button class="cancel-btn" onclick="window.location.href='${URLROOT}/AdminController/Restriction/${user.user_id}'">Restrict User</button>`;

        const row = document.createElement("tr");
        row.innerHTML = `
            <td data-label="User ID">${user.user_id}</td>
            <td data-label="Name">${user.name}</td>
            <td data-label="Email">${user.email}</td>
            <td data-label="Role">${user.user_type}</td>
            <td data-label="OTP Status">${user.otp_status}</td>
            <td data-label="Account Status">${user.user_status}</td>
            <td data-label="Actions">
                <a href="${URLROOT}/AdminController/UpdateUserDetails/${user.user_id}">
                    <button class="confirm-btn">Update User</button>
                </a>
                ${actionButton}
            </td>
        `;
        usersTable.appendChild(row);
    });
}

// Update pagination info (current page and total pages)
function updatePagination() {
    const totalPages = Math.ceil(users.length / rowsPerPage);
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
    const totalPages = Math.ceil(users.length / rowsPerPage);
    if (currentPage < totalPages) {
        currentPage++;
        renderTable();
        updatePagination();
    }
});

// Add these new functions at the end of your script
const modal = document.getElementById('restrictModal');
let currentRestrictUrl = '';

function showRestrictModal(url, isActivation) {
    currentRestrictUrl = url;
    const modalTitle = document.getElementById('modalTitle');
    const modalMessage = document.getElementById('modalMessage');
    const confirmButton = document.getElementById('confirmRestrict');
    
    if (isActivation) {
        modalTitle.textContent = 'Confirm Activation';
        modalMessage.textContent = 'Are you sure you want to activate this user account?';
        confirmButton.textContent = 'Activate';
        confirmButton.className = 'activate-btn';
    } else {
        modalTitle.textContent = 'Confirm Restriction';
        modalMessage.textContent = 'Are you sure you want to restrict this user?';
        confirmButton.textContent = 'Restrict';
        confirmButton.className = 'confirm-restrict';
    }
    
    modal.style.display = 'block';
}

function closeModal() {
    modal.style.display = 'none';
}

document.getElementById('confirmRestrict').addEventListener('click', function() {
    window.location.href = currentRestrictUrl;
});

// Close modal when clicking outside
window.addEventListener('click', function(event) {
    if (event.target === modal) {
        closeModal();
    }
});

// Initial fetch and render
fetchUsers();