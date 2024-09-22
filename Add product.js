document.addEventListener('DOMContentLoaded', () => {
    const addProductBtn = document.getElementById('addProductBtn');
    const productFormModal = document.getElementById('productFormModal');
    const closeModal = document.getElementsByClassName('close')[0];
    const cancelBtn = document.getElementById('cancelBtn');
    const productForm = document.getElementById('productForm');
    const imageUpload = document.getElementById('imageUpload');
    const imagePreview = document.getElementById('imagePreview');
    const productTable = document.getElementById('productTable').getElementsByTagName('tbody')[0];

    // Open Modal
    addProductBtn.addEventListener('click', () => {
        productFormModal.style.display = 'block';
    });

    // Close Modal
    closeModal.addEventListener('click', () => {
        productFormModal.style.display = 'none';
        productForm.reset();
        imagePreview.style.display = 'none';
    });

    cancelBtn.addEventListener('click', () => {
        productFormModal.style.display = 'none';
        productForm.reset();
        imagePreview.style.display = 'none';
    });

    // Image Preview
    imageUpload.addEventListener('change', (e) => {
        const file = e.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (event) => {
                imagePreview.src = event.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    // Save Product
    productForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const productName = document.getElementById('productName').value;
        const category = document.getElementById('category').value;
        const price = document.getElementById('price').value;
        const stock = document.getElementById('stock').value;

        const newRow = productTable.insertRow();
        newRow.innerHTML = `
            <td>${productName}</td>
            <td>${category}</td>
            <td>LKR ${price}</td>
            <td>${stock}</td>
            <td class="actions">
                <button class="edit">Edit</button>
                <button class="delete">Delete</button>
            </td>
        `;

        // Reset form and close modal
        productForm.reset();
        imagePreview.style.display = 'none';
        productFormModal.style.display = 'none';

        // Add event listeners to new icons
        const editBtn = newRow.querySelector('.edit');
        const deleteBtn = newRow.querySelector('.delete');

        editBtn.addEventListener('click', () => {
            // Populate form with current product data
            document.getElementById('productName').value = productName;
            document.getElementById('category').value = category;
            document.getElementById('price').value = price.replace('LKR ', '');
            document.getElementById('stock').value = stock;

            // Change form title and button text
            document.getElementById('formTitle').textContent = 'Edit Product';
            document.getElementById('saveBtn').textContent = 'Update';

            // Show the modal
            productFormModal.style.display = 'block';

            // Update the product when form is submitted
            const updateProduct = (e) => {
                e.preventDefault();

                // Update row with new values
                newRow.cells[0].textContent = document.getElementById('productName').value;
                newRow.cells[1].textContent = document.getElementById('category').value;
                newRow.cells[2].textContent = `LKR ${document.getElementById('price').value}`;
                newRow.cells[3].textContent = document.getElementById('stock').value;

                // Reset form, close modal, and remove this event listener
                productForm.reset();
                productFormModal.style.display = 'none';
                document.getElementById('formTitle').textContent = 'Add Product';
                document.getElementById('saveBtn').textContent = 'Save';
                productForm.removeEventListener('submit', updateProduct);
            };

            productForm.addEventListener('submit', updateProduct);
            console.log('Edit Product:', productName);
        });

        deleteBtn.addEventListener('click', () => {
            productTable.deleteRow(newRow.rowIndex - 1);
        });
    });

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        if (event.target == productFormModal) {
            productFormModal.style.display = 'none';
            productForm.reset();
            imagePreview.style.display = 'none';
        }
    };
});
