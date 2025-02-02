<?php
session_start();
require_once __DIR__ . '/db.php';

header('Content-Type: application/json');

$result = $conn->query("SELECT employees.id, employees.employee_name, teams.team_name FROM employees LEFT JOIN teams ON employees.team_id = teams.id ORDER BY employees.id ASC");
$employees = [];

while ($row = $result->fetch_assoc()) {
    $employees[] = $row;
}

echo json_encode(["success" => true, "employees" => $employees]);
$conn->close();
?>
