<?php
session_start();
require_once __DIR__ . '/db.php';

header('Content-Type: application/json');

$result = $conn->query("SELECT * FROM teams ORDER BY id ASC");
$teams = [];

while ($row = $result->fetch_assoc()) {
    $teams[] = $row;
}

echo json_encode(["success" => true, "teams" => $teams]);
$conn->close();
?>
