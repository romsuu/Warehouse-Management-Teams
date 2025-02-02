<?php
session_start();
require_once __DIR__ . '/db.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: /index.php");
    exit;
}

// Fetch system stats with error handling
$stats = [];

try {
    $usersResult = $conn->query("SELECT COUNT(*) as count FROM users");
    if ($usersResult) {
        $stats["users"] = $usersResult->fetch_assoc()['count'];
    } else {
        throw new Exception("Failed to fetch users count");
    }

    $trucksResult = $conn->query("SELECT COUNT(*) as count FROM trucks");
    if ($trucksResult) {
        $stats["trucks"] = $trucksResult->fetch_assoc()['count'];
    } else {
        throw new Exception("Failed to fetch trucks count");
    }

    $jobsResult = $conn->query("SELECT COUNT(*) as count FROM jobs");
    if ($jobsResult) {
        $stats["jobs"] = $jobsResult->fetch_assoc()['count'];
    } else {
        throw new Exception("Failed to fetch jobs count");
    }

    echo json_encode(["success" => true, "stats" => $stats]);
} catch (Exception $e) {
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}

$conn->close();
?>
