<?php
session_start();
require_once __DIR__ . '/db.php';

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
        $stmt->bind_param("sssddsi", $carrier, $truckNumber, $trailerNumber, $pallets, $ibc, $arrivalDate, $truckId);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Truck details updated successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update truck details."]);
        }
    } else {
        echo json_encode(["success" => false, "message" => "Invalid truck details."]);
    }
    $stmt->close();
}
$conn->close();
?>
