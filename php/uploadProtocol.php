<?php
session_start();
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user']) || $_SESSION['user']['role_id'] !== 1) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

if (!isset($_FILES['protocol'])) {
    echo json_encode(["success" => false, "message" => "No file uploaded."]);
    exit;
}

$target_dir = "uploads/";
$target_file = $target_dir . basename($_FILES["protocol"]["name"]);
move_uploaded_file($_FILES["protocol"]["tmp_name"], $target_file);

echo json_encode(["success" => true, "message" => "File uploaded successfully."]);
?>
