// Open Hire Modal
function openHireModal(workerName) {
    document.getElementById("hireModal").style.display = "flex";
    document.getElementById("workerName").textContent = `Worker: ${workerName}`;
}

// Open Rating Modal
function openRatingModal(workerName) {
    document.getElementById("ratingModal").style.display = "flex";
    document.getElementById("ratingWorkerName").textContent = `Worker: ${workerName}`;
}

// Close Modal
function closeModal(modalId) {
    document.getElementById(modalId).style.display = "none";
}

// Handle Rating
let rating = 0;
function rateWorker(stars) {
    rating = stars;
    const starsList = document.querySelectorAll('.star-rating span');
    starsList.forEach((star, index) => {
        star.style.color = index < stars ? '#FFD700' : '#CCCCCC';
    });
}

// Submit Hire
function submitHire() {
    alert("Worker hired for task!");
    closeModal('hireModal');
}

//Cencel Hire
function cancelHire() {
    closeModal('hireModal');
}

// Submit Rating
function submitRating() {
    const feedback = document.getElementById('feedback').value;
    alert(`Rating: ${rating} stars\nFeedback: ${feedback}`);
    closeModal('ratingModal');
}

// Cancel Rating
function cancelRating() {
    closeModal('ratingModal');
}
