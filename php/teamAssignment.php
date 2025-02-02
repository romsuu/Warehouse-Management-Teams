<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $truckId = intval($_POST['truckId']);
    $teamId = intval($_POST['teamId']);

    $stmt = $conn->prepare("UPDATE trucks SET team_id = ? WHERE id = ?");
    $stmt->bind_param("ii", $teamId, $truckId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Team assigned successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to assign team.']);
    }

    $stmt->close();
    $conn->close();
}
?>
