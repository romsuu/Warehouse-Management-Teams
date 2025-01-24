<?php
include 'db.php';

session_start();
if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeId = intval($_POST['employee']);
    $jobId = intval($_POST['job']);
    $numRows = intval($_POST['rows']);
    $team = $_SESSION['user']['team'];

    $stmt = $conn->prepare("SELECT multiplier FROM jobs WHERE id = ?");
    $stmt->bind_param("i", $jobId);
    $stmt->execute();
    $stmt->bind_result($multiplier);
    $stmt->fetch();
    $stmt->close();

    $total = $numRows * $multiplier;

    $stmt = $conn->prepare("INSERT INTO entries (employee_id, job_id, num_rows, multiplier, total, date, team) VALUES (?, ?, ?, ?, ?, CURDATE(), ?)");
    $stmt->bind_param("iiidss", $employeeId, $jobId, $numRows, $multiplier, $total, $team);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Data inserted successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to insert data.']);
    }

    $stmt->close();
    $conn->close();
}
?>
