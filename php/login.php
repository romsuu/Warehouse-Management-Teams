<?php
session_start();
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    die("Invalid request method.");
}

$pincode = $_POST['pincode'] ?? '';
if (empty($pincode)) {
    header("Location: /index.php?error=Pincode is required");
    exit;
}

$stmt = $conn->prepare("SELECT id, role_id, team_id FROM pincodes WHERE pincode = ?");
$stmt->bind_param("s", $pincode);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    header("Location: /index.php?error=Invalid pincode");
    exit;
}

$user = $result->fetch_assoc();
$_SESSION['user'] = [
    'id' => $user['id'],
    'role_id' => $user['role_id'],
    'team_id' => $user['team_id']
];

header("Location: /php/adminPanel.php");
exit;
?>
