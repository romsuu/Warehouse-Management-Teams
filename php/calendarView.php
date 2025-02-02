<?php
include 'db.php';
session_start();

// Validate and sanitize input
$selectedMonth = isset($_GET['month']) ? intval($_GET['month']) : date('m');
$selectedYear = isset($_GET['year']) ? intval($_GET['year']) : date('Y');

// Prepare the statement
$stmt = $conn->prepare("SELECT * FROM trucks WHERE MONTH(arrival_date) = ? AND YEAR(arrival_date) = ?");
if ($stmt === false) {
    echo json_encode(['success' => false, 'message' => 'Failed to prepare statement.']);
    exit;
}

// Bind parameters
$bind = $stmt->bind_param("ii", $selectedMonth, $selectedYear);
if ($bind === false) {
    echo json_encode(['success' => false, 'message' => 'Failed to bind parameters.']);
    exit;
}

// Execute the statement
$stmt->execute();
$result = $stmt->get_result();

$trucks = [];
while ($row = $result->fetch_assoc()) {
    $trucks[] = $row;
}

// Close the statement
$stmt->close();

// Output the result
echo json_encode(['success' => true, 'data' => $trucks]);

// Close the connection
$conn->close();
?>
