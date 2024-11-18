// Function to filter products based on search input
function filterProducts() {
    const searchInput = document.getElementById('search').value.toLowerCase();
    const bidCards = document.querySelectorAll('.bid-card');

    bidCards.forEach(card => {
        const productName = card.querySelector('h3').textContent.toLowerCase();
        if (productName.includes(searchInput)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

// Add event listener to search button
document.getElementById('searchBtn').addEventListener('click', filterProducts);

// Add event listener to search input for real-time filtering
document.getElementById('search').addEventListener('keyup', filterProducts);

// Sample filtering function for the search bar
function filterProducts() {
    const searchInput = document.getElementById('search').value.toLowerCase();
    const bidCards = document.querySelectorAll('.bid-card');

    bidCards.forEach(card => {
        const productName = card.querySelector('h3').textContent.toLowerCase();
        if (productName.includes(searchInput)) {
            card.style.display = 'block';
        } else {
            card.style.display = 'none';
        }
    });
}

document.getElementById('filterBtn').addEventListener('click', () => {
    window.location.href = 'filter products.html';
});