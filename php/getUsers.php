<?php
session_start();
require_once __DIR__ . '/db.php';

header('Content-Type: application/json');

$result = $conn->query("SELECT id, username, role FROM users ORDER BY id ASC");
$users = [];

while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

echo json_encode(["success" => true, "users" => $users]);
$conn->close();
?>
