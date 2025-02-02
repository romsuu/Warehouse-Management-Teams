<?php
session_start();
require_once __DIR__ . '/db.php';

header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM pincodes ORDER BY id ASC");
$pincodes = [];

while ($row = $result->fetch_assoc()) {
    $pincodes[] = $row;
}

echo json_encode(["success" => true, "pincodes" => $pincodes]);
$conn->close();
?>
