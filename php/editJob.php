<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jobId = intval($_POST['jobId']);
    $jobName = trim($_POST['jobName']);
    $multiplier = floatval($_POST['multiplier']);

    if ($jobId > 0 && !empty($jobName) && $multiplier > 0) {
        $stmt = $conn->prepare("UPDATE jobs SET job_name = ?, multiplier = ? WHERE id = ?");
        $stmt->bind_param("sdi", $jobName, $multiplier, $jobId);

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
