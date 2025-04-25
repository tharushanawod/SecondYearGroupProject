<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Process Refund</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Admin/Refund.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet" />
</head>

<body>
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="container">
        <h1>Process Refund Request</h1>
        
        <div class="info-card">
            <h3><i class="fas fa-info-circle"></i> Refund Information</h3>
            <p>Before processing a refund, please verify all transaction details and ensure that the refund request complies with company policies.</p>
        </div>

        <?php if(isset($data['error_message'])): ?>
        <div class="error-message">
            <?php echo $data['error_message']; ?>
        </div>
        <?php endif; ?>
        
        <?php if(isset($data['success_message'])): ?>
        <div class="success-message">
            <?php echo $data['success_message']; ?>
        </div>
        <?php endif; ?>
        
        <form action="<?php echo URLROOT;?>/AdminController/RefundOfIngredients/<?php echo $data['order_id']?>/<?php echo $data['product_id']?>" method="post" id="refund-form">
            <div class="form-group">
           
            
            <div class="form-group">
            <input type="text" id="order_id" name="order_id" required 
            value="<?php echo isset($data['order_id']) ? $data['order_id'] : ''; ?>" readonly>
            </div>

            <input type="text" id="product_id" name="product_id" required 
    value="<?php echo isset($data['product_id']) ? $data['product_id'] : ''; ?>" readonly>
            </div>
            
            <div class="form-group">        
         <input type="number" id="refund_amount" name="refund_amount" step="0.01" required 
             value="<?php echo isset($data['refund_amount']) ? $data['refund_amount'] : ''; ?>" readonly>
            </div>


            <div class="form-group">
                <label for="refund_reason">Refund Reason:</label>
                <select id="refund_reason" name="refund_reason" required>
                    <option value="" disabled selected>Select a reason</option>
                    <option value="damaged_product" >Damaged Product</option>
                    <option value="wrong_item" >Wrong Item Received</option>
                    <option value="quality_issue" >Quality Issue</option>
                    <option value="late_delivery" >Late Delivery</option>
                    <option value="customer_changed_mind">Customer Changed Mind</option>
                    <option value="other">Other</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="admin_notes">Admin Notes:</label>
                <textarea id="admin_notes" name="admin_notes"></textarea>
            </div>
            
            <div class="button-group">
                <button type="submit" id="submit-btn" class="btn primary-btn">Process Refund</button>
                <a href="<?php echo URLROOT;?>/AdminController/dashboard" class="btn secondary-btn">Cancel</a>
            </div>
        </form>
    </div>
    
    <!-- Confirmation Modal -->
    <div id="confirmation-modal" class="modal">
        <div class="modal-content">
            <h2><i class="fas fa-exclamation-triangle"></i> Confirm Refund</h2>
            <p>Are you sure you want to process this refund? This action cannot be undone.</p>
            <div class="modal-buttons">
                <button id="confirm-refund" class="btn primary-btn">Yes, Process Refund</button>
                <button id="cancel-refund" class="btn secondary-btn">Cancel</button>
            </div>
        </div>
    </div>
    
    <script>
        // document.addEventListener('DOMContentLoaded', function() {
        //     const form = document.getElementById('refund-form');
        //     const submitBtn = document.getElementById('submit-btn');
        //     const modal = document.getElementById('confirmation-modal');
        //     const confirmBtn = document.getElementById('confirm-refund');
        //     const cancelBtn = document.getElementById('cancel-refund');
        //     const reasonSelect = document.getElementById('refund_reason');
        //     const otherReasonContainer = document.getElementById('other_reason_container');
            
        //     // Show/hide "Other" reason text area
        //     reasonSelect.addEventListener('change', function() {
        //         if (this.value === 'other') {
        //             otherReasonContainer.style.display = 'block';
        //         } else {
        //             otherReasonContainer.style.display = 'none';
        //         }
        //     });
            
        //     // Initialize other reason field if needed
        //     if (reasonSelect.value === 'other') {
        //         otherReasonContainer.style.display = 'block';
        //     }
            
        //     // Show confirmation modal on form submit
        //     form.addEventListener('submit', function(e) {
        //         e.preventDefault();
        //         modal.style.display = 'flex';
        //     });
            
        //     // Process form if confirmed
        //     confirmBtn.addEventListener('click', function() {
        //         form.submit();
        //     });
            
        //     // Close modal if canceled
        //     cancelBtn.addEventListener('click', function() {
        //         modal.style.display = 'none';
        //     });
            
        //     // Close modal if clicked outside
        //     window.addEventListener('click', function(e) {
        //         if (e.target === modal) {
        //             modal.style.display = 'none';
        //         }
        //     });
        // // });
    </script>
</body>

</html> 