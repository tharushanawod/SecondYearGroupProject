function showModal(modalId, order = null) {

    const modal = document.getElementById(modalId);
    if (order) {
        if (modalId === 'orderDetailsModal') {
            populateOrderDetails(order);
        }
    }
    modal.style.display = 'block';
}

function populateOrderDetails(order) {
    document.getElementById('customerName').innerText = order.customer_name;
    document.getElementById('deliveryAddress').innerText = order.delivery_address;
    document.getElementById('productDetails').innerText = `${order.product_name} (Quantity: ${order.quantity})`;
    document.getElementById('specialInstructions').innerText = order.special_instructions;

    document.getElementById('acceptOrderBtn').onclick = () => acceptOrder(order.id);
    document.getElementById('rejectOrderBtn').onclick = () => rejectOrder(order.id);
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'none';
}

function loadOrders(orders) {
    const ordersTable = document.getElementById('ordersTable').getElementsByTagName('tbody')[0];
    ordersTable.innerHTML = ''; // Clear table
    orders.forEach(order => {
        const newRow = ordersTable.insertRow();
        newRow.innerHTML = `
            <td>${order.id}</td>
            <td>${order.product_name}</td>
            <td>${order.farmer_id}</td>
            <td>LKR ${order.price}</td>
            <td>${order.payment_status}</td>
            <td>${order.quantity}</td>
            <td>${order.order_status}</td>
            <td class="actions">
                <button class="accept" onclick="acceptOrder(${order.id})">Accept</button>
                <button class="reject" onclick="rejectOrder(${order.id})">Reject</button>
                <button class="view" onclick="viewOrderDetails(${order.id})">View</button>
            </td>
        `;
    });
}

function viewOrderDetails(orderId) {
    fetch(`${URLROOT}/OrderController/getOrderDetails/${orderId}`, {
        mode: 'cors'
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(order => {
            showModal('orderDetailsModal', order);
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
            alert('Failed to fetch order details');
        });
}

function acceptOrder(orderId) {
    fetch(`${URLROOT}/OrderController/updateOrderStatus/${orderId}/accepted`, {
        mode: 'cors'
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert(`Order ID ${orderId} has been accepted.`);
                closeModal('orderDetailsModal');
                loadOrders(data.orders);
            } else {
                alert('Error accepting order');
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
            alert('Failed to accept order');
        });
}

function rejectOrder(orderId) {
    const reason = document.getElementById('rejectionReason').value;
    fetch(`${URLROOT}/OrderController/updateOrderStatus/${orderId}/rejected`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ reason: reason }),
        mode: 'cors'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert(`Order ID ${orderId} has been rejected.`);
            closeModal('orderDetailsModal');
            loadOrders(data.orders);
        } else {
            alert('Error rejecting order');
        }
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
        alert('Failed to reject order');
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const closeModalButtons = document.querySelectorAll('.close, #closeBtn');
    closeModalButtons.forEach(button => {
        button.addEventListener('click', () => {
            closeModal('orderDetailsModal');
        });
    });

    window.onclick = (event) => {
        if (event.target.classList.contains('modal')) {
            closeModal(event.target.id);
        }
    };

    document.getElementById('statusFilter').addEventListener('change', () => {
        const filterValue = document.getElementById('statusFilter').value;
        fetch(`${URLROOT}/OrderController/filterOrders/${filterValue}`, {
            mode: 'cors'
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(filteredOrders => {
                loadOrders(filteredOrders);
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
                alert('Failed to filter orders');
            });
    });

});

function showModal(modalId, order = null) {
    const modal = document.getElementById(modalId);
    if (order) {
        if (modalId === 'orderDetailsModal') {
            populateOrderDetails(order);
        }
    }
    modal.style.display = 'block';
}

function populateOrderDetails(order) {
    document.getElementById('customerName').innerText = order.customer_name;
    document.getElementById('deliveryAddress').innerText = order.delivery_address;
    document.getElementById('productDetails').innerText = `${order.product_name} (Quantity: ${order.quantity})`;
    document.getElementById('specialInstructions').innerText = order.special_instructions;

    document.getElementById('acceptOrderBtn').onclick = () => acceptOrder(order.id);
    document.getElementById('rejectOrderBtn').onclick = () => rejectOrder(order.id);
}

function closeModal(modalId) {
    const modal = document.getElementById(modalId);
    modal.style.display = 'none';
}

function loadOrders(orders) {
    const ordersTable = document.getElementById('ordersTable').getElementsByTagName('tbody')[0];
    ordersTable.innerHTML = ''; // Clear table
    orders.forEach(order => {
        const newRow = ordersTable.insertRow();
        newRow.innerHTML = `
            <td>${order.id}</td>
            <td>${order.product_name}</td>
            <td>${order.farmer_id}</td>
            <td>LKR ${order.price}</td>
            <td>${order.payment_status}</td>
            <td>${order.quantity}</td>
            <td>${order.order_status}</td>
            <td class="actions">
                <button class="accept" onclick="acceptOrder(${order.id})">Accept</button>
                <button class="reject" onclick="rejectOrder(${order.id})">Reject</button>
                <button class="view" onclick="viewOrderDetails(${order.id})">View</button>
            </td>
        `;
    });
}

function viewOrderDetails(orderId) {
    fetch(`${URLROOT}/OrderController/getOrderDetails/${orderId}`, {
        mode: 'cors'
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(order => {
            showModal('orderDetailsModal', order);
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
            alert('Failed to fetch order details');
        });
}

function acceptOrder(orderId) {
    fetch(`${URLROOT}/OrderController/updateOrderStatus/${orderId}/accepted`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        mode: 'cors'
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            if (data.success) {
                alert(`Order ID ${orderId} has been accepted.`);
                closeModal('orderDetailsModal');
                loadOrders(data.orders);
            } else {
                alert('Error accepting order');
            }
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
            alert('Failed to accept order');
        });
}

function rejectOrder(orderId) {
    const reason = document.getElementById('rejectionReason').value;
    fetch(`${URLROOT}/OrderController/updateOrderStatus/${orderId}/rejected`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
        },
        body: JSON.stringify({ reason: reason }),
        mode: 'cors'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            alert(`Order ID ${orderId} has been rejected.`);
            closeModal('orderDetailsModal');
            loadOrders(data.orders);
        } else {
            alert('Error rejecting order');
        }
    })
    .catch(error => {
        console.error('There was a problem with the fetch operation:', error);
        alert('Failed to reject order');
    });
}

document.addEventListener('DOMContentLoaded', () => {
    const closeModalButtons = document.querySelectorAll('.close, #closeBtn');
    closeModalButtons.forEach(button => {
        button.addEventListener('click', () => {
            closeModal('orderDetailsModal');
        });
    });

    window.onclick = (event) => {
        if (event.target.classList.contains('modal')) {
            closeModal(event.target.id);
        }
    };

    document.getElementById('statusFilter').addEventListener('change', () => {
        const filterValue = document.getElementById('statusFilter').value;
        fetch(`${URLROOT}/OrderController/filterOrders/${filterValue}`, {
            mode: 'cors'
        })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(filteredOrders => {
                loadOrders(filteredOrders);
            })
            .catch(error => {
                console.error('There was a problem with the fetch operation:', error);
                alert('Failed to filter orders');
            });
    });

    // Load initial orders
    fetch(`${URLROOT}/OrderController/getOrders`, {
        mode: 'cors'
    })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(orders => {
            loadOrders(orders);
        })
        .catch(error => {
            console.error('There was a problem with the fetch operation:', error);
            alert('Failed to load orders');
        });
});