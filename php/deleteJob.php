<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jobId = intval($_POST['jobId']);

    if ($jobId > 0) {
        $stmt = $conn->prepare("DELETE FROM jobs WHERE id = ?");
        $stmt->bind_param("i", $jobId);

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
