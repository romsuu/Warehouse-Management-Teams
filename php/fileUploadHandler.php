<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['protocolFile'])) {
    $uploadDir = __DIR__ . "/../assets/files/";
    $fileName = basename($_FILES['protocolFile']['name']);
    $uploadFile = $uploadDir . $fileName;

    if (move_uploaded_file($_FILES['protocolFile']['tmp_name'], $uploadFile)) {
        $stmt = $conn->prepare("UPDATE settings SET protocol_file = ?");
        $stmt->bind_param("s", $fileName);
        $stmt->execute();
        echo json_encode(["success" => true, "message" => "File uploaded successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to upload file."]);
    }
}
?>
