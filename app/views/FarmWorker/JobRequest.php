<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmworker - Job Requests</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/FarmWorker/JobRequest.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        body {
            background-color: #f5f5f5;
        }

        .main-content {
            margin-left: 250px; /* Space for sidebar */
            padding: 20px;
        }

        h1 {
            color: #2c3e50;
            margin-bottom: 20px;
            font-size: 24px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }

        th, td {
            padding: 15px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #f2f2f2;
        }

        .profile-icon {
            width: 50px;
            height: 50px;
            background-color: #ddd;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .profile-icon img {
            width: 30px;
            height: 30px;
        }

        .farmer-name {
            font-weight: bold;
            color: #2c3e50;
        }

        .request-time {
            color: #7f8c8d;
            font-size: 14px;
        }

        .action-buttons {
            display: flex;
            gap: 10px;
        }

        .btn {
            padding: 8px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 14px;
            transition: background-color 0.3s;
        }

        .btn-view {
            background-color: #3498db;
            color: white;
        }

        .btn:hover {
            opacity: 0.9;
        }
    </style>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="main-content">
        <h1>Job Requests</h1>

        <table>
            <thead>
            <tr>
                <th>Profile</th>
                <th>Farmer Name</th>
                <th>Request Time</th>
                <th>Actions</th>
            </tr>
            </thead>
            <tbody>
            <?php if(!empty($data['jobRequests'])): ?>
            <?php foreach ($data['jobRequests'] as $request) : ?>
            <tr>
                <td>
                <div class="profile-icon">
                    <img src="<?php echo URLROOT.'/'.$request->file_path; ?>" alt="profile icon">
                </div>
                </td>
                <td class="farmer-name"><?php echo $request->name; ?></td>
                <td class="request-time"><?php echo $request->created_at; ?></td>
                <td class="action-buttons">
                    <a href="<?php echo URLROOT.'/WorkerController/ViewRequest/'.$request->job_id; ?>"><button class="btn btn-view">View</button></a>
                
                </td>
    </tr>
    <?php endforeach; ?>
    <?php else: ?>
    <tr>
        <td colspan="4"><p>No job requests available.</p></td>
    </tr>
    <?php endif; ?>
            </tbody>
        </table>
       
    </div>
</body>
</html>
