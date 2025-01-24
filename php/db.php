<?php
$host = getenv('DB_HOST') ?: 'sql109.infinityfree.com';
$username = getenv('DB_USER') ?: 'if0_37013988';
$password = getenv('DB_PASS') ?: 'Maeitea1990';
$database = getenv('DB_NAME') ?: 'if0_37013988_teamtracker2';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die(json_encode(['success' => false, 'message' => 'Database connection failed: ' . $conn->connect_error]));
}
?>
