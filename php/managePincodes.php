<?php
session_start();
require_once __DIR__ . '/db.php';

header("Content-Type: application/json");

// Ensure the user has permission to manage pincodes
if (!isset($_SESSION['user']['role_id']) || $_SESSION['user']['role_id'] !== 1) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit;
}

// Handle Adding Pincode
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pincode'], $_POST['role_id'])) {
    $pincode = trim($_POST['pincode']);
    $roleId = intval($_POST['role_id']);

    if (empty($pincode) || $roleId <= 0) {
        echo json_encode(["success" => false, "message" => "Invalid pincode data."]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO pincodes (pincode, role_id) VALUES (?, ?)");
    $stmt->bind_param("si", $pincode, $roleId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Pincode added successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add pincode."]);
    }
    exit;
}

// Handle Deleting Pincode
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['deletePincodeId'])) {
    $pincodeId = intval($_POST['deletePincodeId']);
    $stmt = $conn->prepare("DELETE FROM pincodes WHERE id = ?");
    $stmt->bind_param("i", $pincodeId);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Pincode deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete pincode."]);
    }
    exit;
}

// Fetch Pincode List
$pincodes = $conn->query("SELECT * FROM pincodes");
?>
<h2>Manage Pincodes</h2>
<form id="addPincodeForm">
    <input type="text" name="pincode" placeholder="New Pincode" required>
    <select name="role_id">
        <option value="1">Admin</option>
        <option value="2">Team Leader</option>
        <option value="3">Employee</option>
    </select>
    <button type="submit">Add Pincode</button>
</form>
<table>
    <thead><tr><th>Pincode</th><th>Role</th><th>Actions</th></tr></thead>
    <tbody id="pincodesTable">
        <?php while ($pincode = $pincodes->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($pincode['pincode']) ?></td>
                <td><?= htmlspecialchars($pincode['role_id']) ?></td>
                <td><button class="delete-pincode" data-id="<?= $pincode['id'] ?>">Delete</button></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
