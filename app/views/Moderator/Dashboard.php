<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Moderator Dashboard</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Moderator/Dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha512-DTOQO9RWCH3ppGqcWaEA1BIZOC6xxalwEsw9c2QQeAIftl+Vegovlnee1c9QX4TctnWMn13TZye+giMm8e2LwA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    <?php require 'sidebar.php'; ?>
    
    <div class="dashboard-container">
        <h1>Moderator Dashboard</h1>

        <!-- Overview Stats -->
        <div class="stats-container">
            <div class="stat-box">
                <h3><i class="fas fa-list-alt"></i> Total Requests</h3>
                <p><?php echo $data['total_requests']; ?></p>
            </div>
            <div class="stat-box">
                <h3><i class="fas fa-clock"></i> Pending</h3>
                <p><?php echo $data['pending_requests']; ?></p>
            </div>
            <div class="stat-box">
                <h3><i class="fas fa-reply"></i> Responded</h3>
                <p><?php echo $data['responded_requests']; ?></p>
            </div>
        </div>

        <!-- Category Insights -->
        <h2>Categories</h2>
        <div class="category-boxes">
            <?php foreach ($data['categories'] as $category => $pendingCount): ?>
                <a href="<?php echo URLROOT; ?>/ModeratorController/Help?category=<?php echo urlencode($category); ?>" class="category-box">
                    <div class="category-header">
                        <h3><?php echo ucfirst($category); ?></h3>
                        <span class="pending-count"><?php echo $pendingCount; ?> Pending</span>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>

        <!-- Recent Pending Requests Table -->
        <h2>Recent Pending Requests</h2>
        <div class="requests-table-container">
            <?php if (!empty($data['recent_requests'])): ?>
                <table class="requests-table">
                    <thead>
                        <tr>
                            <th>Category</th>
                            <th>User</th>
                            <th>Created</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($data['recent_requests'] as $request): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($request->category); ?></td>
                                <td><?php echo htmlspecialchars($request->user_role); ?></td>
                                <td><?php echo htmlspecialchars($request->created_at); ?></td>
                                <td>
                                    <a href="<?php echo URLROOT; ?>/ModeratorController/Help?category=<?php echo urlencode($request->category); ?>" class="action-link">View & Reply</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php else: ?>
                <p>No pending requests at this time.</p>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>