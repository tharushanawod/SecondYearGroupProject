<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmer Wallet</title>
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet" />
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/Farmer/Wallet.css">
</head>

<body>
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>

    <div class="wallet-container">
        <div class="wallet-header">
            <h1>Wallet</h1>
            <p>Manage your earnings and withdrawals</p>
        </div>

        <div class="wallet-summary">
            <div class="balance-info">
                <div class="balance-icon">
                    <i class="fas fa-wallet"></i>
                </div>
                <div class="balance-details">
                    <h2>Available Balance</h2>
                    <div class="balance-amount">Rs.
                    <?php echo number_format($data['wallet']->balance, 2); ?>
                    </div>
                </div>
            </div>
            <button class="withdraw-btn" id="withdrawBtn" <?php echo $data['wallet']->balance <=0 ? 'disabled' : '' ;
                ?>>
                <i class="fas fa-money-bill-wave"></i> Withdraw Funds
            </button>
        </div>

        <div class="transactions-section">
            <div class="section-header">
                <h2>Recent Transactions For Current Withdrawable balance</h2>
            </div>
            <table class="transaction-table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Date</th>
                        <th>Amount</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach($data['transactions'] as $transaction): ?>
                    <tr class="transaction-row">
                        <td class="order-id">#
                            <?php echo $transaction->order_id; ?>
                        </td>
                        <td>
                            <?php echo date('M d, Y', strtotime($transaction->request_date)); ?>
                        </td>
                        <td class="amount">Rs.
                            <?php echo number_format($transaction->paid_amount); ?>
                        </td>
                        <td>
                            <span class="status">
                            <?php if ($transaction->withdraw_status == 'not_withdrawn'): ?>
    <p>Not withdrawn</p>
<?php endif; ?>

                            </span>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Withdrawal Modal -->
    <div class="withdrawal-modal" id="withdrawalModal">
        <div class="modal-content">
            <div class="modal-header">
                <h3>Withdraw Funds</h3>
                <button class="close-modal" onclick="closeModal()">&times;</button>
            </div>
            <form class="withdrawal-form" id="withdrawalForm" action="<?php echo URLROOT; ?>/FarmerController/processWithdrawal" method="POST">
                <div class="form-group">
                    <label for="amount">Amount to Withdraw</label>
                    <input type="number" id="amount" name="amount" max="<?php echo $data['wallet']->balance ?>"
                        min="1000" step="100" required>
                </div>

                <div class="form-group">
                    <label for="bankName">Bank Name</label>
                    <select id="bankName" name="bankName" required>
                        <option value="" disabled selected>Select a bank</option>
                        <option value="Bank of Ceylon">Bank of Ceylon</option>
                        <option value="People's Bank">People's Bank</option>
                        <option value="Commercial Bank">Commercial Bank</option>
                        <option value="Sampath Bank">Sampath Bank</option>
                        <option value="HNB">Hatton National Bank</option>
                        <option value="NTB">Nations Trust Bank</option>
                        <option value="NSB">National Savings Bank</option>
                        <option value="DFCC">DFCC Bank</option>
                            </select>
                <div class="form-group">
               
                    <label for="bankAccount">Bank Account Number</label>
                    <input type="text" id="bankAccount" name="bankAccount" required>
                </div>
                <button type="submit" class="submit-withdrawal">
                    <i class="fas fa-check"></i> Confirm Withdrawal
                </button>
            </form>
        </div>
    </div>
    <script>
        const URLROOT = "<?php echo URLROOT;?>";
    </script>
    <script>
     const modal = document.getElementById('withdrawalModal');
        const withdrawBtn = document.getElementById('withdrawBtn');

        withdrawBtn.addEventListener('click', () => {
            modal.style.display = 'block';
        });

        function closeModal() {
            modal.style.display = 'none';
        }

        // Close modal when clicking outside
        window.onclick = function (event) {
            if (event.target == modal) {
                closeModal();
            }
        }
    </script>
</body>

</html>