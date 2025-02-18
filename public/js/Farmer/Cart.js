document.addEventListener('DOMContentLoaded', () => {
    const quantityInput = document.getElementById('quantity');
    if (quantityInput) {
        quantityInput.addEventListener('change', () => {
            const maxStock = parseInt(document.getElementById('maxStock').value);
            const value = parseInt(quantityInput.value);
            
            if (value < 1) {
                quantityInput.value = 1;
                alert('Quantity cannot be less than 1');
            } else if (value > maxStock) {
                quantityInput.value = maxStock;
                alert(`Maximum available quantity is ${maxStock}`);
            }
        });
    }
});