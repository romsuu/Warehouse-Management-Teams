<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user'])) {
    die('Unauthorized access.');
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=truck_report.csv');

$output = fopen('php://output', 'w');
fputcsv($output, ['Carrier', 'Truck Number', 'Trailer Number', 'Pallets', 'IBC', 'Arrival Date', 'Status']);

$query = "SELECT * FROM trucks";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
$conn->close();
?>
