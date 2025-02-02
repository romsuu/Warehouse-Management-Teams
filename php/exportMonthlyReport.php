<?php
session_start();
require_once __DIR__ . '/db.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=monthly_report.csv');

$month = $_GET['month'] ?? date('m');
$year = $_GET['year'] ?? date('Y');

$output = fopen('php://output', 'w');
fputcsv($output, ['Carrier', 'Truck Number', 'Trailer Number', 'Pallets', 'IBC', 'Arrival Date']);

$stmt = $conn->prepare("SELECT carrier, truck_number, trailer_number, pallets, ibc, arrival_date FROM trucks WHERE MONTH(arrival_date) = ? AND YEAR(arrival_date) = ?");
$stmt->bind_param("ii", $month, $year);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
$stmt->close();
$conn->close();
?>
