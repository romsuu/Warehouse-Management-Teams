<?php
session_start();
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['employeeName'])) {
        $employeeName = trim($_POST['employeeName']);
        $teamId = intval($_POST['teamId']);

        if (!empty($employeeName) && $teamId > 0) {
            $stmt = $conn->prepare("INSERT INTO employees (employee_name, team_id) VALUES (?, ?)");
            $stmt->bind_param("si", $employeeName, $teamId);
            
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Employee added successfully."]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to add employee."]);
            }
        }
        exit;
    }
}
$result = $conn->query("SELECT * FROM employees");
$employees = [];
while ($employee = $result->fetch_assoc()) {
    $employees[] = $employee;
}
echo json_encode(["success" => true, "employees" => $employees]);
?>
