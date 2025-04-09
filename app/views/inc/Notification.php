<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/Notification.css">
    <title>Notifications</title>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="notification-container">
        <div class="notification-header">
            <h2>Notifications</h2>
            <span class="notification-count" id="notification-count"></span>
        </div>

        <table class="notification-table">
            <thead>
                <tr>
                    <th>Message</th>
                    <th>Time</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="notification-tbody">
                <!-- Notifications will be loaded here dynamically -->
            </tbody>
        </table>
        
        <div class="no-notifications" id="no-notifications" style="display: none;">
            No new notifications
        </div>
    </div>
    <script>
    const URLROOT = '<?php echo URLROOT; ?>';
    const buyer_id = <?php echo $_SESSION['user_id']; ?>;
    </script>

    <script>

// Main functionality
function fetchNotifications() {
    fetch(`${URLROOT}/BuyerController/getNotifications/${buyer_id}`)
        .then(response => response.json())
        .then(notifications => {
            displayNotifications(notifications);
        })
        .catch(error => console.error('Error:', error));
}

function displayNotifications(notifications) {
    const tbody = document.getElementById('notification-tbody');
    const noNotifications = document.getElementById('no-notifications');
    const countElement = document.getElementById('notification-count');
    
    // Count unread notifications
    const unreadCount = notifications.filter(n => !n.is_read).length;
    
    // Update notification count
    countElement.textContent = unreadCount ? `${unreadCount} unread` : '';
    countElement.style.display = unreadCount ? 'inline-block' : 'none';

    // Show message if no notifications
    if (!notifications.length) {
        tbody.innerHTML = '';
        noNotifications.style.display = 'block';
        return;
    }

    // Hide "no notifications" message and show notifications
    noNotifications.style.display = 'none';
    tbody.innerHTML = notifications.map(notification => `
        <tr class="notification-row ${notification.is_read ? '' : 'unread'}">
            <td>${safeHtml(notification.message)}</td>
            <td class="notification-time">${formatDate(notification.created_at)}</td>
            <td>
                ${notification.is_read ? '' : `
                 <button class="mark-read-btn" onclick="markAsRead(${notification.id}, ${buyer_id})">
                        Mark as Read
                    </button>
                `}
            </td>
        </tr>
    `).join('');
}

function markAsRead(id, buyer_id) {
    fetch(`${URLROOT}/BuyerController/markNotificationAsRead/${id}/${buyer_id}`, {
        method: 'POST'
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) fetchNotifications();
    })
    .catch(error => console.error('Error:', error));
}

// Utility functions
function safeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
}

function formatDate(dateString) {
    return new Date(dateString).toLocaleString('en-US', {
        month: 'short',
        day: 'numeric',
        year: 'numeric',
        hour: 'numeric',
        minute: 'numeric',
        hour12: true
    });
}

// Initialize
fetchNotifications();
setInterval(fetchNotifications, 2000);

    </script>
</body>
</html>
