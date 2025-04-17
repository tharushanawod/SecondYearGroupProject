<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/FarmWorker/dashboard.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>

<div class="dashboard-container">
    <div class="welcome-section">
        <h1>Welcome back,
            <?php echo $data['user_name']; ?>!
        </h1>
        <p>Track your tasks and monitor your performance</p>
    </div>

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon tasks-icon">
                    <i class="fas fa-tasks"></i>
                </div>
                <div class="stat-info">
                    <h3>Active Tasks</h3>
                    <p>
                        <?php echo $data['active_tasks']; ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon completed-icon">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="stat-info">
                    <h3>Completed Today</h3>
                    <p>
                        <?php echo $data['completed_today']; ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon pending-icon">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="stat-info">
                    <h3>Pending Tasks</h3>
                    <p>
                        <?php echo $data['pending_tasks']; ?>
                    </p>
                </div>
            </div>
        </div>

        <div class="stat-card">
            <div class="stat-header">
                <div class="stat-icon rating-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="stat-info">
                    <h3>Overall Rating</h3>
                    <p>
                        <?php echo $data['overall_rating']; ?>/5
                    </p>
                </div>
            </div>
        </div>
    </div>

    <div class="recent-section">
        <div class="section-header">
            <h2>Recent Tasks</h2>
            <a href="<?php echo URLROOT; ?>/FarmWorkerController/tasks" class="view-all">
                View All <i class="fas fa-arrow-right"></i>
            </a>
        </div>

        <table class="recent-tasks">
            <thead>
                <tr>
                    <th>Task</th>
                    <th>Field</th>
                    <th>Assigned By</th>
                    <th>Due Date</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($data['recent_tasks'] as $task): ?>
                <tr>
                    <td>
                        <?php echo $task['task_name']; ?>
                    </td>
                    <td>
                        <?php echo $task['field_location']; ?>
                    </td>
                    <td>
                        <?php echo $task['assigned_by']; ?>
                    </td>
                    <td>
                        <?php echo date('M d, Y', strtotime($task['due_date'])); ?>
                    </td>
                    <td>
                        <span class="task-status status-<?php echo strtolower($task['status']); ?>">
                            <?php echo $task['status']; ?>
                        </span>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</div>
</body>
</html>