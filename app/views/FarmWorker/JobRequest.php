<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Farmworker - Job Requests</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/FarmWorker/JobRequest.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="main-content">
        <h1>Pending Job Requests</h1>

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
                    <a href="<?php echo URLROOT.'/WorkerController/ViewRequest/'.$request->job_id; ?>">
                        <button class="btn btn-view">
                            <i class="fas fa-eye"></i> View
                        </button>
                    </a>
                
                </td>
    </tr>
    <?php endforeach; ?>
    <?php else: ?>
    <tr>
        <td colspan="4" style="text-align: center; padding: 30px;">
            <p style="color: #64748b;">No job requests available.</p>
        </td>
    </tr>
    <?php endif; ?>
            </tbody>
        </table>
       
    </div>
</body>
</html>
