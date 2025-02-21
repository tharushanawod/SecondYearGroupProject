<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/components/Notification.css">
    <title>Notifications</title>
    <style>
        *{
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
          
        }
        .notification-container {
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            padding: 24px;
            width: 90%;
            margin-left: 250px;
        }
        .notification-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 2px solid #e0e0e0;
        }
        .notification-header h2 {
            color: #2e8b57;
            font-size: 24px;
            margin: 0;
        }
        .notification-count {
            background: #2e8b57;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 14px;
        }
        .notification-table {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0;
        }
        .notification-table th {
            background-color: #f5f5f5;
            color: #333;
            font-weight: 600;
            text-transform: uppercase;
            font-size: 14px;
            padding: 16px;
            text-align: left;
            border-bottom: 2px solid #e0e0e0;
        }
        .notification-table td {
            padding: 16px;
            border-bottom: 1px solid #e0e0e0;
        }
        .notification-table tr:hover {
            background-color: #f8fff8;
        }
        .notification-row {
            transition: background-color 0.2s ease;
        }
        .notification-row.unread {
            background-color: #f0fff0;
        }
        .mark-read-btn {
            background-color: #2e8b57;
            color: white;
            border: none;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.2s ease;
        }
        .mark-read-btn:hover {
            background-color: #246c44;
        }
        .notification-time {
            color: #666;
            font-size: 14px;
        }
        .no-notifications {
            text-align: center;
            padding: 40px;
            color: #666;
            font-style: italic;
        }
    </style>
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
    </script>

    <script>

// Main functionality
function fetchNotifications() {
    fetch(`${URLROOT}/BuyerController/getNotifications`)
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
                    <button class="mark-read-btn" onclick="markAsRead(${notification.id})">
                        Mark as Read
                    </button>
                `}
            </td>
        </tr>
    `).join('');
}

function markAsRead(id) {
    fetch(`${URLROOT}/BuyerController/markNotificationAsRead/${id}`, {
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
