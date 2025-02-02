<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jobId = intval($_POST['jobId']);

    if ($jobId > 0) {
        $stmt = $conn->prepare("DELETE FROM jobs WHERE id = ?");
        if ($stmt === false) {
            echo json_encode(['success' => false, 'message' => 'Failed to prepare statement.']);
            exit;
        }

        $bind = $stmt->bind_param("i", $jobId);
        if ($bind === false) {
            echo json_encode(['success' => false, 'message' => 'Failed to bind parameters.']);
            exit;
        }

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Job deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete job.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid job ID.']);
    }

    $conn->close();
}
?>
