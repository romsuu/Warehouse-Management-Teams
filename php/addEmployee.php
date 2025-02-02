<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeName = trim($_POST['employeeName'] ?? '');
    $teamId = trim($_POST['teamId'] ?? '');

    // Basic validation
    if (empty($employeeName) || empty($teamId)) {
        echo json_encode(['success' => false, 'message' => 'Invalid employee data.']);
        exit;
    }

    // Prepare the statement
    $stmt = $conn->prepare("INSERT INTO employees (employee_name, team_id) VALUES (?, ?)");
    if ($stmt === false) {
        echo json_encode(['success' => false, 'message' => 'Failed to prepare statement.']);
        exit;
    }

    // Bind parameters
    $bind = $stmt->bind_param("si", $employeeName, $teamId);
    if ($bind === false) {
        echo json_encode(['success' => false, 'message' => 'Failed to bind parameters.']);
        exit;
    }

    // Execute the statement
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Employee added successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add employee.']);
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
