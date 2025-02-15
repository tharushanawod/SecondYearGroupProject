<?php
require_once '../app/config/config.php'; // Include configuration file
require_once '../app/libraries/Database.php'; // Include database connection

// Create database instance
$db = new Database();

// Query to get the highest bid for each product whose closing date has passed
$sql = "
    SELECT u.name AS buyer_name, b.bid_amount AS bid_price, p.quantity, p.product_id, b.buyer_id, p.user_id AS farmer_id
FROM bids b
JOIN (
    SELECT product_id, MAX(bid_amount) AS max_bid
    FROM bids
    GROUP BY product_id
) max_bids ON b.product_id = max_bids.product_id AND b.bid_amount = max_bids.max_bid
JOIN corn_products p ON b.product_id = p.product_id
JOIN users u ON b.buyer_id = u.user_id
WHERE p.closing_date <= NOW() AND NOT EXISTS (
    SELECT 1 FROM orders_from_buyers o WHERE o.product_id = p.product_id
);

";

$db->query($sql);
$winners = $db->resultSet();
var_dump($winners);

// Process the winners and insert them into the orders_from_buyers table
foreach ($winners as $winner) {
    $db->query("
        INSERT INTO orders_from_buyers (farmer_id, buyer_id, bid_price, quantity, payment_status, order_date, product_id) 
        VALUES (:farmer_id, :buyer_id, :bid_price, :quantity, 'pending', CURRENT_TIMESTAMP, :product_id)
    ");
    $db->bind(':farmer_id', $winner->farmer_id);  // Accessing 'farmer_id' property of the object
    $db->bind(':buyer_id', $winner->buyer_id);    // Accessing 'buyer_id' property of the object
    $db->bind(':bid_price', $winner->bid_price);  // Accessing 'bid_price' property of the object
    $db->bind(':quantity', $winner->quantity);    // Accessing 'quantity' property of the object
    $db->bind(':product_id', $winner->product_id); // Accessing 'product_id' property of the object
    
    $db->execute();
}

echo " Winners processed at " . date('Y-m-d H:i:s');
// // Log the result for debugging
// error_log("Auction winners processed at " . date('Y-m-d H:i:s'));
?>
