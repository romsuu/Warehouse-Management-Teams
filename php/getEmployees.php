<?php
session_start();
include 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user'])) {
    echo json_encode(["success" => false, "message" => "Unauthorized"]);
    exit;
}

$team_id = $_SESSION['user']['team_id'];

$stmt = $conn->prepare("SELECT id, employee_name FROM employees WHERE team_id = ?");
$stmt->bind_param("i", $team_id);
$stmt->execute();
$result = $stmt->get_result();

$employees = [];
while ($row = $result->fetch_assoc()) {
    $employees[] = ["id" => $row["id"], "name" => $row["employee_name"]];
}

echo json_encode($employees);
$stmt->close();
$conn->close();
?>
