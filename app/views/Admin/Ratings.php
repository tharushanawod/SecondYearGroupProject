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
            <!-- Product Rating Example -->
            <div class="rating-card">
                <div class="rating-header">
                    <span class="rating-type product-rating">Product Rating</span>
                    <span class="rating-meta">Submitted: 2 hours ago</span>
                </div>
                <h4>Organic Tomatoes</h4>
                <div class="rating-stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star-half-alt"></i>
                </div>
                <p class="rating-content">
                    "Excellent quality tomatoes, very fresh and flavorful. Would definitely buy again!"
                </p>
                <div class="rating-actions">
                    <button class="btn btn-approve">Approve</button>
                    <button class="btn btn-reject">Reject</button>
                </div>
            </div>

            <!-- Farm Worker Rating Example -->
            <div class="rating-card">
                <div class="rating-header">
                    <span class="rating-type worker-rating">Farm Worker Rating</span>
                    <span class="rating-meta">Submitted: 4 hours ago</span>
                </div>
                <h4>John Smith - Farm Worker</h4>
                <div class="rating-stars">
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="fas fa-star"></i>
                    <i class="far fa-star"></i>
                </div>
                <p class="rating-content">
                    "Very professional and hardworking. Excellent knowledge of organic farming practices."
                </p>
                <div class="rating-actions">
                    <button class="btn btn-approve">Approve</button>
                    <button class="btn btn-reject">Reject</button>
                </div>
            </div>
        </div>
    </div>
</body>

</html>