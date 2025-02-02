<?php
session_start();
require_once __DIR__ . '/db.php';

// Check if user is authenticated and has the appropriate role
if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] !== 2) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jobId = intval($_POST['jobId']);
    $jobName = trim($_POST['jobName']);
    $multiplier = floatval($_POST['multiplier']);

    if ($jobId > 0 && !empty($jobName) && $multiplier > 0) {
        $stmt = $conn->prepare("UPDATE jobs SET job_name = ?, multiplier = ? WHERE id = ?");
        if ($stmt === false) {
            echo json_encode(['success' => false, 'message' => 'Failed to prepare statement.']);
            exit;
        }

        $bind = $stmt->bind_param("sdi", $jobName, $multiplier, $jobId);
        if ($bind === false) {
            echo json_encode(['success' => false, 'message' => 'Failed to bind parameters.']);
            exit;
        }

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Job updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update job.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid input data.']);
    }

    $conn->close();
}
?>
