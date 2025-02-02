<?php
include 'db.php';

session_start();
if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $entryId = intval($_POST['entryId']);
    $numRows = intval($_POST['numRows']);
    $jobId = intval($_POST['jobId']);
    $multiplier = floatval($_POST['multiplier']);
    $total = $numRows * $multiplier;

    $stmt = $conn->prepare("UPDATE entries SET num_rows = ?, job_id = ?, multiplier = ?, total = ? WHERE id = ?");
    $stmt->bind_param("iiddi", $numRows, $jobId, $multiplier, $total, $entryId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Entry updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update entry.']);
    }

    $stmt->close();
    $conn->close();
}
?>
