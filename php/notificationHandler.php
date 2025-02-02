<?php
session_start();
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

$user_id = $_SESSION['user']['id'];
$query = "SELECT message, created_at FROM notifications WHERE user_id = ? ORDER BY created_at DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

echo json_encode(["success" => true, "notifications" => $notifications]);
?>
