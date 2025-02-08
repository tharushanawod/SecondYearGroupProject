function openViewModal(orderId) {
    const URLROOT = document.querySelector('meta[name="url-root"]').getAttribute('content');
    fetch(`${URLROOT}/SupplierController/viewOrderDetails/${orderId}`)
        .then(response => response.json())
        .then(order => {
            populateOrderDetails(order);
            document.getElementById('orderDetailsModal').style.display = 'block';
        })
        .catch(error => {
            console.error('Error fetching order details:', error);
            alert('Failed to fetch order details. Please try again.');
        });
}

function populateOrderDetails(order) {
    document.getElementById('orderId').innerText = order.id;
    document.getElementById('productName').innerText = order.product_name;
    document.getElementById('customerId').innerText = order.farmer_id;
    document.getElementById('price').innerText = order.price;
    document.getElementById('quantity').innerText = order.quantity;
    document.getElementById('orderStatus').innerText = order.order_status;
    document.getElementById('paymentStatus').innerText = order.payment_status;
    document.getElementById('createdAt').innerText = order.created_at;

    // Handle rejection reason if exists
    const rejectionContainer = document.getElementById('rejectionReasonContainer');
    if (order.order_status === 'rejected' && order.rejection_reason) {
        document.getElementById('rejectionReason').innerText = order.rejection_reason;
        rejectionContainer.style.display = 'block';
    } else {
        rejectionContainer.style.display = 'none';
    }
}

function openRejectModal(orderId) {
    document.getElementById('rejectOrderId').value = orderId;
    document.getElementById('rejectOrderModal').style.display = 'block';
}

function closeModal(modalId) {
    document.getElementById(modalId).style.display = 'none';
}

// Event Listener for closing modals when clicking outside
window.onclick = (event) => {
    if (event.target.classList.contains('modal')) {
        closeModal(event.target.id);
    }
};