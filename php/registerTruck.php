<?php
session_start();
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $carrier = trim($_POST['carrier']);
    $truckNumber = trim($_POST['truckNumber']);
    $trailerNumber = trim($_POST['trailerNumber']);
    $pallets = intval($_POST['pallets']);
    $ibc = intval($_POST['ibc']);
    $arrivalDate = $_POST['arrivalDate'];

    $stmt = $conn->prepare("INSERT INTO trucks (carrier, truck_number, trailer_number, pallets, ibc, arrival_date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdds", $carrier, $truckNumber, $trailerNumber, $pallets, $ibc, $arrivalDate);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Truck registered successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to register truck."]);
    }
    exit;
}
?>
