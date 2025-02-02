<?php
session_start();
require_once __DIR__ . '/db.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=report.csv');

$output = fopen('php://output', 'w');
fputcsv($output, ['Employee Name', 'Job Name', 'Rows Processed', 'Multiplier', 'Total', 'Date']);

$stmt = $conn->prepare("SELECT e.employee_name, j.job_name, en.num_rows, en.multiplier, en.total, en.date 
                        FROM entries en
                        JOIN employees e ON en.employee_id = e.id
                        JOIN jobs j ON en.job_id = j.id");
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}
fclose($output);
$stmt->close();
$conn->close();
?>
