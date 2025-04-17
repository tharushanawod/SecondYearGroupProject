<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Control with Pagination</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Admin/UserControl.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?> 
<h1>Account Verfication</h1>
    <div class="table-container">
        <table id="userTable">
            <thead>
                <tr>
                    <th>User ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Role</th>
                    <th>OTP Status</th>
                    <th>Account Status</th>
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
    <!-- Update the modal HTML -->
    <div id="restrictModal" class="modal">
        <div class="modal-content">
            <h2 id="modalTitle">Confirm Restriction</h2>
            <p id="modalMessage">Are you sure you want to restrict this user?</p>
            <div class="modal-buttons">
                <button class="cancel-restrict" onclick="closeModal()">Cancel</button>
                <button class="confirm-restrict" id="confirmRestrict">Confirm</button>
            </div>
        </div>
    </div>

    <script>
    const URLROOT = "<?php echo URLROOT; ?>";
    </script>
    <script>
        const moderatorsTable = document.querySelector("#userTable tbody");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const pageInfo = document.getElementById("pageInfo");

let currentPage = 1;
const rowsPerPage = 10;
let moderators = []; // This will store all the fetched moderators

// Fetch all moderators from the controller
function fetchModerators() {
  fetch(`${URLROOT}/AdminController/getPendingUsers`)
    .then((response) => response.json())
    .then((data) => {
      users = data; // Store all moderators in the array
      renderTable(); // Initial table render
      updatePagination();
    })
    .catch((error) => console.log("Error fetching moderators:", error));
}

// Render table rows for moderators based on current page
function renderTable() {
  const start = (currentPage - 1) * rowsPerPage;
  const end = start + rowsPerPage;
  const paginatedUserss = users.slice(start, end);

  moderatorsTable.innerHTML = ""; // Clear the existing table

  paginatedUserss.forEach((user) => {
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
                <a href="${URLROOT}/AdminController/ViewDocument/${user.user_id}" target="_blank">
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

    </script>
</body>
</html>
