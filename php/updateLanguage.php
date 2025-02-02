<?php
session_start();
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_SESSION['user'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

$language = $_POST['language'] ?? 'en';

$_SESSION['language'] = $language;
echo json_encode(["success" => true, "message" => "Language updated"]);
?>
