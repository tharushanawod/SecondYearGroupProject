document.addEventListener('DOMContentLoaded', () => {
    const form = document.getElementById('addToCartForm');
    const messageDiv = document.getElementById('messageDiv');
    const cartCount = document.querySelector('.cart-count');
    const addToCartBtn = document.querySelector('.add-to-cart-btn');
    const quantityInput = document.getElementById('quantity');
    const maxStockElement = document.getElementById('maxStock');
    const maxStock = maxStockElement ? parseInt(maxStockElement.value) : 0;

    // Remove duplicate event listeners
    if (form) {
        form.addEventListener('submit', (e) => {
            e.preventDefault(); // Prevent form submission
        });
    }

    if (quantityInput) {
        quantityInput.addEventListener('change', (e) => {
            validateQuantity(e.target, maxStock, messageDiv);
        });
    }

    // Single event listener for add to cart button
    if (addToCartBtn) {
        addToCartBtn.addEventListener('click', (e) => {
            e.preventDefault();
            addToCartFromProductPage();
        });
    }
});

function addToCartFromProductPage() {
    const productId = document.querySelector('input[name="product_id"]');
    const quantity = document.querySelector('input[name="quantity"]');
    const maxStock = document.querySelector('input[name="max_stock"]');

    if (!productId || !quantity || !maxStock) {
        console.error('Required form elements not found');
        alert('Error: Required form elements not found');
        return;
    }

    const data = {
        product_id: productId.value,
        quantity: parseInt(quantity.value)
    };

    // Show loading state
    const addToCartBtn = document.querySelector('.add-to-cart-btn');
    if (addToCartBtn) {
        setLoadingState(addToCartBtn, true);
    }

    fetch(`${URLROOT}/CartController/addToCart`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify(data)
    })
    .then(response => response.json())
    .then(result => {
        if (result.success) {
            // Update cart count in all cart count elements
            const cartCounts = document.querySelectorAll('.cart-count');
            cartCounts.forEach(element => {
                element.textContent = result.cartCount;
            });
            alert('Product added to cart successfully!');
        } else {
            alert(result.message || 'Error adding product to cart');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding product to cart');
    })
    .finally(() => {
        if (addToCartBtn) {
            setLoadingState(addToCartBtn, false);
        }
    });
}

function addToCart() {
    const formData = new FormData(document.getElementById('addToCartForm'));
    
    fetch(`${URLROOT}/CartController/addToCart`, {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        if(data.success) {
            // Update cart count
            document.querySelector('.cart-count').textContent = data.cartCount;
            // Show success message
            alert('Product added to cart successfully!');
        } else {
            alert(data.message || 'Error adding product to cart');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error adding product to cart');
    });
}

function showMessage(messageDiv, message, type) {
    messageDiv.textContent = message;
    messageDiv.className = `message-div ${type}`;
    messageDiv.style.display = 'block';
    
    setTimeout(() => {
        messageDiv.style.display = 'none';
    }, 3000);
}

function setLoadingState(button, isLoading) {
    button.disabled = isLoading;
    button.style.opacity = isLoading ? '0.7' : '1';
}

function validateQuantity(input, maxStock, messageDiv) {
    const value = parseInt(input.value);
    
    if (value < 1) {
        input.value = 1;
    } else if (value > maxStock) {
        input.value = maxStock;
        showMessage(messageDiv, `Maximum available quantity is ${maxStock}`, 'error');
    }
}

async function handleAddToCart(form, cartCount, addToCartBtn, messageDiv, maxStock) {
    setLoadingState(addToCartBtn, true);

    const formData = new FormData(form);
    const quantity = parseInt(formData.get('quantity'));

    if (quantity < 1 || quantity > maxStock) {
        showMessage(messageDiv, 'Please select a valid quantity', 'error');
        setLoadingState(addToCartBtn, false);
        return;
    }

    try {
        const response = await fetch(`${URLROOT}/CartController/addToCart`, {
            method: 'POST',
            body: formData
        });

        const data = await response.json();

        if (data.success) {
            if (cartCount) {
                cartCount.textContent = data.cartCount;
            }
            showMessage(messageDiv, 'Item added to cart successfully!', 'success');
        } else {
            showMessage(messageDiv, data.message || 'Failed to add item to cart. Please try again.', 'error');
        }
    } catch (error) {
        console.error('Error:', error);
        showMessage(messageDiv, 'An error occurred. Please try again.', 'error');
    } finally {
        setLoadingState(addToCartBtn, false);
    }
}