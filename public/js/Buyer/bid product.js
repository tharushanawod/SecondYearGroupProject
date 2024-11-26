
    document.getElementById('applyFilters').addEventListener('click', function() {
        const category = document.querySelector('select[name="category"]').value;
        const minQuantity = document.getElementById('minQuantity').value;
        const maxQuantity = document.getElementById('maxQuantity').value;

        document.querySelectorAll('.bid-card').forEach(card => {
            const cardCategory = card.getAttribute('data-category');
            const cardQuantity = parseInt(card.getAttribute('data-quantity'));

            if ((category === cardCategory || category === '') &&
                (minQuantity === '' || cardQuantity >= minQuantity) &&
                (maxQuantity === '' || cardQuantity <= maxQuantity)) {
                card.style.display = 'block';
            } else {
                card.style.display = 'none';
            }
        });
    });

    document.querySelectorAll('.action-btn').forEach(button => {
        button.addEventListener('click', function(event) {
            event.preventDefault();
            const product = this.getAttribute('data-product');
            const currentBid = this.getAttribute('data-current-bid');
            document.getElementById('modalProduct').innerText = 'Product: ' + product;
            document.getElementById('modalCurrentBid').innerText = 'Current Highest Bid: LKR ' + currentBid;
            document.getElementById('bidModal').style.display = 'block';
        });
    });

    function closeModal() {
        document.getElementById('bidModal').style.display = 'none';
    }

    function placeBid() {
        const newBid = document.getElementById('newBid').value;
        if (newBid) {
            alert('Your bid of ' + newBid + ' has been placed.');
            closeModal();
        } else {
            alert('Please enter a valid bid.');
        }
    }
