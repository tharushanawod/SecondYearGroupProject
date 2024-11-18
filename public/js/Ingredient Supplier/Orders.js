document.addEventListener('DOMContentLoaded', () => {
    const ordersTable = document.getElementById('ordersTable').getElementsByTagName('tbody')[0];
    const orderDetailsModal = document.getElementById('orderDetailsModal');
    const closeModal = document.getElementsByClassName('close')[0];
    const closeBtn = document.getElementById('closeBtn');
    const acceptOrderBtn = document.getElementById('acceptOrderBtn');
    const sendCodeBtn = document.getElementById('sendCodeBtn');
    const statusFilter = document.getElementById('statusFilter');

    const sampleOrders = [
        { id: 1, product: 'Fertilizer', customer: 'John Doe', price: 1000, payment: 'Cash', quantity: 2, status: 'Pending', address: '123 Main St', instructions: 'Leave at the front door' },
        { id: 2, product: 'Pesticide', customer: 'Jane Smith', price: 1500, payment: 'Credit Card', quantity: 1, status: 'Accepted', address: '456 Oak St', instructions: 'Ring the bell' },
        { id: 3, product: 'Seed', customer: 'Bob Johnson', price: 2000, payment: 'Cash', quantity: 5, status: 'Delivered', address: '789 Pine St', instructions: 'Call upon arrival' },
    ];

    function loadOrders(orders) {
        ordersTable.innerHTML = ''; // Clear table
        orders.forEach(order => {
            const newRow = ordersTable.insertRow();
            newRow.innerHTML = `
                <td>${order.id}</td>
                <td>${order.product}</td>
                <td>${order.customer}</td>
                <td>${order.price}</td>
                <td>${order.payment}</td>
                <td>${order.quantity}</td>
                <td>${order.status}</td>
                <td class="actions">
                    <button class="accept">Accept</button>
                    <button class="send-code">Send Code</button>
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
        document.getElementById('customerName').innerText = order.customer;
        document.getElementById('deliveryAddress').innerText = order.address;
        document.getElementById('productDetails').innerText = `${order.product} (Quantity: ${order.quantity})`;
        document.getElementById('specialInstructions').innerText = order.instructions;

        acceptOrderBtn.addEventListener('click', () => acceptOrder(order.id));
        sendCodeBtn.addEventListener('click', () => sendDeliveryCode(order.id));

        orderDetailsModal.style.display = 'block';
    }

    function acceptOrder(orderId) {
        alert(`Order ID ${orderId} has been accepted.`);
        orderDetailsModal.style.display = 'none';
        // Logic to update order status in the database can go here
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
            const filteredOrders = sampleOrders.filter(order => order.status.toLowerCase() === filterValue);
            loadOrders(filteredOrders);
        }
    });

    // Load initial orders
    loadOrders(sampleOrders);
});
