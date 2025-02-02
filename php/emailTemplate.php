<?php
session_start();
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] !== 1) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_subject = $_POST['subject'] ?? '';
    $email_body = $_POST['body'] ?? '';

    file_put_contents("email_template.txt", json_encode(["subject" => $email_subject, "body" => $email_body]));
    echo json_encode(["success" => true, "message" => "Email template updated"]);
    exit;
}

if (file_exists("email_template.txt")) {
    echo file_get_contents("email_template.txt");
} else {
    echo json_encode(["success" => false, "message" => "No template found"]);
}
?>
