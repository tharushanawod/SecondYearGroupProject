document.addEventListener('DOMContentLoaded', () => {
    const productTable = document.getElementById('productTable').getElementsByTagName('tbody')[0];

    // Add event listeners to delete icons
    productTable.querySelectorAll('.delete').forEach(deleteBtn => {
        deleteBtn.addEventListener('click', (e) => {
            const row = e.target.closest('tr');
            productTable.deleteRow(row.rowIndex - 1);
        });
    });

    // Example function to add a product row (for demonstration purposes)
    function addProductRow(productName, category, price, stock) {
        const newRow = productTable.insertRow();
        newRow.innerHTML = `
            <td>${productName}</td>
            <td>${category}</td>
            <td>LKR ${price}</td>
            <td>${stock}</td>
            <td class="actions">
                <button class="delete">Delete</button>
            </td>
        `;

        // Add event listener to the new delete icon
        newRow.querySelector('.delete').addEventListener('click', (e) => {
            const row = e.target.closest('tr');
            productTable.deleteRow(row.rowIndex - 1);
        });
    }

    // Example usage
    addProductRow('New Product', 'Seeds', 2000, 30);    
});