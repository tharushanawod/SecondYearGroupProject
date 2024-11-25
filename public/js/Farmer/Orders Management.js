document.addEventListener("DOMContentLoaded", () => {
  const ordersTable = document
    .getElementById("ordersTable")
    .getElementsByTagName("tbody")[0];
  const orderDetailsModal = document.getElementById("orderDetailsModal");
  const closeModal = document.getElementsByClassName("close")[0];
  const closeBtn = document.getElementById("closeBtn");
  const acceptOrderBtn = document.getElementById("acceptOrderBtn");
  const sendCodeBtn = document.getElementById("sendCodeBtn");
  const statusFilter = document.getElementById("statusFilter");

  const sampleOrders = [
    {
      id: 1,
      product: "Fertilizer",
      buyer: "Johanson ",
      price: 1000,
      payment: "Cash",
      quantity: "200 kg",
      status: "Pending",
      address: "123 Main St",
      instructions: "Leave at the front door",
    },
    {
      id: 2,
      product: "Pesticide",
      buyer: "shermi",
      price: 1500,
      payment: "Credit Card",
      quantity: "50 kg",
      status: "Accepted",
      address: "456 Oak St",
      instructions: "Ring the bell",
    },
    {
      id: 3,
      product: "Seed",
      buyer: "Bob Johnson",
      price: 2000,
      payment: "Cash",
      quantity: "250 kg",
      status: "Delivered",
      address: "789 Pine St",
      instructions: "Call upon arrival",
    },
    {
      id: 4,
      product: "Organic Compost",
      buyer: "Alice Brown",
      price: 1200,
      payment: "Bank Transfer",
      quantity: "300 kg",
      status: "Pending",
      address: "321 Maple St",
      instructions: "Leave at the side gate",
    },
    {
      id: 5,
      product: "Insecticide",
      buyer: "Charlie Davis",
      price: 1800,
      payment: "Cash",
      quantity: "100 kg",
      status: "Delivered",
      address: "654 Elm St",
      instructions: "Knock twice",
    },
    {
      id: 6,
      product: "Herbicide",
      buyer: "Emily Clark",
      price: 1400,
      payment: "Credit Card",
      quantity: "150 kg",
      status: "Accepted",
      address: "987 Cedar St",
      instructions: "Place near the garage",
    },
    {
      id: 7,
      product: "Crop Nutrients",
      buyer: "Michael Wright",
      price: 1700,
      payment: "Cash",
      quantity: "180 kg",
      status: "Pending",
      address: "159 Birch St",
      instructions: "Deliver after 5 PM",
    },
    {
      id: 8,
      product: "Growth Regulator",
      buyer: "Sophia Lopez",
      price: 1100,
      payment: "UPI",
      quantity: "120 kg",
      status: "Delivered",
      address: "753 Spruce St",
      instructions: "Call before delivery",
    },
    {
      id: 9,
      product: "Mulch",
      buyer: "David Wilson",
      price: 900,
      payment: "Cash",
      quantity: "220 kg",
      status: "Accepted",
      address: "246 Willow St",
      instructions: "Drop in the backyard",
    },
    {
      id: 10,
      product: "Manure",
      buyer: "Isabella Martinez",
      price: 1300,
      payment: "Credit Card",
      quantity: "350 kg",
      status: "Pending",
      address: "369 Redwood St",
      instructions: "Knock and wait",
    },
  ];

  function loadOrders(orders) {
    ordersTable.innerHTML = ""; // Clear table
    orders.forEach((order) => {
      const newRow = ordersTable.insertRow();
      newRow.innerHTML = `
                <td>${order.id}</td>
                <td>${order.product}</td>
                <td>${order.buyer}</td>
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
      const acceptBtn = newRow.querySelector(".accept");
      const sendCodeBtn = newRow.querySelector(".send-code");

      acceptBtn.addEventListener("click", () => showOrderDetails(order));
      sendCodeBtn.addEventListener("click", () => showOrderDetails(order));
    });
  }

  function showOrderDetails(order) {
    document.getElementById("buyerName").innerText = order.buyer;
    document.getElementById("deliveryAddress").innerText = order.address;
    document.getElementById(
      "productDetails"
    ).innerText = `${order.product} (Quantity: ${order.quantity})`;
    document.getElementById("specialInstructions").innerText =
      order.instructions;

    acceptOrderBtn.addEventListener("click", () => acceptOrder(order.id));
    sendCodeBtn.addEventListener("click", () => sendDeliveryCode(order.id));

    orderDetailsModal.style.display = "block";
  }

  function acceptOrder(orderId) {
    alert(`Order ID ${orderId} has been accepted.`);
    orderDetailsModal.style.display = "none";
    // Logic to update order status in the database can go here
  }

  function sendDeliveryCode(orderId) {
    alert(`Delivery code sent for Order ID ${orderId}.`);
    orderDetailsModal.style.display = "none";
    // Logic to send delivery code can go here
  }

  closeModal.addEventListener("click", () => {
    orderDetailsModal.style.display = "none";
  });

  closeBtn.addEventListener("click", () => {
    orderDetailsModal.style.display = "none";
  });

  window.onclick = function (event) {
    if (event.target == orderDetailsModal) {
      orderDetailsModal.style.display = "none";
    }
  };

  statusFilter.addEventListener("change", () => {
    const filterValue = statusFilter.value;
    if (filterValue === "all") {
      loadOrders(sampleOrders);
    } else {
      const filteredOrders = sampleOrders.filter(
        (order) => order.status.toLowerCase() === filterValue
      );
      loadOrders(filteredOrders);
    }
  });

  // Load initial orders
  loadOrders(sampleOrders);
});
