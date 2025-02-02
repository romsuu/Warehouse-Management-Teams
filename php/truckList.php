<?php
include 'db.php';
session_start();

$teamId = $_SESSION['user']['team_id'];

$query = "SELECT * FROM trucks WHERE team_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $teamId);
$stmt->execute();
$result = $stmt->get_result();

$trucks = [];
while ($row = $result->fetch_assoc()) {
    $trucks[] = $row;
}

echo json_encode(['success' => true, 'data' => $trucks]);
?>
