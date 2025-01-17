function showModal(modalId, product = null) {
    const modal = document.getElementById(modalId);
    if (product) {
        if (modalId === 'updateProductModal') {
            document.getElementById('updateProductId').value = product.id;
            document.getElementById('updateProductName').value = product.product_name;
            document.getElementById('updateCategory').value = product.category_id;
            document.getElementById('updatePrice').value = product.price;
            document.getElementById('updateStock').value = product.stock;
            document.getElementById('updateDescription').value = product.description;
            document.getElementById('updateProductExistingImage').value = product.image;
            document.getElementById('updateProductImage').src = `${URLROOT}/uploads/${product.image}`;
        } else if (modalId === 'deleteProductModal') {
            document.getElementById('deleteProductId').value = product.id;
            document.getElementById('deleteProductName').innerText = product.product_name;
            document.getElementById('deleteProductCategory').innerText = product.category_name;
            document.getElementById('deleteProductPrice').innerText = product.price;
            document.getElementById('deleteProductStock').innerText = product.stock;
            document.getElementById('deleteProductDescription').innerText = product.description;
            document.getElementById('deleteProductImage').src = `${URLROOT}/uploads/${product.image}`;
        }
    }
    modal.style.display = 'block';
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'none';
}

// Close modals when clicking outside of them
window.onclick = function(event) {
    const modals = document.getElementsByClassName('modal');
    for (let i = 0; i < modals.length; i++) {
        if (event.target == modals[i]) {
            modals[i].style.display = 'none';
        }
    }
}

function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        var reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById(previewId).src = e.target.result;
        }
        reader.readAsDataURL(input.files[0]);
    }
}