<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeName = trim($_POST['employeeName'] ?? '');
    $teamId = trim($_POST['teamId'] ?? '');

    if (empty($employeeName) || empty($teamId)) {
        echo json_encode(['success' => false, 'message' => 'Invalid employee data.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO employees (employee_name, team_id) VALUES (?, ?)");
    $stmt->bind_param("si", $employeeName, $teamId);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Employee added successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add employee.']);
    }

    $stmt->close();
}
$conn->close();
?>
