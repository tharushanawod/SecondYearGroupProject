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
    const user_id = <?php echo $_SESSION['user_id']; ?>;
    const user_role = '<?php echo $_SESSION['user_role']; ?>';
    // Determine the appropriate controller based on user role
    let controller;
    switch(user_role) {
        case 'farmworker':
            controller = 'WorkerController';
            break;
        case 'buyer':
            controller = 'BuyerController';
            break;
        case 'farmer':
            controller = 'FarmerController';
            break;
        case 'manufacturer':
            controller = 'ManufacturerController';
            break;
        case 'supplier':
            controller = 'SupplierController';
            break;
    }

    // Fetch notifications
    function fetchNotifications() {
        fetch(`${URLROOT}/${controller}/getNotifications/${user_id}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(notifications => {
                if (!Array.isArray(notifications)) {
                    console.error('Invalid notifications data:', notifications);
                    return;
                }
                displayNotifications(notifications);
            })
            .catch(error => {
                console.error('Error fetching notifications:', error);
                displayNotifications([]);
            });
    }

    // Display notifications
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
        tbody.innerHTML = notifications.map(notification => {
            const isHelpNotification = 'related_id' in notification && notification.related_id !== null;
            return `
                <tr class="notification-row ${notification.is_read ? '' : 'unread'}">
                    <td class="message-cell" 
                        ${isHelpNotification ? `onclick="markAsReadAndRedirect(${notification.id}, ${user_id}, ${isHelpNotification})"` : ''}>
                        ${safeHtml(notification.message)}
                    </td>
                    <td class="notification-time">${formatDate(notification.created_at)}</td>
                    <td>
                        ${notification.is_read ? '' : `
                            <button class="mark-read-btn" onclick="markAsRead(${notification.id}, ${user_id}, ${isHelpNotification}, event)">
                                Mark as Read
                            </button>
                        `}
                    </td>
                </tr>
            `;
        }).join('');
    }

    // Mark notification as read without redirecting
    function markAsRead(id, user_id, isHelpNotification, event) {
        event.stopPropagation(); // Prevent event bubbling to parent elements
        const endpoint = isHelpNotification 
            ? `${URLROOT}/${controller}/markHelpNotificationAsRead/${id}/${user_id}`
            : `${URLROOT}/${controller}/markNotificationAsRead/${id}/${user_id}`;
        
        fetch(endpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                fetchNotifications();
            } else {
                console.error('Failed to mark notification as read:', data.error);
                alert('Failed to mark notification as read. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error marking notification as read:', error);
            alert('An error occurred. Please try again.');
        });
    }

    // Mark notification as read and redirect to viewHelpResponse
    function markAsReadAndRedirect(id, user_id, isHelpNotification) {
        if (!isHelpNotification) return; 

        const endpoint = `${URLROOT}/${controller}/markHelpNotificationAsRead/${id}/${user_id}`;
        fetch(endpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' }
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                window.location.href = `${URLROOT}/${controller}/requestHelp/${id}`;
            } else {
                console.error('Failed to mark notification as read:', data.error);
                alert('Failed to mark notification as read. Please try again.');
            }
        })
        .catch(error => {
            console.error('Error marking notification as read:', error);
            alert('An error occurred. Please try again.');
        });
    }

    // Utility functions
    function safeHtml(str) {
        const div = document.createElement('div');
        div.textContent = str || '';
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