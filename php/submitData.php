<?php
session_start();
require_once __DIR__ . '/db.php';

// Ensure the user is logged in
if (!isset($_SESSION['user'])) {
    exit(json_encode(['success' => false, 'message' => 'Unauthorized access.']));
}

// Check if Admin
$isAdmin = $_SESSION['user']['role_id'] === 1; // Admin role ID

// Get POST data
$employeeId = intval($_POST['employee'] ?? 0);
$jobId = intval($_POST['job'] ?? 0);
$numRows = intval($_POST['rows'] ?? 0);
$teamId = $_SESSION['user']['team_id'] ?? null;

// Validate input
if ($employeeId <= 0 || $jobId <= 0 || $numRows <= 0) {
    exit(json_encode(['success' => false, 'message' => 'Invalid input data.']));
}

// Get job multiplier
$stmt = $conn->prepare("SELECT multiplier FROM jobs WHERE id = ?");
if (!$stmt) {
    exit(json_encode(['success' => false, 'message' => 'Failed to prepare statement.']));
}
$stmt->bind_param("i", $jobId);
$stmt->execute();
$stmt->bind_result($multiplier);
$stmt->fetch();
$stmt->close();

if (!$multiplier) {
    exit(json_encode(['success' => false, 'message' => 'Invalid job selected.']));
}

// Calculate total
$total = $numRows * $multiplier;

// Admin can submit for all employees, Team Leaders only for their team
if (!$isAdmin) {
    $stmt = $conn->prepare("SELECT team_id FROM employees WHERE id = ?");
    if (!$stmt) {
        exit(json_encode(['success' => false, 'message' => 'Failed to prepare statement.']));
    }
    $stmt->bind_param("i", $employeeId);
    $stmt->execute();
    $stmt->bind_result($employeeTeamId);
    $stmt->fetch();
    $stmt->close();

    if ($employeeTeamId !== $teamId) {
        exit(json_encode(['success' => false, 'message' => 'You can only submit data for your own team.']));
    }
}

// Insert the entry
$stmt = $conn->prepare("INSERT INTO entries (employee_id, job_id, num_rows, multiplier, total, date, team_id) VALUES (?, ?, ?, ?, ?, CURDATE(), ?)");
if (!$stmt) {
    exit(json_encode(['success' => false, 'message' => 'Failed to prepare statement.']));
}
$stmt->bind_param("iiiddi", $employeeId, $jobId, $numRows, $multiplier, $total, $teamId);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Data submitted successfully.']);
} else {
    echo json_encode(['success' => false, 'message' => 'Failed to submit data.']);
}

$stmt->close();
$conn->close();
?>
