<?php
session_start();
require_once __DIR__ . '/db.php';

// Check if user is authenticated
if (!isset($_SESSION['user'])) {
    die('Unauthorized access.');
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment;filename=daily_report.csv');

$date = $_GET['date'] ?? date('Y-m-d');

// Sanitize the date input
$date = htmlspecialchars($date);

$output = fopen('php://output', 'w');
if ($output === false) {
    die('Failed to open output stream.');
}

fputcsv($output, ['Carrier', 'Truck Number', 'Trailer Number', 'Pallets', 'IBC', 'Arrival Date']);

$stmt = $conn->prepare("SELECT carrier, truck_number, trailer_number, pallets, ibc, arrival_date FROM trucks WHERE arrival_date = ?");
if ($stmt === false) {
    die('Failed to prepare statement.');
}

$bind = $stmt->bind_param("s", $date);
if ($bind === false) {
    die('Failed to bind parameters.');
}

$execute = $stmt->execute();
if ($execute === false) {
    die('Failed to execute statement.');
}

$result = $stmt->get_result();
if ($result === false) {
    die('Failed to get result set.');
}

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
$stmt->close();
$conn->close();
?>
