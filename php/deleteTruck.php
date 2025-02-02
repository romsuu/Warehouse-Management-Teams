<?php
session_start();
require_once __DIR__ . '/db.php';

// Check if user is authenticated and has the appropriate role
if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] !== 2) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['truckId'])) {
    $truckId = intval($_POST['truckId']);

    if ($truckId > 0) {
        $stmt = $conn->prepare("DELETE FROM trucks WHERE id = ?");
        if ($stmt === false) {
            echo json_encode(["success" => false, "message" => "Failed to prepare statement."]);
            exit;
        }

        $bind = $stmt->bind_param("i", $truckId);
        if ($bind === false) {
            echo json_encode(["success" => false, "message" => "Failed to bind parameters."]);
            exit;
        }

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Truck deleted successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to delete truck."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Invalid truck ID."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}

$conn->close();
?>
