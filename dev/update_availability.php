<?php
require_once '../app/config/config.php'; // Include configuration file
require_once '../app/libraries/Database.php'; // Include database connection

// Create database instance
$db = new Database();

try {
    // Begin transaction
    $db->beginTransaction();

    // First query: Update worker availability (Unavailable)
    $query = "UPDATE farmworkers
              INNER JOIN job_requests ON farmworkers.user_id = job_requests.worker_id
              SET farmworkers.availability = 'Unavailable'
              WHERE job_requests.start_date = CURDATE() AND job_requests.status = 'Confirmed'";
    $db->query($query);
    $db->execute();

    // Second query: Update worker availability (Available)
    $query = "UPDATE farmworkers 
              INNER JOIN job_requests ON farmworkers.user_id = job_requests.worker_id
              SET farmworkers.availability = 'Available' 
              WHERE job_requests.end_date < CURDATE() AND job_requests.status = 'Confirmed'";
    $db->query($query);
    $db->execute();

    // Commit the transaction if both queries succeed
    $db->commit();

    echo "Worker availability updated.";
} catch (PDOException $e) {
    // Rollback in case of an error
    $db->rollBack();
    echo "Error: " . $e->getMessage();
}



echo "Worker availability updated.";
?>
