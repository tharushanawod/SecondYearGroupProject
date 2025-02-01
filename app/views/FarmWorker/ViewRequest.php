<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Request Details</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/FarmWorker/ViewRequest.css">
    <style>
        body {
            font-family: "Roboto", sans-serif;
            margin: 0;
            padding: 0;
        }
        .container {
            background-color: #fff;
            padding: 60px;
            border-radius: 10px;
            margin-left: 250px;
           
        }
        h1 {
            text-align: center;
            color: #333;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .buttons {
            display: flex;
            justify-content: space-between;
            margin-top: 20px;
        }
        .buttons button {
            padding: 10px 20px;
            font-size: 16px;
            cursor: pointer;
            border: none;
            border-radius: 5px;
            transition: background-color 0.3s ease;
        }
        .accept-btn {
            background-color: #28a745;
            color: white;
        }
        .accept-btn:hover {
            background-color: #218838;
        }
        .reject-btn {
            background-color: #dc3545;
            color: white;
        }
        .reject-btn:hover {
            background-color: #c82333;
        }
        .popup-message {
            display: none;
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.7);
            color: white;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
            z-index: 1000;
        }
    </style>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
  
<div class="container">
    <h1>Job Request Details</h1>
    <table>
        <tr>
            <th>Job ID</th>
            <td><?php echo $data->job_id; ?></td>
        </tr>
        <tr>
            <th>Job Type</th>
            <td><?php echo $data->job_type; ?></td>
        </tr>
        <tr>
            <th>Work Duration</th>
            <td><?php echo $data->work_duration; ?></td>
        </tr>
        <tr>
            <th>Start Date</th>
            <td><?php echo $data->start_date; ?></td>
        </tr>
        <tr>
            <th>End Date</th>
            <td><?php echo $data->end_date; ?></td>
        </tr>
        <tr>
            <th>Skills</th>
            <td><?php echo $data->skills; ?></td>
        </tr>
        <tr>
            <th>Location</th>
            <td><?php echo $data->location; ?></td>
        </tr>
        <tr>
            <th>Accommodation</th>
            <td><?php echo $data->accommodation; ?></td>
        </tr>
        <tr>
            <th>Food</th>
            <td><?php echo $data->food; ?></td>
        </tr>
    </table>
    <div class="buttons">
        <button class="accept-btn" onclick="acceptRequest(<?php echo $data->job_id; ?>)">Accept</button>
        <button class="reject-btn" onclick="rejectRequest(<?php echo $data->job_id; ?>)">Reject</button>
    </div>
</div>

<script>
function acceptRequest(job_id) {
    // Implement the accept request logic here
    alert('Request accepted for job ID: ' + job_id);
}

function rejectRequest(job_id) {
    // Implement the reject request logic here
    alert('Request rejected for job ID: ' + job_id);
}
</script>
</body>
</html>
