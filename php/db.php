<?php
$host = 'localhost';
$username = 'root';
$password = '';
$database = 'if0_37013988_teamtracker2';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    error_log("❌ ERROR: Database connection failed: " . $conn->connect_error);
    die("Database connection error.");
}
?>
