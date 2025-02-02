<?php
include 'db.php';

$searchQuery = $_GET['query'] ?? '';

$stmt = $conn->prepare("SELECT * FROM trucks WHERE truck_number LIKE ? OR carrier LIKE ?");
$searchTerm = "%$searchQuery%";
$stmt->bind_param("ss", $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$trucks = [];
while ($row = $result->fetch_assoc()) {
    $trucks[] = $row;
}

echo json_encode(['success' => true, 'data' => $trucks]);
?>
