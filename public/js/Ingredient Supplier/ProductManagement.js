function showModal(modalId, product = null) {
    const modal = document.getElementById(modalId);
    modal.style.display = "block";

    if (product) {
        if (modalId === 'updateProductModal') {
            document.getElementById('updateProductId').value = product.product_id;
            document.getElementById('updateProductName').value = product.product_name;
            document.getElementById('updateCategory').value = product.category;
            document.getElementById('updatePrice').value = product.price;
            document.getElementById('updateStock').value = product.stock;
            document.getElementById('updateDescription').value = product.description;
            document.getElementById('updateProductExistingImage').value = product.image;
            document.getElementById('updateProductImage').src = URLROOT + '/uploads/' + product.image;
        } else if (modalId === 'deleteProductModal') {
            document.getElementById('deleteProductId').value = product.product_id;
            document.getElementById('deleteProductName').innerText = product.product_name;
            document.getElementById('deleteProductCategory').innerText = product.category;
            document.getElementById('deleteProductPrice').innerText = product.price;
            document.getElementById('deleteProductStock').innerText = product.stock;
            document.getElementById('deleteProductDescription').innerText = product.description;
            document.getElementById('deleteProductImage').src = URLROOT + '/uploads/' + product.image;
        }
    }
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = "none";
}

// Close the modal when the user clicks anywhere outside of it
window.onclick = function(event) {
    const modals = document.getElementsByClassName('modal');
    for (let i = 0; i < modals.length; i++) {
        if (event.target == modals[i]) {
            modals[i].style.display = "none";
        }
    }
}