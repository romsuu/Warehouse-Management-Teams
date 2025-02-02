<?php
session_start();
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user']['role_id']) || $_SESSION['user']['role_id'] !== 1) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit;
}

// Fetch Users
$users = $conn->query("SELECT id, username, role_id FROM users ORDER BY username ASC");

// Handle User Role Update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['user_id'], $_POST['role_id'])) {
    $userId = intval($_POST['user_id']);
    $roleId = intval($_POST['role_id']);

    $stmt = $conn->prepare("UPDATE users SET role_id = ? WHERE id = ?");
    $stmt->bind_param("ii", $roleId, $userId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User role updated successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to update user role."]);
    }
    exit;
}

// Handle User Deletion
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_user_id'])) {
    $userId = intval($_POST['delete_user_id']);
    
    $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
    $stmt->bind_param("i", $userId);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "User deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete user."]);
    }
    exit;
}
?>

<h2>Manage Users</h2>
<table>
    <thead><tr><th>Username</th><th>Role</th><th>Actions</th></tr></thead>
    <tbody>
        <?php while ($user = $users->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($user['username']) ?></td>
                <td>
                    <select class="update-role" data-id="<?= $user['id'] ?>">
                        <option value="1" <?= $user['role_id'] == 1 ? "selected" : "" ?>>Admin</option>
                        <option value="2" <?= $user['role_id'] == 2 ? "selected" : "" ?>>Team Leader</option>
                        <option value="3" <?= $user['role_id'] == 3 ? "selected" : "" ?>>Employee</option>
                    </select>
                </td>
                <td><button class="delete-user" data-id="<?= $user['id'] ?>">Delete</button></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
