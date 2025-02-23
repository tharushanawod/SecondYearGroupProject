<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Table with Pagination</title>
  <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/OrdersManagement.css">
  <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
  <style>
    /* Popup styles */
    .popup-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: none;
      justify-content: center;
      align-items: center;
      z-index: 1000;
    }

    .popup {
      background: white;
      padding: 20px;
      border-radius: 5px;
      width: 300px;
      text-align: center;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
    }

    .popup button {
      margin: 10px;
      padding: 10px 20px;
      font-size: 16px;
      cursor: pointer;
    }

    .popup button.cancel {
      background-color: #e74c3c;
      color: white;
    }

    .popup button.confirm {
      background-color: #2ecc71;
      color: white;
    }
  </style>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?> 

  <div class="table-container">
  <h1>Orders</h1>
    <table id="bidsTable">
      <thead>
        <tr>
          <th>Bid ID</th>
          <th>Your Bid</th>
          <th>Current Highest Bid</th>
          <th>Remaining Time</th>
          <th>Quantity (kg)</th>
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

  <!-- Confirmation Popup -->
  <div class="popup-overlay" id="popupOverlay">
    <div class="popup">
      <h3>Are you sure you want to cancel this bid?</h3>
      <button class="confirm" id="confirmCancel">Yes, Cancel</button>
      <button class="cancel" id="closePopup">No, Keep Bid</button>
    </div>
  </div>

<script>
  const URLROOT = "<?php echo URLROOT; ?>";
  const USERID = "<?php echo $_SESSION['user_id']; ?>";

  const bidsTable = document.querySelector("#bidsTable tbody");
  const prevBtn = document.getElementById("prevBtn");
  const nextBtn = document.getElementById("nextBtn");
  const pageInfo = document.getElementById("pageInfo");

  let currentPage = 1;
  const rowsPerPage = 10;
  let bids = []; // This will store all the fetched bids

  // Popup elements
  const popupOverlay = document.getElementById("popupOverlay");
  const closePopup = document.getElementById("closePopup");
  const confirmCancel = document.getElementById("confirmCancel");

  let cancelBidId = null; // Store the bid ID to be canceled

  // Fetch all bids from the controller
  function fetchBids() {
    fetch(`${URLROOT}/BuyerController/getAllActiveBidsForBuyer/${USERID}`)
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        bids = data; // Store all bids in the array
        renderTable(); // Initial table render
        updatePagination();
      })
      .catch((error) => console.log("Error fetching bids:", error));
  }

  // Render table rows for bids based on current page
  function renderTable() {
    const start = (currentPage - 1) * rowsPerPage;
    const end = start + rowsPerPage;
    const paginatedBids = bids.slice(start, end);

    bidsTable.innerHTML = ""; // Clear the existing table

    paginatedBids.forEach((bid) => {
      const row = document.createElement("tr");
      const targetDate = new Date(`${bid.closing_date}`); // Set the target date and time

      row.innerHTML = `
        <td data-label="Bid ID">${bid.bid_id}</td>
        <td data-label="Product">${bid.bid_amount}</td>
        <td data-label="Buyer">${bid.highest_bid}</td>
        <td data-label="Unit Price (Rs)">
        <span id="countdown">${startCountdown(targetDate, bid.bid_id)}</span>
        </td>
        <td data-label="Quantity">${bid.quantity}</td>
        <td data-label="Actions">
        ${bid.payment_status === 'Pending' ? `
          <button onclick="cancelBid(${bid.bid_id})" class="action-btn cancel">Cancel Bid</button>
          <button onclick="adjustBid(${bid.bid_id})" class="action-btn confirm">Adjust Bid</button>
        ` : ''}
        </td>
      `;

      bidsTable.appendChild(row);
    });
  }

  // Update pagination info (current page and total pages)
  function updatePagination() {
    const totalPages = Math.ceil(bids.length / rowsPerPage);
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
    const totalPages = Math.ceil(bids.length / rowsPerPage);
    if (currentPage < totalPages) {
      currentPage++;
      renderTable();
      updatePagination();
    }
  });

  // Initial fetch and render
  fetchBids();

  // Calculate remaining time for the countdown
  function calculateRemainingTime(targetDate) {
    const now = new Date();
    const timeDifference = targetDate - now;

    // If the target date is in the past, return "Time is up!"
    if (timeDifference <= 0) {
        return "Time is up!";
    }

    const days = Math.floor(timeDifference / (1000 * 60 * 60 * 24)); // Days
    const hours = Math.floor((timeDifference % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60)); // Hours
    const minutes = Math.floor((timeDifference % (1000 * 60 * 60)) / (1000 * 60)); // Minutes
    const seconds = Math.floor((timeDifference % (1000 * 60)) / 1000); // Seconds

    return `${days}d ${hours}h ${minutes}m ${seconds}s`;
  }

  // Start countdown function for each bid
  function startCountdown(targetDate, bidId) {
    console.log("Starting countdown for bid ID:", bidId);
  const countdownElement = document.getElementById("countdown"); // Unique countdown element for each row
  console.log(countdownElement);

  if (countdownElement) { // Ensure the element exists before updating
    // Update the countdown every second
    const interval = setInterval(() => {
      const remainingTime = calculateRemainingTime(targetDate);

      // Display the remaining time
      countdownElement.innerHTML = remainingTime;

      // Stop the countdown when time is up
      if (remainingTime === "Time is up!") {
        clearInterval(interval);
      }
    }, 1000); // Update every second
  } else {
    console.log(`Countdown element for bid ID ${bidId} not found.`);
  }
}


  // Show confirmation popup when cancel bid button is clicked
  function cancelBid(bidId) {
    cancelBidId = bidId;
    popupOverlay.style.display = "flex"; // Show the popup
  }

  // Close the popup without canceling the bid
  closePopup.addEventListener("click", () => {
    popupOverlay.style.display = "none"; // Hide the popup
  });

  // Confirm canceling the bid
  confirmCancel.addEventListener("click", () => {
    fetch(`${URLROOT}/BuyerController/CancelBid/${cancelBidId}`)
      .then((response) => response.json())
      .then((data) => {
        console.log(data);
        fetchBids(); // Fetch bids again to update the table
      })
      .catch((error) => console.log("Error canceling bid:", error));
    popupOverlay.style.display = "none";
  });
</script>
</body>
</html>
