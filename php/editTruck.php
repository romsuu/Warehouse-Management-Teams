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
    $carrier = trim($_POST['carrier']);
    $truckNumber = trim($_POST['truckNumber']);
    $trailerNumber = trim($_POST['trailerNumber']);
    $pallets = intval($_POST['pallets']);
    $ibc = intval($_POST['ibc']);
    $arrivalDate = $_POST['arrivalDate'];

    if (!empty($carrier) && !empty($truckNumber)) {
        $stmt = $conn->prepare("UPDATE trucks SET carrier = ?, truck_number = ?, trailer_number = ?, pallets = ?, ibc = ?, arrival_date = ? WHERE id = ?");
        if ($stmt === false) {
            echo json_encode(["success" => false, "message" => "Failed to prepare statement."]);
            exit;
        }

        $bind = $stmt->bind_param("sssddsi", $carrier, $truckNumber, $trailerNumber, $pallets, $ibc, $arrivalDate, $truckId);
        if ($bind === false) {
            echo json_encode(["success" => false, "message" => "Failed to bind parameters."]);
            exit;
        }

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Truck details updated successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update truck details."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Invalid truck details."]);
    }
}

$conn->close();
?>
