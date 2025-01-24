<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $employeeName = trim($_POST['employeeName'] ?? '');
    $team = trim($_POST['team'] ?? '');

    if (empty($employeeName) || empty($team)) {
        echo json_encode(['success' => false, 'message' => 'Invalid input.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO employees (employee_name, team) VALUES (?, ?)");
    $stmt->bind_param("ss", $employeeName, $team);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Employee added successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to add employee.']);
    }

    $stmt->close();
    exit;
}

// Fetch employees for display
$result = $conn->query("SELECT * FROM employees");
while ($row = $result->fetch_assoc()) {
    echo '<tr>';
    echo '<td>' . htmlspecialchars($row['employee_name']) . '</td>';
    echo '<td>' . htmlspecialchars($row['team']) . '</td>';
    echo '<td><button class="delete-employee" data-id="' . $row['id'] . '">Delete</button></td>';
    echo '</tr>';
}
$conn->close();
?>
