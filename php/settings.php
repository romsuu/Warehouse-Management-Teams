<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $siteTitle = trim($_POST['siteTitle']);
    $emailSender = trim($_POST['emailSender']);
    $protocolFile = trim($_POST['protocolFile']);

    $stmt = $conn->prepare("UPDATE settings SET site_title = ?, email_sender = ?, protocol_file = ?");
    $stmt->bind_param("sss", $siteTitle, $emailSender, $protocolFile);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Settings updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update settings.']);
    }

    $stmt->close();
    $conn->close();
}
?>
