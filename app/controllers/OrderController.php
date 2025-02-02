<?php

class OrderController extends Controller {
    private $Order;
    private $Notification;

    public function __construct() {
        $this->Order = $this->model('Order');
        $this->Notification = $this->model('Notification');
    }

    public function placeOrder() {
        // ...existing code...
        $data = []; // Define $data variable
        $orderId = $this->Order->placeOrder($data);

        // Create notification for the supplier
        $supplierId = $this->Order->getSupplierIdByOrderId($orderId);
        $this->Notification->createNotification($supplierId, 'New order placed by farmer.');

        // ...existing code...
    }

    public function updateOrderStatus($orderId, $status) {
        // ...existing code...
        $this->Order->updateOrderStatus($orderId, $status);

        // Create notification for the farmer
        $farmerId = $this->Order->getFarmerIdByOrderId($orderId);
        $message = $status == 'accepted' ? 'Your order has been accepted.' : 'Your order has been rejected.';
        $this->Notification->createNotification($farmerId, $message);

        // ...existing code...
    }
}
?>
