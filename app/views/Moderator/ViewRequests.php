<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Help Requests</title>
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

        <?php if (empty($data['requests'])): ?>
            <p>No pending requests.</p>
        <?php else: ?>
            <?php foreach ($data['requests'] as $request): ?>
                <div class="help-form">
                    <h2><?php echo ucfirst($request->category); ?> Issue</h2>
                    <p><strong>Subject:</strong> <?php echo $request->subject; ?></p>
                    <p><strong>Description:</strong> <?php echo $request->description; ?></p>
                    <?php if ($request->attachment): ?>
                        <p><strong>Attachment:</strong> <a href="<?php echo URLROOT . '/uploads/' . $request->attachment; ?>" target="_blank"><?php echo $request->attachment; ?></a></p>
                    <?php endif; ?>
                    <form action="<?php echo URLROOT; ?>/ModeratorController/replyRequest" method="POST">
                        <input type="hidden" name="request_id" value="<?php echo $request->id; ?>">
                        <input type="hidden" name="user_id" value="<?php echo $request->user_id; ?>">
                        <div class="form-group">
                            <label for="reply">Reply</label>
                            <textarea id="reply" name="reply" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="submit-btn">Send Reply</button>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</body>
</html>