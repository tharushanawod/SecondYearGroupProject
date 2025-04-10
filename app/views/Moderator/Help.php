<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Requests</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Moderator/Help.css">
</head>
<body>
    <?php require 'sidebar.php'; ?>
    
    <div class="help-container">
        <h1>Help Requests</h1>
        
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
        <?php endif; ?>
    </div>
</body>
</html>