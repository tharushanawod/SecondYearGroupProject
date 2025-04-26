<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Need Support?</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Manufacturer/RequestHelp.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>
    
    <div class="help-container">
        <h1>Need Support?</h1>
        <p>Please select a category that best describes your issue</p>
        
        <?php if (isset($_SESSION['request_success'])): ?>
            <div class="success"><?php echo $_SESSION['request_success']; unset($_SESSION['request_success']); ?></div>
        <?php elseif (isset($_SESSION['request_error'])): ?>
            <div class="error"><?php echo $_SESSION['request_error']; unset($_SESSION['request_error']); ?></div>
        <?php endif; ?>

        <div class="category-boxes">
            <a href="<?php echo URLROOT;?>/WorkerController/showForm/payment" class="category-box payment-category">
                <i class="fas fa-money-bill-wave"></i>
                <h3>Payment Issues</h3>
                <p>Problems with payments, refunds, or billing</p>
            </a>
            
            <a href="<?php echo URLROOT;?>/WorkerController/showForm/system" class="category-box system-category">
                <i class="fas fa-cogs"></i>
                <h3>System Issues</h3>
                <p>Technical issues, bugs, or errors</p>
            </a>
            
            <a href="<?php echo URLROOT;?>/WorkerController/showForm/account" class="category-box account-category">
                <i class="fas fa-user"></i>
                <h3>Account Issues</h3>
                <p>Login problems, profile updates, or account settings</p>
            </a>
            
            <a href="<?php echo URLROOT;?>/WorkerController/showForm/other" class="category-box other-category">
                <i class="fas fa-question-circle"></i>
                <h3>Other Issues</h3>
                <p>Any other questions or concerns</p>
            </a>
        </div>

        <?php if (isset($data['category'])): ?>
            <div class="help-form">
                <h2><?php echo ucfirst($data['category']); ?> Issue</h2>
                <form action="<?php echo URLROOT; ?>/WorkerController/submitRequest" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="category" value="<?php echo $data['category']; ?>">
                    <div class="form-group">
                        <label for="<?php echo $data['category']; ?>-subject">Subject</label>
                        <input type="text" id="<?php echo $data['category']; ?>-subject" name="subject" required>
                    </div>
                    <div class="form-group">
                        <label for="<?php echo $data['category']; ?>-description">Description</label>
                        <textarea id="<?php echo $data['category']; ?>-description" name="description" rows="5" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="<?php echo $data['category']; ?>-attachment">Attachment (Optional)</label>
                        <input type="file" id="<?php echo $data['category']; ?>-attachment" name="attachment">
                    </div>
                    <div class="form-buttons">
                        <button type="submit" class="submit-btn">Submit Request</button>
                        <button type="button" class="cancel-btn" onclick="window.location.href='<?php echo URLROOT; ?>/WorkerController/requestHelp'">Cancel</button>
                    </div>
                </form>
            </div>
        <?php endif; ?>

        <div class="requests-section">
            <h2>Responses for Your Requests</h2>
            <?php if (empty($data['requests'])): ?>
                <p class="no-requests">No help requests submitted.</p>
            <?php else: ?>
                <div class="requests-grid">
                    <?php foreach ($data['requests'] as $request): ?>
                        <div class="request-card" data-notification-id="<?php echo $request->notification_id; ?>">
                            <div class="request-header">
                                <span class="request-id">ID: <?php echo htmlspecialchars($request->id); ?></span>
                                <span class="request-status <?php echo strtolower($request->status); ?>">
                                    <?php echo htmlspecialchars($request->status); ?>
                                </span>
                            </div>
                            <div class="request-body">
                                <h3><?php echo htmlspecialchars($request->subject); ?></h3>
                                <p class="category"><?php echo htmlspecialchars(ucfirst($request->category)); ?></p>
                                <p class="response">
                                    <?php echo $request->reply ? htmlspecialchars(substr($request->reply, 0, 100)) . '...' : 'No response yet'; ?>
                                </p>
                            </div>
                            <div class="request-footer">
                                <span class="submitted">
                                    Submitted: <?php echo date('M d, Y H:i', strtotime($request->created_at)); ?>
                                </span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>    
</body>
</html>