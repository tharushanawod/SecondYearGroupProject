document.addEventListener('DOMContentLoaded', () => {
    const ordersTable = document.getElementById('ordersTable').getElementsByTagName('tbody')[0];
    const orderDetailsModal = document.getElementById('orderDetailsModal');
    const closeModal = document.getElementsByClassName('close')[0];
    const closeBtn = document.getElementById('closeBtn');
    const acceptOrderBtn = document.getElementById('acceptOrderBtn');
    const rejectOrderBtn = document.getElementById('rejectOrderBtn');
    const statusFilter = document.getElementById('statusFilter');
    const sendCodeBtn = document.getElementById('sendCodeBtn');

    function loadOrders(orders) {
        ordersTable.innerHTML = ''; // Clear table
        orders.forEach(order => {
            const newRow = ordersTable.insertRow();
            newRow.innerHTML = `
                <td>${order.id}</td>
                <td>${order.product_name}</td>
                <td>${order.customer_name}</td>
                <td>LKR ${order.price}</td>
                <td>${order.payment_status}</td>
                <td>${order.quantity}</td>
                <td>${order.order_status}</td>
                <td class="actions">
                    <button class="accept" onclick="showOrderDetails(${order.id})">Accept</button>
                    <button class="reject" onclick="showOrderDetails(${order.id})">Reject</button>
                    <button class="send-code" onclick="showOrderDetails(${order.id})">Send Code</button>
                </td>
            `;

            // Event listeners for actions
            const acceptBtn = newRow.querySelector('.accept');
            const rejectBtn = newRow.querySelector('.reject');
            const sendCodeBtn = newRow.querySelector('.send-code');

            acceptBtn.addEventListener('click', () => showOrderDetails(order));
            rejectBtn.addEventListener('click', () => showOrderDetails(order));
            sendCodeBtn.addEventListener('click', () => showOrderDetails(order));
        });
    }

    function showOrderDetails(order) {
        document.getElementById('customerName').innerText = order.customer_name;
        document.getElementById('deliveryAddress').innerText = order.delivery_address;
        document.getElementById('productDetails').innerText = `${order.product_name} (Quantity: ${order.quantity})`;
        document.getElementById('specialInstructions').innerText = order.special_instructions;

        acceptOrderBtn.onclick = () => acceptOrder(order.id);
        rejectOrderBtn.onclick = () => rejectOrder(order.id);
        sendCodeBtn.onclick = () => sendDeliveryCode(order.id);

        orderDetailsModal.style.display = 'block';
    }

    function acceptOrder(orderId) {
        console.log(`Accepting order ID: ${orderId}`);
        fetch(`${URLROOT}/SupplierController/updateOrderStatus/${orderId}/accepted`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    alert(`Order ID ${orderId} has been accepted.`);
                    orderDetailsModal.style.display = 'none';
                    loadOrders(data.orders);
                } else {
                    alert('Error accepting order');
                }
            });
    }

    function rejectOrder(orderId) {
        const reason = document.getElementById('rejectionReason').value;
        console.log(`Rejecting order ID: ${orderId} with reason: ${reason}`);
        fetch(`${URLROOT}/SupplierController/updateOrderStatus/${orderId}/rejected`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify({ reason: reason }),
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert(`Order ID ${orderId} has been rejected.`);
                orderDetailsModal.style.display = 'none';
                loadOrders(data.orders);
            } else {
                alert('Error rejecting order');
            }
        });
    }

    closeModal.addEventListener('click', () => {
        orderDetailsModal.style.display = 'none';
    });

    closeBtn.addEventListener('click', () => {
        orderDetailsModal.style.display = 'none';
    });

    window.onclick = function(event) {
        if (event.target == orderDetailsModal) {
            orderDetailsModal.style.display = 'none';
        }
    };

    statusFilter.addEventListener('change', () => {
        const filterValue = statusFilter.value;
        if (filterValue === 'all') {
            loadOrders(sampleOrders);
        } else {
            const filteredOrders = sampleOrders.filter(order => order.order_status.toLowerCase() === filterValue);
            loadOrders(filteredOrders);
        }
    });

    function checkNewOrders() {
        fetch(`${URLROOT}/SupplierController/checkNewOrders`)
            .then(response => response.json())
            .then(data => {
                if (data.new_orders > 0) {
                    alert(`You have ${data.new_orders} new orders!`);
                }
            });
    }

    setInterval(checkNewOrders, 60000); // Check every 60 seconds

    // Load initial orders
    loadOrders(sampleOrders);
});