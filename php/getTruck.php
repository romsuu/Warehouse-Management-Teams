<?php
session_start();
require_once __DIR__ . '/db.php';

header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM trucks ORDER BY arrival_date DESC");
$trucks = [];

while ($row = $result->fetch_assoc()) {
    $trucks[] = $row;
}

echo json_encode(["success" => true, "trucks" => $trucks]);
$conn->close();
?>
