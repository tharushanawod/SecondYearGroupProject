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
<h1>User Control</h1>
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

    <script>
    const URLROOT = "<?php echo URLROOT; ?>";
    </script>
    <script>
    const usersTable = document.querySelector("#userTable tbody");
    const prevBtn = document.getElementById("prevBtn");
    const nextBtn = document.getElementById("nextBtn");
    const pageInfo = document.getElementById("pageInfo");

    let currentPage = 1;
    const rowsPerPage = 10;
    let users = [];  // This will store all the fetched users

    // Fetch all users from the controller
    function fetchUsers() {
        fetch(`${URLROOT}/AdminController/getAllUsers`)
            .then(response => response.json())
            .then(data => {
                users=data;
                renderTable();  // Initial table render
                updatePagination();
            })
            .catch(error => console.log('Error fetching users:', error));
    }

    // Render table rows for users based on current page
    function renderTable() {
        const start = (currentPage - 1) * rowsPerPage;
        const end = start + rowsPerPage;
        const paginatedUsers = users.slice(start, end);

        usersTable.innerHTML = "";  // Clear the existing table

        paginatedUsers.forEach(user => {
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
                    <button class="confirm-btn" onclick="updateUser(${user.id})">Update User</button>
                    </a>
                    
                    <button class="cancel-btn" onclick="restrictUser(${user.id})">Restrict User</button>
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

    // Initial fetch and render
    fetchUsers();
    </script>
</body>
</html>
