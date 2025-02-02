<?php
session_start();
require_once __DIR__ . '/db.php';

// Check if user is authenticated and has the appropriate role
if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] !== 1) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email_subject = trim($_POST['subject'] ?? '');
    $email_body = trim($_POST['body'] ?? '');

    if (empty($email_subject) || empty($email_body)) {
        echo json_encode(["success" => false, "message" => "Subject and body cannot be empty"]);
        exit;
    }

    $template_data = json_encode(["subject" => htmlspecialchars($email_subject), "body" => htmlspecialchars($email_body)]);
    if (file_put_contents("email_template.txt", $template_data) !== false) {
        echo json_encode(["success" => true, "message" => "Email template updated"]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update email template"]);
    }
    exit;
}

if (file_exists("email_template.txt")) {
    echo file_get_contents("email_template.txt");
} else {
    echo json_encode(["success" => false, "message" => "No template found"]);
}
?>
