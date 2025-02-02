<?php
session_start();
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] !== 1) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit;
}

// Fetch users and permissions
$query = "SELECT id, username, role_id FROM users";
$result = $conn->query($query);

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode(["success" => true, "users" => $users]);
$conn->close();
?>
