<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $truckId = intval($_POST['truckId']);
    $status = trim($_POST['status']);
    $arrivalTime = date('Y-m-d H:i:s');

    if ($truckId > 0 && !empty($status)) {
        $stmt = $conn->prepare("UPDATE trucks SET status = ?, arrival_time = ? WHERE id = ?");
        $stmt->bind_param("ssi", $status, $arrivalTime, $truckId);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Arrival status updated.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update arrival status.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid data provided.']);
    }

    $conn->close();
}
?>
