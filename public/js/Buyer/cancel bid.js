document.addEventListener('DOMContentLoaded', function() {
    const reasonSelect = document.getElementById('reason');
    const otherReasonTextArea = document.getElementById('other-reason');
    const cancelBidButton = document.getElementById('cancel-bid-button');
    const adjustBidButton = document.getElementById('adjust-bid-button');
    const feedbackMessage = document.getElementById('feedback-message');

    // Function to get URL parameters
    function getQueryParams() {
        const params = new URLSearchParams(window.location.search);
        return {
            product: params.get('product'),
            bid: params.get('bid'),
            buyer: params.get('buyer')
        };
    }

    // Function to display product information
    function displayProductInfo() {
        const { product, bid, buyer } = getQueryParams();
        const descriptionDiv = document.getElementById('product-description');
        descriptionDiv.innerHTML = `
            <h2>${product}</h2>
            <p>Current Bid: LKR ${bid}</p>
            <p>Buyer: ${buyer}</p>
        `;
    }

    // Show or hide the "Other" text area based on the selected reason
    reasonSelect.addEventListener('change', function() {
        if (this.value === 'other') {
            otherReasonTextArea.style.display = 'block';
        } else {
            otherReasonTextArea.style.display = 'none';
        }
    });

    // Handle Cancel Bid button click
    cancelBidButton.addEventListener('click', function() {
        // You can add additional validation or logic here
        feedbackMessage.innerText = 'Your bid has been successfully canceled.';
        feedbackMessage.className = 'feedback-message success';
        feedbackMessage.style.display = 'block';
    });

    // Handle Adjust Bid button click
    adjustBidButton.addEventListener('click', function() {
        feedbackMessage.innerText = 'Redirecting to adjust your bid...';
        feedbackMessage.className = 'feedback-message success';
        feedbackMessage.style.display = 'block';
        // Redirect to the adjust bid page (replace with actual URL)
        setTimeout(() => window.location.href = 'bid products.html', 2000);
    });

    // Display product information on page load
    displayProductInfo();
});