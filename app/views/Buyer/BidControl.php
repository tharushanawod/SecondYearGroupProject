<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Order Table with Pagination</title>
  <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/BidControl.css">
  <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
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
    const targetDate = new Date(bid.closing_date); // Closing date of the bid
    const currentDate = new Date(); // Current date and time

    // Calculate the remaining time in milliseconds
    const remainingTime = targetDate - currentDate;

    // If the remaining time is less than or equal to zero, the auction has ended
    let remainingTimeText = 'Auction Ended';
    if (remainingTime > 0) {
      // Calculate days, hours, minutes, and seconds
      const days = Math.floor(remainingTime / (1000 * 60 * 60 * 24));
      const hours = Math.floor((remainingTime % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
      const minutes = Math.floor((remainingTime % (1000 * 60 * 60)) / (1000 * 60));
      const seconds = Math.floor((remainingTime % (1000 * 60)) / 1000);

      remainingTimeText = `${days}d ${hours}h ${minutes}m ${seconds}s`;
    }

    const row = document.createElement("tr");
    row.innerHTML = `
      <td data-label="Bid ID">${bid.bid_id}</td>
      <td data-label="Your Bid">${bid.bid_amount}</td>
      <td data-label="Current Highest Bid">${bid.highest_bid}</td>
      <td data-label="Remaining Time">
        <span>${remainingTimeText}</span>
      </td>
      <td data-label="Quantity (kg)">${bid.quantity}</td>
      <td data-label="Actions">
        ${bid.payment_status === 'Pending' ? `
          <button onclick="cancelBid(${bid.bid_id})" class="action-btn cancel">Cancel Bid</button>
          <button onclick="adjustBid(${bid.product_id})" class="action-btn confirm">Adjust Bid</button>
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

  // Show confirmation popup when cancel bid button is clicked
  function cancelBid(bidId) {
    cancelBidId = bidId;
    popupOverlay.style.display = "flex"; // Show the popup
  }

  function adjustBid(product_id) {
    window.location.href = `${URLROOT}/BuyerController/PlaceBid/${product_id}`;
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
