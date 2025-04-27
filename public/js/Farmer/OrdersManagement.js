const ordersTable = document.querySelector("#orderTable tbody");
const prevBtn = document.getElementById("prevBtn");
const nextBtn = document.getElementById("nextBtn");
const pageInfo = document.getElementById("pageInfo");

let currentPage = 1;
const rowsPerPage = 10;
let orders = []; // This will store all the fetched orders

// Render table rows for orders based on current page
// Reference to the search input field
const orderIdSearch = document.getElementById("orderIdSearch");

// Store the original orders (to reset search)
let allOrders = []; // This will store the unfiltered list of orders

// Fetch all orders from the controller
async function fetchOrders() {
  try {
    const response = await fetch(`${URLROOT}/FarmerController/getAllOrders/${USERID}`);
    const data = await response.json();
    allOrders = [...data]; // Store the original list of orders
    orders = [...data]; // Initialize the filtered list with all orders
    renderTable(); // Initial table render
    updatePagination();
  } catch (error) {
    console.log("Error fetching orders:", error);
  }
}

// Add an event listener for the search box
orderIdSearch.addEventListener("input", () => {
  const searchTerm = orderIdSearch.value.trim().toLowerCase();

  // Filter the orders based on the search term
  if (searchTerm === "") {
    // If the search box is empty, reset to the original list
    orders = [...allOrders];
  } else {
    // Filter orders where the order ID matches the search term
    orders = allOrders.filter(
      (order) =>
        order.quantity.toString().toLowerCase().includes(searchTerm) 
        
    );
  }

  // Reset pagination to the first page after filtering
  currentPage = 1;

  // Re-render the table and update pagination
  renderTable();
  updatePagination();
});

// Render table rows for orders based on current page
function renderTable() {
  const start = (currentPage - 1) * rowsPerPage;
  const end = start + rowsPerPage;
  const paginatedOrders = orders.slice(start, end);

  ordersTable.innerHTML = ""; // Clear the existing table

  paginatedOrders.forEach((order) => {
    const row = document.createElement("tr");
    const totalAmount = order.bid_price * order.quantity;
    const paymenttoreceive = totalAmount * 0.8; // Assuming paid amount is 30% as advance order
    row.innerHTML = `
      <td data-label="Order ID">${order.order_id}</td>
       <td data-label="Quantity">${order.quantity}</td>
        <td data-label="Unit Price (Rs)">${order.bid_price}</td>
         <td data-label="order To Receive (Rs)">${paymenttoreceive.toFixed(
           2
         )}</td>
   <td data-label="Buyers's Details">
                <button onclick="viewBuyerDetails(${
                  order.buyer_id
                })" class="details-btn">
                    View Details
                </button>
            </td>
      <td data-label="Status">${order.payment_status}</td>
       <td data-label="Farmer Confirmation">${getBuyerConfirmationStatus(
         order
       )}</td>
            <td data-label="Your Confirmation">${getFarmerConfirmationStatus(
              order
            )}</td>
    `;
    ordersTable.appendChild(row);
  });
}

function getFarmerConfirmationStatus(order) {
  // Replace with your actual data structure
  if (order.farmer_confirmed === 1) {
    return `<span class="confirmed"><i class="fa-solid fa-check"></i> Confirmed</span>`;
  } else if (order.farmer_confirmed === 0 && order.payment_status === "paid") {
    return `<button onclick="confirmOrder(${order.order_id})" class="confirm-btn"><i class="fa-solid fa-square-check"></i>  Confirm</button>`;
  } else {
    return `<span class="rejected"><i class="fa-solid fa-xmark"></i> Wait till payment</span>`;
  }
}

// Helper function to display buyer confirmation status
function getBuyerConfirmationStatus(order) {
  // Replace with your actual data structure
  if (order.buyer_confirmed === 1) {
    return `<span class="confirmed"><i class="fa-solid fa-check"></i> Confirmed</span>`;
  } else {
    return `<span class="pending"><i class="fa-solid fa-clock"></i> Pending</span>`;
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

async function confirmOrder(orderId) {
  try {
    const response = await fetch(`${URLROOT}/FarmerController/confirmOrder/${orderId}`, {
      method: "POST",
    });
    const data = await response.json();
    fetchOrders(); // Refresh data after confirmation
  } catch (error) {
    console.error("Error confirming payment:", error);
  }
}


async function viewBuyerDetails(buyerId) {
  console.log("Fetching buyer details for ID:", buyerId);
  
  try {
    const response = await fetch(`${URLROOT}/FarmerController/getBuyerDetails/${buyerId}`);
    const data = await response.json();
    
    const modal = document.getElementById("buyerModal");
    const content = document.getElementById("buyerDetailsContent");
    
    content.innerHTML = `
                <div class="buyer-detail">
                    <div class="detail-icon">
                        <i class="fas fa-user"></i>
                    </div>
                    <div class="detail-content">
                        <h4>Name</h4>
                        <p>${data.name}</p>
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
            `;

    console.log("Buyer details:", content); // Log the fetched data for debugging
    modal.style.display = "block";
    document.body.style.overflow = "hidden"; // Prevent scrolling when modal is open
  } catch (error) {
    console.error("Error fetching buyer details:", error);
  }
}

function closeBuyerModal() {
  const modal = document.getElementById("buyerModal");
  modal.style.display = "none";
  document.body.style.overflow = "auto"; // Re-enable scrolling
}

// Close modal when clicking outside
window.onclick = function (event) {
  const modal = document.getElementById("buyerModal");
  if (event.target == modal) {
    closeBuyerModal();
  }
};

// Initial fetch and render
fetchOrders();
