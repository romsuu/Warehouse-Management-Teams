<?php
session_start();
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user'])) {
    header("Location: /index.php");
    exit;
}

// Fetch system stats
$stats = [
    "users" => $conn->query("SELECT COUNT(*) as count FROM users")->fetch_assoc()['count'],
    "trucks" => $conn->query("SELECT COUNT(*) as count FROM trucks")->fetch_assoc()['count'],
    "jobs" => $conn->query("SELECT COUNT(*) as count FROM jobs")->fetch_assoc()['count']
];

echo json_encode(["success" => true, "stats" => $stats]);
?>
