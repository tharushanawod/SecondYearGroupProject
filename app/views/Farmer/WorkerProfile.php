<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Profile</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/WorkerProfile.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>

</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-image">
                <img src=" <?php echo empty($data->file_path) ? URLROOT . '/images/profile.jpg' : URLROOT . '/' . htmlspecialchars($data->file_path);?> " alt="Profile Image">

            </div>
            <div class="profile-info">
                <h1><?php echo $data->name;?></h1>
                <p>Farm Worker</p>
                <div class="stats">
                    <div class="stat-box rating">
                        ★ <?php 
                        $roundedRating = round($data->average_rating, 1);
                        echo $roundedRating;?>
                    </div>
                    <div class="stat-box hires">
                        1000+ Hires
                    </div>
                </div>
            </div>
        </div>

        <div class="about">
            <p><?php echo htmlspecialchars($data->bio);?></p>
        </div>

        <div class="reviews-section">
            <div class="reviews-header-container">
                <h2 class="reviews-header">Reviews</h2>
                <div class="review-navigation">
                    <div class="nav-arrow" id="prev-btn">←</div>
                    <div class="nav-arrow" id="next-btn">→</div>
                </div>
            </div>
            
            <div class="reviews-container"></div>


            <div class="add-review">
                <form action="<?php echo URLROOT.'/FarmerController/AddReview/'.$data->user_id?>" method="POST">
                <h3>Add Your Review</h3>
                <textarea class="review-input" name="review_text" placeholder="Share Your Experience" rows="4" ></textarea>
                <div class="star-rating">
                    <input type="hidden" name="rating" value="0" id="ratingInput">
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                    <span class="star">★</span>
                </div>
                <button class="submit-review" type="submit">Add Review</button>
                </form>

            </div>
        </div>
    </div>
    <script>
        const URLROOT = "<?php echo URLROOT;?>";
        const USER_ID = "<?php echo $data->user_id;?>";
    </script>
    <script src="<?php echo URLROOT?>/js/Farmer/WorkerProfile.js"></script>
</body>
</html>