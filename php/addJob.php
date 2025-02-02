<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $jobName = trim($_POST['jobName'] ?? '');
    $multiplier = floatval($_POST['multiplier'] ?? 0);

    // Basic validation
    if (empty($jobName) || $multiplier <= 0) {
        echo json_encode(['success' => false, 'message' => 'All fields are required and multiplier must be greater than zero.']);
        exit;
    }

    // Prepare the statement
    $stmt = $conn->prepare("INSERT INTO jobs (job_name, multiplier) VALUES (?, ?)");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare statement.']);
        exit;
    }

    // Bind parameters
    $bind = $stmt->bind_param("sd", $jobName, $multiplier);
    if ($bind === false) {
        echo json_encode(['success' => false, 'message' => 'Failed to bind parameters.']);
        exit;
    }

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Job added successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add job.']);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
