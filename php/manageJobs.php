<?php
include '../a2/php/db.php';

header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");
header('Content-Type: application/json');

$action = $_POST['action'] ?? ($_GET['action'] ?? '');

if ($action === 'get') {
    $query = "SELECT id, job_name, multiplier FROM jobs";
    $result = $conn->query($query);

    if (!$result) {
        echo json_encode(["success" => false, "message" => "Database query failed."]);
        exit;
    }

    $jobs = [];
    while ($row = $result->fetch_assoc()) {
        $jobs[] = $row;
    }

    echo json_encode(["success" => true, "jobs" => $jobs]);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && $action === 'add') {
    $jobName = trim($_POST['jobName'] ?? '');
    $multiplier = floatval($_POST['multiplier'] ?? 0);

    if (empty($jobName) || $multiplier <= 0) {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
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
    exit;
}
?>
