<?php require APPROOT . '/views/inc/header.php'; ?>

<h1>Notifications</h1>
<ul>
    <?php foreach ($data['notifications'] as $notification): ?>
        <li><?php echo $notification->message; ?> - <?php echo $notification->created_at; ?></li>
    <?php endforeach; ?>
</ul>

<?php require APPROOT . '/views/inc/footer.php'; ?>
