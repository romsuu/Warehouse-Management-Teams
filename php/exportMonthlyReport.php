<?php
include 'db.php';

session_start();
if (!isset($_SESSION['user'])) {
    echo 'Unauthorized access.';
    exit;
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=monthly_report.csv');

$team = $_SESSION['user']['team'];
$month = $_GET['month'] ?? date('m');
$year = $_GET['year'] ?? date('Y');

$output = fopen('php://output', 'w');
fputcsv($output, ['Employee', 'Date', 'Rows Exceeding 150']);

$stmt = $conn->prepare("
    SELECT e.employee_name, en.date, SUM(en.total - 150) AS excess_rows
    FROM entries en
    JOIN employees e ON en.employee_id = e.id
    WHERE en.team = ? AND MONTH(en.date) = ? AND YEAR(en.date) = ? AND en.total > 150
    GROUP BY e.employee_name, en.date
");
$stmt->bind_param("sii", $team, $month, $year);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
$stmt->close();
$conn->close();
?>
