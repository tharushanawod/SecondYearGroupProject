<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pending Requests</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/PendingRequests.css">
</head>

<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?> 
<div class="main-container">
<h1>Pending Requests</h1>

    <table>
        <thead>
            <tr>
                <th>Request ID</th>
                <th>Farm Worker</th>
                <th>Status</th>
                <th>Contact</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($data as $request) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($request->job_id); ?></td>
                    <td><?php echo htmlspecialchars($request->worker_name); ?></td>
                    <td><?php echo htmlspecialchars($request->status); ?></td>
                    <td><button onclick="contactWorker('<?php echo htmlspecialchars($request->worker_name); ?>')">Contact</button></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
   
</div>
  

    <script>
        function contactWorker(workerName) {
            alert('Contacting ' + workerName);
            // Implement the actual contact logic here
        }
    </script>
</body>

</html>