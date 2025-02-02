<?php
include 'db.php';
session_start();

$selectedMonth = $_GET['month'] ?? date('m');
$selectedYear = $_GET['year'] ?? date('Y');

$stmt = $conn->prepare("SELECT * FROM trucks WHERE MONTH(arrival_date) = ? AND YEAR(arrival_date) = ?");
$stmt->bind_param("ii", $selectedMonth, $selectedYear);
$stmt->execute();
$result = $stmt->get_result();

$trucks = [];
while ($row = $result->fetch_assoc()) {
    $trucks[] = $row;
}

echo json_encode(['success' => true, 'data' => $trucks]);
?>
