<?php
include 'db.php';
session_start();

if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] !== 1) {
    die('Unauthorized access.');
}

$query = "SELECT * FROM error_logs ORDER BY created_at DESC";
$result = $conn->query($query);

echo "<h2>Error Logs</h2><table border='1'>";
echo "<tr><th>Timestamp</th><th>Error Message</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr><td>{$row['created_at']}</td><td>{$row['message']}</td></tr>";
}
echo "</table>";
?>
