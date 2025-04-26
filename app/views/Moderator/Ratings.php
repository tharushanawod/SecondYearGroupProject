<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ratings Approval</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="<?php echo URLROOT; ?>/css/Admin/Ratings.css">
</head>

<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>

    <div class="main-content">
        <h2>Ratings Approval</h2>

        <div class="filter-section">
            <div class="filter-options">
                <select class="filter-select">
                    <option value="all">All Ratings</option>
                    <option value="products">Product Ratings</option>
                    <option value="workers">Farm Worker Ratings</option>
                </select>
                <select class="filter-select">
                    <option value="all">All Status</option>
                    <option value="pending">Pending</option>
                    <option value="approved">Approved</option>
                    <option value="rejected">Rejected</option>
                </select>
            </div>
        </div>

        <div class="ratings-list">
            <?php if (!empty($data['ratings'])) : ?>
            <?php foreach ($data['ratings'] as $rating) : ?>
                <div class="rating-card">
                <div class="rating-header">
                    <span class="rating-type 
                    <?php if (is_null($rating->buyer_id)){
                        echo 'worker-rating'; 
                    } else { 
                        echo 'product-rating'; 
                    } ?>">
                    <?php if (is_null($rating->buyer_id)){
                        echo 'worker-rating'; 
                    } else { 
                        echo 'product-rating'; 
                    } ?>
                    </span>
                    <span class="rating-meta">Submitted: <?php echo $rating->created_at; ?></span>
                </div>
                <h4><?php echo htmlspecialchars($rating->title); ?></h4>
                <div class="rating-stars">
                    <?php for ($i = 1; $i <= 5; $i++) : ?>
                    <?php if ($i <= $rating->rating) : ?>
                        <i class="fas fa-star"></i>
                    <?php elseif ($i - 0.5 <= $rating->rating) : ?>
                        <i class="fas fa-star-half-alt"></i>
                    <?php else : ?>
                        <i class="far fa-star"></i>
                    <?php endif; ?>
                    <?php endfor; ?>
                </div>
                <p class="rating-content">
                    "<?php echo htmlspecialchars($rating->review_text); ?>"
                </p>
                <div class="rating-actions">
                <a href="<?php echo is_null($rating->buyer_id) ? URLROOT . '/ModeratorController/ApproveWorkerReview/' . $rating->id : URLROOT . '/ModeratorController/ApproveProductReview/' . $rating->id; ?>">
                <button class="btn btn-approve" >Approve</button>
                </a>
                <a href="<?php echo is_null($rating->buyer_id) ? URLROOT . '/ModeratorController/RejectWorkerReview/' . $rating->id : URLROOT . '/ModeratorController/RejectProductReview/' . $rating->id; ?>">
                <button class="btn btn-reject" ?>Reject</button>
                </a>
                    
                </div>
                </div>
            <?php endforeach; ?>
            <?php else : ?>
            <p>No ratings found.</p>
            <?php endif; ?>
        </div>
    </div>
</body>

</html>