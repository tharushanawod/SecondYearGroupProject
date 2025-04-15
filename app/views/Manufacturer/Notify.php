<?php
$merchant_id = $_POST['merchant_id'];
$order_id = $_POST['order_id'];
$payhere_amount = $_POST['total_advance'];
$payhere_currency = $_POST['payhere_currency'];
$status_code = $_POST['status_code'];
$md5sig = $_POST['md5sig'];

$merchant_secret = "MzY1NjEwNjkxODQ0ODUyODA0Nzc2MDk0MzMwMzM2MDA0NDcxMg=="; // Get this from PayHere

$local_md5sig = strtoupper(md5($merchant_id . $order_id . $payhere_amount . $payhere_currency . $status_code . strtoupper(md5($merchant_secret))));

if ($local_md5sig === $md5sig) {
    if ($status_code == 2) {
        // Payment successful - update your database
        file_put_contents("payment_log.txt", "Payment successful for Order ID: $order_id\n", FILE_APPEND);
    } else {
        file_put_contents("payment_log.txt", "Payment failed for Order ID: $order_id\n", FILE_APPEND);
    }
} else {
    file_put_contents("payment_log.txt", "Invalid Signature\n", FILE_APPEND);
}
?>
