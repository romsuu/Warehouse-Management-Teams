<?php
include 'db.php';

session_start();
if (!isset($_SESSION['user'])) {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit;
}

$team = $_SESSION['user']['team'];
$date = $_GET['date'] ?? date('Y-m-d');

$stmt = $conn->prepare("
    SELECT en.id, e.employee_name, j.job_name, en.num_rows, en.multiplier, en.total
    FROM entries en
    JOIN employees e ON en.employee_id = e.id
    JOIN jobs j ON en.job_id = j.id
    WHERE en.team = ? AND en.date = ?
");
$stmt->bind_param("ss", $team, $date);
$stmt->execute();
$result = $stmt->get_result();

$entries = [];
while ($row = $result->fetch_assoc()) {
    $entries[] = $row;
}

echo json_encode(['success' => true, 'data' => $entries]);

$stmt->close();
$conn->close();
?>
