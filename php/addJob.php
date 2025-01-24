<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jobName = trim($_POST['jobName'] ?? '');
    $multiplier = floatval($_POST['multiplier'] ?? 0);

    if (empty($jobName) || $multiplier <= 0) {
        echo json_encode(['success' => false, 'message' => 'All fields are required and multiplier must be greater than zero.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO jobs (job_name, multiplier) VALUES (?, ?)");
    $stmt->bind_param("sd", $jobName, $multiplier);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Job added successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add job.']);
    }

    $stmt->close();
    $conn->close();
}
?>
