<?php
require_once '../app/config/config.php'; // Include configuration file
require_once '../app/libraries/Database.php'; // Include database connection

// Create database instance
$db = new Database();

// Update worker availability (Unavailable for workers whose job starts today and is confirmed)
$query = "UPDATE farmworkers 
          SET availability = 'Unavailable' 
          WHERE user_id IN (
              SELECT worker_id FROM job_requests 
              WHERE start_date = CURDATE() 
              AND status = 'Confirmed'
          )";
$db->query($query);
$db->execute();

// Update worker availability (Available for workers whose job ends before today and is confirmed)
$query = "UPDATE farmworkers 
          SET availability = 'Available' 
          WHERE user_id IN (
              SELECT worker_id FROM job_requests 
              WHERE end_date < CURDATE() 
              AND status = 'Confirmed'
          )";
$db->query($query);
$db->execute();

echo "Worker availability updated.";
?>
