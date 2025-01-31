<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Need support?</title>
  <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Buyer/pendingPayments.css">
  <style>
    /* Modal and Overlay Styles */
    .modal-overlay {
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.5);
        z-index: 999;
    }

    .modal {
        display: none;
        position: fixed;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        background: #f0fdf4;
        border: 2px solid #10b981;
        border-radius: 8px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        z-index: 1000;
        padding: 20px;
        width: 350px;
        text-align: center;
        color: #065f46;
    }

    .modal h3 {
        margin-bottom: 10px;
        color: #065f46;
    }

    .modal p {
        margin-bottom: 15px;
        font-size: 14px;
        color: #065f46;
    }

    .modal button {
        padding: 8px 16px;
        margin: 5px;
        font-size: 14px;
        color: #ffffff;
        background: #10b981;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    .modal button:hover {
        background: #047857;
    }

    .modal button:nth-child(2) {
        background: #f87171;
    }

    .modal button:nth-child(2):hover {
        background: #dc2626;
    }
  </style>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
<div class="payments">
    <h2 class="payments-header">Payments</h2>   
    <div class="marquee">
        <marquee behavior="scroll" direction="left">
            Current Advance Rate is 30% from the total amount.
        </marquee>
    </div>    

    <table>
        <thead>
            <tr>
                <td>Bid Id</td>
                <td>Bid Amount (LKR)</td>
                <td>Quantity (kg)</td>
                <td>Total (LKR)</td>
                <td>Advance (LKR)</td>
                <td>Action</td>
            </tr>
        </thead>

        <tbody>
            <?php
            // Sample data for demonstration
            $bids = [
                ['id' => 1, 'quantity' => 100],
                ['id' => 2, 'quantity' => 150],
                ['id' => 3, 'quantity' => 80],
                ['id' => 4, 'quantity' => 80],
                ['id' => 5, 'quantity' => 80],
                ['id' => 6, 'quantity' => 80]
            ];

            foreach ($bids as $bid) {
                $bidAmount = rand(98, 109); // Random bid amount
                $quantity = $bid['quantity'];
                $total = $bidAmount * $quantity; // Calculate total
                $advance = $total * 0.3; // Calculate advance
                echo "<tr>
                    <td>{$bid['id']}</td>
                    <td>LKR {$bidAmount}</td>
                    <td>{$quantity}kg</td>
                    <td>LKR {$total}</td>
                    <td>LKR " . number_format($advance, 2) . "</td>
                    <td>
                        <button class=\"paynow\" onclick=\"openPayNowModal({$bid['id']}, {$advance})\">Pay Now</button>
                        <button class=\"status\" onclick=\"openCancelModal({$bid['id']})\">Cancel</button>
                    </td>
                </tr>";
            }
            ?>
        </tbody>
    </table>
</div>

<!-- Modal for cancellation -->
<div class="modal-overlay" id="modal-overlay"></div>
<div class="modal" id="cancel-modal">
    <h3>Cancel Bid</h3>
    <p>Please select a reason for cancellation:</p>
    <select id="cancel-reason">
        <option value="High bid amount">High bid amount</option>
        <option value="Quantity mismatch">Quantity mismatch</option>
        <option value="Payment issues">Payment issues</option>
        <option value="Other">Other</option>
    </select>
    <br>
    <button onclick="submitCancel()">Confirm</button>
    <button onclick="closeCancelModal()">Close</button>
</div>

<!-- Modal for Pay Now -->
<div class="modal" id="pay-modal">
    <h3>Payment Details</h3>
    <p id="pay-advance"></p>
    <p id="pay-website-charge"></p>
    <p id="pay-total"></p>
    <p><small> 2% additional charge is applicable for Service.</small></p>
    <button onclick="closePayNowModal()">Confirm</button>
</div>

<script>
    let selectedBidId = null;

    // Cancel Modal Functions
    function openCancelModal(bidId) {
        selectedBidId = bidId;
        document.getElementById("modal-overlay").style.display = "block";
        document.getElementById("cancel-modal").style.display = "block";
    }

    function closeCancelModal() {
        document.getElementById("modal-overlay").style.display = "none";
        document.getElementById("cancel-modal").style.display = "none";
    }

    function submitCancel() {
        const reason = document.getElementById("cancel-reason").value;
        alert(`Bid ID ${selectedBidId} cancelled for reason: ${reason}`);
        closeCancelModal();
    }

    // Pay Now Modal Functions
    function openPayNowModal(bidId, advance) {
        const websiteCharge = (advance * 0.02).toFixed(2); // 2% website fee
        const totalPayment = (advance * 1.02).toFixed(2); // Total payment with website fee
        document.getElementById("pay-advance").textContent = `Advance: LKR ${advance.toFixed(2)}`;
        document.getElementById("pay-website-charge").textContent = `Service charge (2%): LKR ${websiteCharge}`;
        document.getElementById("pay-total").textContent = `Total Payment: LKR ${totalPayment}`;
        document.getElementById("modal-overlay").style.display = "block";
        document.getElementById("pay-modal").style.display = "block";
    }

    function closePayNowModal() {
        document.getElementById("modal-overlay").style.display = "none";
        document.getElementById("pay-modal").style.display = "none";
    }
</script>
</body>
</html>
