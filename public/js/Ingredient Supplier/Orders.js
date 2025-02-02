document.addEventListener('DOMContentLoaded', () => {
    const ordersTable = document.getElementById('ordersTable').getElementsByTagName('tbody')[0];
    const orderDetailsModal = document.getElementById('orderDetailsModal');
    const closeModal = document.getElementsByClassName('close')[0];
    const closeBtn = document.getElementById('closeBtn');
    const acceptOrderBtn = document.getElementById('acceptOrderBtn');
    const statusFilter = document.getElementById('statusFilter');
    const sendCodeBtn = document.getElementById('sendCodeBtn'); // Add this line

    
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
                    <button class="accept" onclick="acceptOrder(${order.id})">Accept</button>
                    <button class="send-code" onclick="sendCode(${order.id})">Send Code</button>
                </td>
            `;

            // Event listeners for actions
            const acceptBtn = newRow.querySelector('.accept');
            const sendCodeBtn = newRow.querySelector('.send-code');

            acceptBtn.addEventListener('click', () => showOrderDetails(order));
            sendCodeBtn.addEventListener('click', () => showOrderDetails(order));
        });
    }

    function showOrderDetails(order) {
        document.getElementById('customerName').innerText = order.customer_name;
        document.getElementById('deliveryAddress').innerText = order.delivery_address;
        document.getElementById('productDetails').innerText = `${order.product_name} (Quantity: ${order.quantity})`;
        document.getElementById('specialInstructions').innerText = order.special_instructions;

        acceptOrderBtn.onclick = () => acceptOrder(order.id);
        sendCodeBtn.onclick = () => sendDeliveryCode(order.id); // Fix this line

        orderDetailsModal.style.display = 'block';
    }

    function acceptOrder(orderId) {
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

    function sendDeliveryCode(orderId) {
        alert(`Delivery code sent for Order ID ${orderId}.`);
        orderDetailsModal.style.display = 'none';
        // Logic to send delivery code can go here
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