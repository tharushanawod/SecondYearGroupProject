document.addEventListener('DOMContentLoaded', () => {
    const addProductBtn = document.getElementById('addProductBtn');
    const productFormModal = document.getElementById('productFormModal');
    const closeBtn = document.querySelector('.close');
    const productForm = document.getElementById('productForm');
    const imageUpload = document.getElementById('imageUpload');
    const imagePreview = document.getElementById('imagePreview');
    const productTable = document.getElementById('productTable').getElementsByTagName('tbody')[0];
    let editingProductId = null; // To track the product being edited

    addProductBtn.addEventListener('click', () => {
        productForm.reset();
        document.getElementById('formTitle').textContent = 'Add Product';
        productForm.action = `${URLROOT}/SupplierController/addProduct`;
        productFormModal.style.display = 'block';
        editingProductId = null; // Reset editing ID
    });

    closeBtn.addEventListener('click', () => {
        productFormModal.style.display = 'none';
    });

    window.addEventListener('click', (event) => {
        if (event.target == productFormModal) {
            productFormModal.style.display = 'none';
        }
    });

    imageUpload.addEventListener('change', (event) => {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                imagePreview.src = e.target.result;
                imagePreview.style.display = 'block';
            };
            reader.readAsDataURL(file);
        }
    });

    document.querySelectorAll('a[href*="edit"]').forEach(editLink => {
        editLink.addEventListener('click', (event) => {
            event.preventDefault();
            const productId = editLink.href.split('=')[2];
            fetch(`${URLROOT}/SupplierController/getProductById/${productId}`)
                .then(response => response.json())
                .then(product => {
                    document.getElementById('productId').value = product.id;
                    document.getElementById('productName').value = product.product_name;
                    document.getElementById('category').value = product.category;
                    document.getElementById('price').value = product.price;
                    document.getElementById('stock').value = product.stock;
                    document.getElementById('description').value = product.description;
                    document.getElementById('productImage').value = product.image;
                    imagePreview.src = `${URLROOT}/images/${product.image}`;
                    imagePreview.style.display = 'block';
                    document.getElementById('formTitle').textContent = 'Edit Product';
                    productForm.action = `${URLROOT}/SupplierController/updateProduct`;
                    productFormModal.style.display = 'block';
                });
        });
    });

    // Save Product
    productForm.addEventListener('submit', (e) => {
        e.preventDefault();

        const productName = document.getElementById('productName').value;
        const category = document.getElementById('category').value;
        const price = document.getElementById('price').value;
        const stock = document.getElementById('stock').value;
        const description = document.getElementById('description').value; // Get product description

        const productData = {
            product_name: productName,
            category: category,
            price: price,
            stock: stock,
            description: description, // Include description
            id: editingProductId // Include ID if editing
        };

        const url = editingProductId ? 'update_product.php' : 'add_product.php'; // Different URLs for add and edit

        fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(productData),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                if (editingProductId) {
                    // Update existing row
                    const row = productTable.querySelector(`tr[data-id="${editingProductId}"]`);
                    row.cells[0].textContent = productName;
                    row.cells[1].textContent = category;
                    row.cells[2].textContent = `LKR ${price}`;
                    row.cells[3].textContent = stock;
                    row.cells[4].textContent = description; // Update description
                } else {
                    // Add new row
                    const newRow = productTable.insertRow();
                    newRow.setAttribute('data-id', data.id); // Set data-id attribute for the new row
                    newRow.innerHTML = `
                        <td>${productName}</td>
                        <td>${category}</td>
                        <td>LKR ${price}</td>
                        <td>${stock}</td>
                        <td>${description}</td> <!-- Add description to new row -->
                        <td class="actions">
                            <button class="edit" onclick="editProduct(${data.id})">Edit</button>
                            <button class="delete" onclick="deleteProduct(${data.id})">Delete</button>
                        </td>
                    `;
                }
                productFormModal.style.display = 'none';
            } else {
                alert('Error saving product');
            }
        });
    });

    // Edit Product
    window.editProduct = (id) => {
        const row = productTable.querySelector(`tr[data-id="${id}"]`);
        const cells = row.cells;

        document.getElementById('productName').value = cells[0].textContent;
        document.getElementById('category').value = cells[1].textContent;
        document.getElementById('price').value = cells[2].textContent.replace('LKR ', '').trim();
        document.getElementById('stock').value = cells[3].textContent;
        document.getElementById('description').value = cells[4].textContent; // Set description for editing

        productFormModal.style.display = 'block';
        document.getElementById('formTitle').textContent = 'Edit Product';
        document.getElementById('saveBtn').textContent = 'Update';

        editingProductId = id;
    };

    // Delete Product
    window.deleteProduct = (id) => {
        if (confirm('Are you sure you want to delete this product?')) {
            fetch(`delete_product.php?id=${id}`, {
                method: 'DELETE'
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    const row = productTable.querySelector(`tr[data-id="${id}"]`);
                    row.remove();
                } else {
                    alert('Error deleting product');
                }
            });
        }
    };

    // Close modal when clicking outside of it
    window.onclick = function(event) {
        if (event.target == productFormModal) {
            productFormModal.style.display = 'none';
        }
    };
});
