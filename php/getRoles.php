<?php
include 'db.php';

$result = $conn->query("SELECT * FROM roles");
if ($result->num_rows > 0) {
    $roles = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode(['success' => true, 'roles' => $roles]);
} else {
    echo json_encode(['success' => false, 'message' => 'No roles found.']);
}
$conn->close();
?>
