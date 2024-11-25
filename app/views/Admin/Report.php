<?php




// File name for download
$fileName = 'User_Report.csv';

// Set headers to download the file
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $fileName . '"');

// Open output stream
$output = fopen('php://output', 'w');

// Write data to CSV
foreach ($data as $row) {
    fputcsv($output, $row);
}

// Close output stream
fclose($output);
?>
