<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Search Users</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Admin/ModeratorControl.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
  </head>
  <body>
  <?php require APPROOT . '/views/inc/sidebar.php'; ?> 

  <div class="table-container">
    <div class="control-panel">
        <div class="search-container">
            <input type="text" id="moderatorSearch" placeholder="Search moderators...">
            <i class="fas fa-search"></i>
        </div>
        <a href="<?php echo URLROOT; ?>/AdminController/AddModerator">
        <button class="add-moderator-btn">
            <i class="fas fa-user-plus"></i>
            Add Moderator
        </button>
        </a>
       
    </div>
    <table id="moderatorTable">
      <thead>
        <tr>
          <th>Moderator ID</th>
          <th>Name</th>
          <th>Email</th>
          <th>Phone</th>
          <th>Created On</th>
          <th>Account Status</th>
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
<script>
  const URLROOT = "<?php echo URLROOT; ?>";
</script>
<script>
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
            <td data-label="Moderator ID">${moderator.user_id}</td>
            <td data-label="Name">${moderator.name}</td>
            <td data-label="Email">${moderator.email}</td>
            <td data-label="Status">${moderator.phone}</td>
            <td data-label="Date">${moderator.created_at}</td>
            <td data-label="Date">${moderator.user_status}</td>
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
document.addEventListener("DOMContentLoaded", () => {
  fetchModerators();
});

// Add this to your existing JavaScript
document.getElementById('moderatorSearch').addEventListener('input', function(e) {
    const searchTerm = e.target.value.toLowerCase();
    const filteredModerators = moderators.filter(moderator => 
        moderator.name.toLowerCase().includes(searchTerm) ||
        moderator.email.toLowerCase().includes(searchTerm) ||
        moderator.user_id.toString().includes(searchTerm)
    );
    
    // Update the table with filtered results
    currentPage = 1; // Reset to first page when searching
    moderators = filteredModerators;
    renderTable();
    updatePagination();
});

// Add click handler for add moderator button
document.querySelector('.add-moderator-btn').addEventListener('click', function() {
    window.location.href = `${URLROOT}/AdminController/AddModerator`;
});
</script>
 <script src="<?php echo URLROOT;?>/js/Admin/ModeratorControl.js"></script>
  </body>
</html>
