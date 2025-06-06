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
        <h1>Accepted Jobs</h1>

        <table>
            <thead>
            <tr>
                <th>Profile</th>
                <th>Farmer Name</th>
                <th>Starting From</th>
                <th>Job Descption</th>
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
                <td class="request-time"><?php 
                $start_date= new DateTime($request->start_date);
                $current_date= new DateTime(date('Y-m-d'));
                $interval= $start_date->diff($current_date);
                $days= $interval->days;

                if($days==0){
                    echo "Today";
                }else if($days===1){
                    echo "Tomorrow";
                }else{
                    echo "after".$days."after days ";
                }
                
                
                ?></td>
                <td class="action-buttons">
                    <a href="<?php echo URLROOT.'/WorkerController/ViewAcceptedJob/'.$request->job_id; ?>"><button class="btn btn-view">Click To View</button></a>
                
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
