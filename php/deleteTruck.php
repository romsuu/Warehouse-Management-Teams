<?php
session_start();
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['truckId'])) {
    $truckId = intval($_POST['truckId']);

    $stmt = $conn->prepare("DELETE FROM trucks WHERE id = ?");
    $stmt->bind_param("i", $truckId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Truck deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete truck."]);
    }
    $stmt->close();
}
$conn->close();
?>
