function openViewModal(orderId) {
    const URLROOT = 'your_base_url_here'; // Ensure URLROOT is defined
    fetch(`${URLROOT}/SupplierController/viewOrderDetails/${orderId}`)
        .then(response => response.json())
        .then(order => {
            document.getElementById('orderId').innerText = order.id;
            document.getElementById('customerName').innerText = order.customer_name;
            document.getElementById('deliveryAddress').innerText = order.delivery_address;
            document.getElementById('productDetails').innerText = `${order.product_name} (Quantity: ${order.quantity})`;
            document.getElementById('specialInstructions').innerText = order.special_instructions;
            document.getElementById('orderDate').innerText = order.order_date;
            document.getElementById('paymentMethod').innerText = order.payment_method;
            document.getElementById('totalAmount').innerText = order.total_amount;

            document.getElementById('orderDetailsModal').style.display = 'block';
        })
        .catch(error => {
            console.error('Error fetching order details:', error);
        });
}

function openRejectModal(orderId) {
    document.getElementById('rejectOrderId').value = orderId;
    document.getElementById('rejectOrderModal').style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

