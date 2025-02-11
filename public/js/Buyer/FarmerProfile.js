let currentReviewIndex = 0;
let reviews = [];

const reviewsContainer = document.querySelector('.reviews-container');
const prevBtn = document.getElementById('prev-btn');
const nextBtn = document.getElementById('next-btn');

async function loadReviews() {
    try {
        const response = await fetch(`${URLROOT}/BuyerController/fetchReviews/${USER_ID}`);
        reviews = await response.json();

        renderReviews();
        updateNavigationButtons();
    } catch (error) {
        console.error('Error loading reviews:', error);
    }
}

function renderReviews() {
    reviewsContainer.innerHTML = '';

    if (reviews.length === 0) {
        reviewsContainer.innerHTML = '<p>No reviews yet.</p>';
        return;
    }

    // Calculate the range of reviews to display (two at a time)
    const startIndex = currentReviewIndex;
    const endIndex = Math.min(startIndex + 2, reviews.length);

    // Create a row to hold two review cards
    const reviewRow = document.createElement('div');
    reviewRow.classList.add('reviews-row');

    // Render up to two reviews
    for (let i = startIndex; i < endIndex; i++) {
        const review = reviews[i];
        const reviewCard = document.createElement('div');
        reviewCard.classList.add('review-card');

    // Create the review card and HTML structure first
reviewCard.innerHTML = `
    <div class="reviewer">
        <div class="reviewer-image" id="reviewer-image-container"></div> <!-- Empty container for image -->
        <div class="reviewer-info">
            <div class="reviewer-name">${review.name}</div>
            <div class="review-date">${review.created_at}</div>
        </div>
        <div class="rating">${'★'.repeat(review.rating)}</div>
    </div>
    <div class="review-text">
        ${review.review_text}
    </div>
`;

// Now, create the image element and append it to the container
const reviewerImageContainer = reviewCard.querySelector('#reviewer-image-container');
const img = document.createElement("img");
img.src = `${URLROOT}/${review.file_path}`;
img.alt = "Reviewer";
reviewerImageContainer.appendChild(img);

// Finally, append the review card to the review row
reviewRow.appendChild(reviewCard);

    }

    reviewsContainer.appendChild(reviewRow);
}

function updateNavigationButtons() {
    // Disable previous button if at the first review
    prevBtn.classList.toggle('disabled', currentReviewIndex === 0);

    // Disable next button if showing the last review(s)
    nextBtn.classList.toggle('disabled', currentReviewIndex + 2 >= reviews.length);
}

// Event listeners for navigation buttons
prevBtn.addEventListener('click', () => {
    if (currentReviewIndex > 0) {
        currentReviewIndex--;
        renderReviews();
        updateNavigationButtons();
    }
});

nextBtn.addEventListener('click', () => {
    if (currentReviewIndex + 2 < reviews.length) {
        currentReviewIndex++;
        renderReviews();
        updateNavigationButtons();
    }
});

// Load reviews when the page loads
loadReviews();


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
