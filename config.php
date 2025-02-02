<?php
// Database Configuration
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'tracker2';

// Create a new database connection
$conn = new mysqli($host, $username, $password, $database);

// Check for connection errors
if ($conn->connect_error) {
    error_log("❌ Database connection failed: " . $conn->connect_error);
    die("Database connection error.");
}

// Set default timezone
date_default_timezone_set('Europe/Tallinn');
?>
