<?php
session_start();
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

$protocol_file = "uploads/safety_protocol.pdf";
if (file_exists($protocol_file)) {
    header('Content-Type: application/pdf');
    readfile($protocol_file);
} else {
    echo json_encode(["success" => false, "message" => "File not found."]);
}
?>
