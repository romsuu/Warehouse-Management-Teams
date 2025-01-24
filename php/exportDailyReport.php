<?php
include 'db.php';

session_start();
if (!isset($_SESSION['user'])) {
    echo 'Unauthorized access.';
    exit;
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=daily_report.csv');

$team = $_SESSION['user']['team'];
$date = $_GET['date'] ?? date('Y-m-d');

$output = fopen('php://output', 'w');
fputcsv($output, ['Employee', 'Job', 'Rows', 'Multiplier', 'Total']);

$stmt = $conn->prepare("
    SELECT e.employee_name, j.job_name, en.num_rows, en.multiplier, en.total
    FROM entries en
    JOIN employees e ON en.employee_id = e.id
    JOIN jobs j ON en.job_id = j.id
    WHERE en.team = ? AND en.date = ?
");
$stmt->bind_param("ss", $team, $date);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
$stmt->close();
$conn->close();
?>
