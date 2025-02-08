function showModal(modalId, product = null, URLROOT = '') {
    const modal = document.getElementById(modalId);
    if (product) {
        if (modalId === 'updateProductModal') {
            populateUpdateForm(product, URLROOT);
        } else if (modalId === 'deleteProductModal') {
            populateDeleteForm(product, URLROOT);
        }
    }
    modal.style.display = 'block';
}

function populateUpdateForm(product, URLROOT) {
    document.getElementById('updateProductId').value = product.product_id;
    document.getElementById('updateProductName').value = product.product_name;
    document.getElementById('updateCategory').value = product.category_id;
    document.getElementById('updatePrice').value = product.price;
    document.getElementById('updateStock').value = product.stock;
    document.getElementById('updateDescription').value = product.description;
    document.getElementById('updateProductExistingImage').value = product.image;
    document.getElementById('updateImagePreview').src = `${URLROOT}/uploads/${product.image}`;
    document.getElementById('updateImagePreview').style.display = 'block';
}

function populateDeleteForm(product, URLROOT) {
    document.getElementById('deleteProductId').value = product.product_id;
    document.getElementById('deleteProductName').innerText = product.product_name;
    document.getElementById('deleteProductCategory').innerText = product.category_name;
    document.getElementById('deleteProductPrice').innerText = product.price;
    document.getElementById('deleteProductStock').innerText = product.stock;
    document.getElementById('deleteProductImage').src = `${URLROOT}/uploads/${product.image}`;
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'none';
    resetForm(modalId);
}

function resetForm(modalId) {
    const form = document.querySelector(`#${modalId} form`);
    if (form) {
        form.reset();
        const preview = form.querySelector('.preview-image');
        if (preview) {
            preview.src = '';
            preview.style.display = 'none';
        }
    }
}

function previewImage(input, previewId) {
    const file = input.files[0];
    const preview = document.getElementById(previewId);
    const maxSize = 2 * 1024 * 1024; // 2MB

    if (file) {
        if (file.size > maxSize) {
            alert('File size must be less than 2MB');
            input.value = '';
            preview.src = '';
            return;
        }

        if (!file.type.match('image.*')) {
            alert('Please select an image file');
            input.value = '';
            preview.src = '';
            return;
        }

        const reader = new FileReader();
        reader.onload = (e) => {
            preview.src = e.target.result;
            preview.style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}

function validateForm(formId) {
    const form = document.getElementById(formId);
    const price = form.querySelector('[name="price"]');
    const stock = form.querySelector('[name="stock"]');
    const description = form.querySelector('[name="description"]');

    if (parseFloat(price.value) <= 0) {
        alert('Price must be greater than 0');
        return false;
    }

    if (parseInt(stock.value) < 0) {
        alert('Stock cannot be negative');
        return false;
    }

    if (description.value.length < 10) {
        alert('Description must be at least 10 characters');
        return false;
    }

    return true;
}

function filterProducts() {
    const input = document.querySelector('.search-box');
    const filter = input.value.toLowerCase();
    const rows = document.querySelectorAll('#productTable tbody tr');

    rows.forEach(row => {
        const productName = row.querySelector('td:nth-child(2)').textContent.toLowerCase();
        const category = row.querySelector('td:nth-child(3)').textContent.toLowerCase();
        row.style.display = productName.includes(filter) || category.includes(filter) ? '' : 'none';
    });
}

// Event Listeners
window.onclick = (event) => {
    if (event.target.classList.contains('modal')) {
        closeModal(event.target.id);
    }
};

document.addEventListener('DOMContentLoaded', () => {
    // Add form validation
    const forms = document.querySelectorAll('form');
    forms.forEach(form => {
        form.addEventListener('submit', (e) => {
            if (!validateForm(form.id)) {
                e.preventDefault();
            }
        });
    });

    // Add description character counter
    const descriptions = document.querySelectorAll('textarea[name="description"]');
    descriptions.forEach(desc => {
        desc.addEventListener('input', function() {
            const count = this.value.length;
            const maxLength = 500;
            const counter = this.nextElementSibling;
            if (counter) {
                counter.textContent = `${count}/${maxLength} characters`;
            }
        });
    });
});
