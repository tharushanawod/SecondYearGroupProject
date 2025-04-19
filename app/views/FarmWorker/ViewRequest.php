<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Request Details</title>
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/FarmWorker/ViewRequest.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
</head>
<body>
    <?php require APPROOT . '/views/inc/sidebar.php'; ?>
  
    <div class="container">
        <div class="details-card">
            <div class="section-title">
                <i class="fas fa-info-circle"></i>
                <span>Job Information</span>
            </div>
            <div class="details-grid">
                <div class="detail-item">
                    <span class="detail-label">Job ID</span>
                    <span class="detail-value"><i class="fas fa-hashtag"></i><?php echo $data->job_id; ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Job Type</span>
                    <span class="detail-value"><i class="fas fa-briefcase"></i><?php echo $data->job_type; ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Work Duration</span>
                    <span class="detail-value"><i class="fas fa-clock"></i><?php echo $data->work_duration; ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Start Date</span>
                    <span class="detail-value"><i class="fas fa-calendar-alt"></i><?php echo $data->start_date; ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">End Date</span>
                    <span class="detail-value"><i class="fas fa-calendar-alt"></i><?php echo $data->end_date; ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Location</span>
                    <span class="detail-value"><i class="fas fa-map-marker-alt"></i><?php echo $data->location; ?></span>
                </div>
            </div>
        </div>

        <div class="details-card">
            <div class="section-title">
                <i class="fas fa-tools"></i>
                <span>Requirements</span>
            </div>
            <div class="details-grid">
                <div class="detail-item">
                    <span class="detail-label">Required Skills</span>
                    <span class="detail-value"><i class="fas fa-check-circle"></i><?php echo $data->skills; ?></span>
                </div>
            </div>
        </div>

        <div class="details-card">
            <div class="section-title">
                <i class="fas fa-home"></i>
                <span>Facilities</span>
            </div>
            <div class="details-grid">
                <div class="detail-item">
                    <span class="detail-label">Accommodation</span>
                    <span class="detail-value"><i class="fas fa-bed"></i><?php echo $data->accommodation; ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label">Food</span>
                    <span class="detail-value"><i class="fas fa-utensils"></i><?php echo $data->food; ?></span>
                </div>
            </div>
        </div>

        <div class="buttons">
            <a href="<?php echo URLROOT.'/WorkerController/AcceptJob/'.$data->job_id; ?>">
                <button class="btn accept-btn">
                    <i class="fas fa-check"></i> Accept Job
                </button>
            </a>
            <a href="<?php echo URLROOT.'/WorkerController/RejectJob/'.$data->job_id; ?>">
                <button class="btn reject-btn">
                    <i class="fas fa-times"></i> Reject Job
                </button>
            </a>
            <div class="back-button">
            <a href="<?php echo URLROOT.'/WorkerController/JobRequest'; ?>">
                <button class="btn back-btn">
                    <i class="fas fa-arrow-left"></i> Back to Requests
                </button>
            </a>
        </div>
        </div>

      
    </div>

    <script>
        function acceptRequest(job_id) {
            if(confirm('Are you sure you want to accept this job?')) {
                window.location.href = '<?php echo URLROOT; ?>/WorkerController/AcceptJob/' + job_id;
            }
        }

        function rejectRequest(job_id) {
            if(confirm('Are you sure you want to reject this job?')) {
                window.location.href = '<?php echo URLROOT; ?>/WorkerController/RejectJob/' + job_id;
            }
        }
    </script>
</body>
</html>
