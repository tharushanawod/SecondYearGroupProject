<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Worker Profile</title>
    <link rel="stylesheet" href="<?php echo URLROOT;?>/css/Farmer/WorkerProfile.css">
    <link href="https://site-assets.fontawesome.com/releases/v6.7.2/css/all.css" rel="stylesheet"/>
    <style>
        .star-rating .star {
    cursor: pointer;
    font-size: 30px;
    color: grey;
}

.star-rating .star.selected {
    color: gold;
}

    </style>
</head>
<body>
<?php require APPROOT . '/views/inc/sidebar.php'; ?>
    <div class="profile-card">
        <div class="profile-header">
            <div class="profile-image">
                <img src="<?php echo URLROOT . '/' . $data->file_path;?>" alt="Profile Image">
            </div>
            <div class="profile-info">
                <h1><?php echo $data->name;?></h1>
                <p>Farm Worker</p>
                <div class="stats">
                    <div class="stat-box rating">
                        ★ 4.5
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
                    <div class="nav-arrow">←</div>
                    <div class="nav-arrow">→</div>
                </div>
            </div>
            
            <div class="review-card">
                <div class="reviewer">
                    <div class="reviewer-image">
                        <img src="/api/placeholder/40/40" alt="Reviewer">
                    </div>
                    <div class="reviewer-info">
                        <div class="reviewer-name">Jinny Oslin</div>
                        <div class="review-date">A day ago</div>
                    </div>
                    <div class="rating">★★★★★</div>
                </div>
                <div class="review-text">
                    Magna id sint irure in cillum esse nisi dolor laboris ullamco...
                </div>
            </div>

            <div class="add-review">
                <form action="<?php echo URLROOT.'/FarmerController/AddReview/'.$data->user_id?>" method="POST">
                <h3>Add Your Review</h3>
                <input class="review-input" name="review_text" placeholder="Share Your Experience" rows="4">
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
        const stars = document.querySelectorAll('.star-rating .star');
const reviewInput = document.querySelector('.review-input');
const submitButton = document.querySelector('.submit-review');
const ratingInput = document.getElementById('ratingInput');

let rating = 0;

// Handle star click event
stars.forEach((star, index) => {
    star.addEventListener('click', () => {
        rating = index + 1;
        ratingInput.value = rating; // Update the hidden input value
        updateStars();
    });
});

// Update star colors based on rating
function updateStars() {
    stars.forEach((star, index) => {
        if (index < rating) {
            star.classList.add('selected');
        } else {
            star.classList.remove('selected');
        }
    });
}


    </script>
</body>
</html>