<?php
include 'db.php';
session_start();

// Check if user is authenticated and has the appropriate role
if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] !== 1) {
    die('Unauthorized access.');
}

$query = "SELECT * FROM error_logs ORDER BY created_at DESC";
$result = $conn->query($query);

if ($result === false) {
    die('Error fetching error logs.');
}

echo "<h2>Error Logs</h2><table border='1'>";
echo "<tr><th>Timestamp</th><th>Error Message</th></tr>";

while ($row = $result->fetch_assoc()) {
    $timestamp = htmlspecialchars($row['created_at']);
    $message = htmlspecialchars($row['message']);
    echo "<tr><td>{$timestamp}</td><td>{$message}</td></tr>";
}
echo "</table>";

$conn->close();
?>
