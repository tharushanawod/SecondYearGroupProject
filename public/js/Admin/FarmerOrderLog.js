const logTable = document.querySelector("#logTable tbody");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const pageInfo = document.getElementById("pageInfo");

let currentPage = 1;
const rowsPerPage = 10;
let logs = []; // This will store all the fetched logs

// Fetch all logs from the controller
function fetchLogs() {
  fetch(`${URLROOT}/AdminController/getFarmerOrderLog/`)
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
    console.log(log); // Log the log object for debugging
    const link = `${URLROOT}/AdminController/RefundOfIngredients/${log.order_id}/${log.product_id}`;

    let actionButton = "";
    if (log.refund_status === "no" && log.wallet_status === "not_added" && log.status ==="paid") {
      actionButton = `<a href="${link}"><button class="btn btn-sm btn-primary view-buyer-btn">Refund Money</button></a>`;
    } else if (log.refund_status === "yes") {
      actionButton = `<span class="refunded-label">Refunded</span>`;
    } else {
      actionButton = `<span class="refunded-label">No Refunding</span>`;
    }

    row.innerHTML = `
      <td data-label="Order ID">${log.order_id || "N/A"}</td>
      <td data-label="Product ID">${log.product_id || "N/A"}</td>
      <td data-label="Farmer ID">${log.farmer_id || "N/A"}</td>
      <td data-label="Buyer ID">${log.supplier_id || "N/A"}</td>
       <td data-label="Order Details">
      <button class="btn btn-sm btn-info view-order-btn">View</button>
    </td>
    <td data-label="Buyer Details">
      <button class="btn btn-sm btn-primary view-buyer-btn">View</button>
    </td>
      <td data-label="Payment Status">${log.status || "N/A"}</td>
      <td>${actionButton}</td>
    `;
    logTable.appendChild(row);

    row.querySelector(".view-order-btn").addEventListener("click", () => {
      viewOrderDetails(log); // only order_id needed
    });

    row.querySelector(".view-buyer-btn").addEventListener("click", () => {
      viewBuyerDetails(log); // pass full log object
    });
  });
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

// View buyer details
function viewBuyerDetails(data) {
  console.log("functiontriggered"); // Log the data for debugging
  const modal = document.getElementById("buyerModal");
  const content = document.getElementById("buyerDetailsContent");

  content.innerHTML = `
          <div class="buyer-detail">
            <div class="detail-icon">
              <i class="fas fa-user"></i>
            </div>
            <div class="detail-content">
              <h4>Name</h4>
              <p>${data.first_name} ${data.last_name}</p>
            </div>
          </div>
          <div class="buyer-detail">
            <div class="detail-icon">
              <i class="fas fa-phone"></i>
            </div>
            <div class="detail-content">
              <h4>Contact Number</h4>
              <p>${data.phone}</p>
            </div>
          </div>
          <div class="buyer-detail">
            <div class="detail-icon">
              <i class="fas fa-map-marker-alt"></i>
            </div>
            <div class="detail-content">
              <h4>Address</h4>
              <p>${data.address}</p>
            </div>
          </div>
          <div class="buyer-detail">
            <div class="detail-icon">
              <i class="fas fa-city"></i>
            </div>
            <div class="detail-content">
              <h4>City</h4>
              <p>${data.city}</p>
              <h4>Postal Code</h4>
              <p>${data.postcode}</p>
            </div>
          </div>
        `;

  modal.style.display = "block";
  document.body.style.overflow = "hidden"; // Prevent scrolling when modal is open
}

// View order details in a modal
function viewOrderDetails(item) {
  const modal = document.getElementById("orderDetailsModal");
  const orderItemsContainer = document.getElementById("orderDetailsContent");

  // Fill in order items
  orderItemsContainer.innerHTML = `
                  <div class="order-item">
                    <p><strong>Product:</strong> ${item.product_name}</p>
                    <p><strong>Quantity:</strong> ${item.quantity}</p>
                    <p><strong>Unit Price:</strong> ${item.price}</p>
                  </div>
                `;

  modal.style.display = "block";
  document.body.style.overflow = "hidden"; // Prevent scrolling when modal is open
}

// Close buyer modal
function closeBuyerModal() {
  const modal = document.getElementById("buyerModal");
  modal.style.display = "none";
  document.body.style.overflow = "auto"; // Re-enable scrolling
}

// Close order details modal
function closeOrderDetailsModal() {
  const modal = document.getElementById("orderDetailsModal");
  modal.style.display = "none";
  document.body.style.overflow = "auto"; // Re-enable scrolling
}

// Close modal when clicking outside
window.onclick = function (event) {
  const buyerModal = document.getElementById("buyerModal");
  const orderDetailsModal = document.getElementById("orderDetailsModal");

  if (event.target === buyerModal) {
    closeBuyerModal();
  } else if (event.target === orderDetailsModal) {
    closeOrderDetailsModal();
  }
};
