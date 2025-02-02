<?php
session_start();
require_once __DIR__ . '/db.php';

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=daily_report.csv');

$date = $_GET['date'] ?? date('Y-m-d');

$output = fopen('php://output', 'w');
fputcsv($output, ['Carrier', 'Truck Number', 'Trailer Number', 'Pallets', 'IBC', 'Arrival Date']);

$stmt = $conn->prepare("SELECT carrier, truck_number, trailer_number, pallets, ibc, arrival_date FROM trucks WHERE arrival_date = ?");
$stmt->bind_param("s", $date);
$stmt->execute();
$result = $stmt->get_result();

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
$stmt->close();
$conn->close();
?>
