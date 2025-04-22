<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Requests</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Moderator/Help.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
    
    <div class="help-container">
        <h1>Help Center</h1>
        
        <?php if (isset($_SESSION['reply_success'])): ?>
            <div class="success"><?php echo $_SESSION['reply_success']; unset($_SESSION['reply_success']); ?></div>
        <?php elseif (isset($_SESSION['reply_error'])): ?>
            <div class="error"><?php echo $_SESSION['reply_error']; unset($_SESSION['reply_error']); ?></div>
        <?php endif; ?>

        <?php if (isset($data['selected_category'])): ?>
            <!-- Requests View -->
            <h2><?php echo ucfirst($data['selected_category']); ?> Requests</h2>
            <a href="<?php echo URLROOT; ?>/ModeratorController/Help" class="back-link">Back to Categories</a>
            <div class="requests-list">
                <?php if (!empty($data['requests'])): ?>
                    <?php foreach ($data['requests'] as $request): ?>
                        <div class="request">
                            <p><strong>Subject:</strong> <?php echo htmlspecialchars($request->subject); ?></p>
                            <p><strong>Description:</strong> <?php echo htmlspecialchars($request->description); ?></p>
                            <p><strong>User ID:</strong> <?php echo htmlspecialchars($request->user_id); ?> (<?php echo htmlspecialchars($request->user_role); ?>)</p>
                            <p><strong>Created:</strong> <?php echo htmlspecialchars($request->created_at); ?></p>
                            <p><strong>Status:</strong> <?php echo htmlspecialchars($request->status); ?></p>
                            <?php if (!empty($request->attachment)): ?>
                                <p><strong>Attachment:</strong> 
                                    <?php
                                    $attachmentPath = trim($request->attachment, '/');
                                    $fullAttachmentUrl = URLROOT . '/uploads/' . htmlspecialchars($attachmentPath);
                                    $fileName = basename($attachmentPath);
                                    ?>
                                    <a href="<?php echo $fullAttachmentUrl; ?>" target="_blank" class="attachment-link">
                                        View <?php echo htmlspecialchars($fileName); ?>
                                    </a>
                                </p>
                            <?php endif; ?>
                            <?php if ($request->status !== 'responded' && $request->status !== 'resolved' && $request->status !== 'closed'): ?>
                                <form method="POST" action="<?php echo URLROOT; ?>/ModeratorController/Help?category=<?php echo urlencode($data['selected_category']); ?>">
                                    <input type="hidden" name="request_id" value="<?php echo $request->id; ?>">
                                    <textarea name="reply" placeholder="Enter your reply" required></textarea>
                                    <button type="submit" class="submit-btn">Send Reply</button>
                                </form>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No requests found in this category.</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <!-- Category Overview -->
            <div class="category-boxes">
                <?php if (!empty($data['categories'])): ?>
                    <?php foreach ($data['categories'] as $category => $pendingCount): ?>
                        <a href="<?php echo URLROOT; ?>/ModeratorController/Help?category=<?php echo urlencode($category); ?>" class="category-box">
                            <div class="category-header">
                                <h3><?php echo ucfirst($category); ?> Issues</h3>
                                <span class="pending-count"><?php echo $pendingCount; ?> Pending</span>
                            </div>
                            <p>Click to view requests</p>
                        </a>
                    <?php endforeach; ?>
                <?php else: ?>
                    <p>No help requests found.</p>
                <?php endif; ?>
            </div>

            <!-- Transaction Logs Section -->
            <h2>Transaction & Order Logs</h2>
            <p class="section-desc">Monitor and resolve transaction-related issues across the platform</p>
            
            <div class="log-cards">
                <!-- Account Log Card -->
                <div class="log-card account-log">
                    <div class="log-card-header">
                        <div class="log-icon">
                            <i class="fas fa-user-shield"></i>
                        </div>
                        <div class="log-info">
                            <h3>Account Log</h3>
                            <span class="log-count">24 new entries</span>
                        </div>
                    </div>
                    <div class="log-content">
                        
                        <a href="<?php echo URLROOT;?>/ModeratorController/AccountLog" class="view-all-link">View All Account Logs <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Buyer Transaction Log Card -->
                <div class="log-card buyer-log">
                    <div class="log-card-header">
                        <div class="log-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="log-info">
                            <h3>Buyer Transaction Log</h3>
                            <span class="log-count">12 pending issues</span>
                        </div>
                    </div>
                    <div class="log-content">
                    
                        <a href="<?php echo URLROOT;?>/ModeratorController/BuyerTransactionLog" class="view-all-link">View All Transaction Logs <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <!-- Farmer Transaction Log Card -->
                <div class="log-card farmer-log">
                    <div class="log-card-header">
                        <div class="log-icon">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <div class="log-info">
                            <h3>Farmer Transaction Log</h3>
                            <span class="log-count">8 issues to review</span>
                        </div>
                    </div>
                    <div class="log-content">
                       
                        <a href="<?php echo URLROOT;?>/ModeratorController/FarmerTransactionLog" class="view-all-link">View All Transaction Logs <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="log-card buyer-log">
                    <div class="log-card-header">
                        <div class="log-icon">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="log-info">
                            <h3>Buyer Order log</h3>
                            <span class="log-count">12 pending issues</span>
                        </div>
                    </div>
                    <div class="log-content">
                    
                        <a href="<?php echo URLROOT;?>/ModeratorController/BuyerOrderLog" class="view-all-link">View All Order Logs <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="log-card farmer-log">
                    <div class="log-card-header">
                        <div class="log-icon">
                            <i class="fas fa-seedling"></i>
                        </div>
                        <div class="log-info">
                            <h3>Farmer Order Log</h3>
                            <span class="log-count">8 issues to review</span>
                        </div>
                    </div>
                    <div class="log-content">
                       
                        <a href="<?php echo URLROOT;?>/ModeratorController/FarmerOrderLog" class="view-all-link">View All  Order Logs <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

</body>
</html>