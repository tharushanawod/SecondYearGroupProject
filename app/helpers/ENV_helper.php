<?php
// helpers.php

function loadEnv($filePath) {
    // Check if the .env file exists
    if (!file_exists($filePath)) {
        throw new Exception("Environment file not found: " . $filePath);
    }

    // Read the file line by line
    $lines = file($filePath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        // Skip comments (lines starting with #)
        if (strpos(trim($line), '#') === 0) {
            continue;
        }

        // Match key=value pairs
        if (preg_match('/^([^=]+)=(.*)$/', $line, $matches)) {
            $key = trim($matches[1]);
            $value = trim($matches[2]);

            // Remove quotes around the value if present
            if (preg_match('/^"(.*)"$/', $value, $quoteMatches)) {
                $value = $quoteMatches[1];
            } elseif (preg_match("/^'(.*)'$/", $value, $quoteMatches)) {
                $value = $quoteMatches[1];
            }

            // Store the key-value pair in $_ENV
            $_ENV[$key] = $value;
        }
    }
}