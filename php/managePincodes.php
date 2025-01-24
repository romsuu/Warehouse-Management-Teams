<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'Admin') {
    echo json_encode(['success' => false, 'message' => 'Unauthorized access.']);
    exit;
}

include 'db.php';

// Check if the request is POST for adding, editing, or deleting pincodes
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    // Add a new pincode
    if ($action === 'add') {
        $pincode = trim($_POST['pincode'] ?? '');
        $role_id = intval($_POST['role_id'] ?? 0);

        if (empty($pincode) || $role_id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid input.']);
            exit;
        }

        $stmt = $conn->prepare("INSERT INTO pincodes (pincode, role_id) VALUES (?, ?)");
        $stmt->bind_param("si", $pincode, $role_id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Pincode added successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to add pincode: ' . $stmt->error]);
        }

        $stmt->close();
    }

    // Edit an existing pincode
    elseif ($action === 'edit') {
        $id = intval($_POST['id'] ?? 0);
        $pincode = trim($_POST['pincode'] ?? '');
        $role_id = intval($_POST['role_id'] ?? 0);

        if ($id <= 0 || empty($pincode) || $role_id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid input.']);
            exit;
        }

        $stmt = $conn->prepare("UPDATE pincodes SET pincode = ?, role_id = ? WHERE id = ?");
        $stmt->bind_param("sii", $pincode, $role_id, $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Pincode updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to update pincode: ' . $stmt->error]);
        }

        $stmt->close();
    }

    // Delete a pincode
    elseif ($action === 'delete') {
        $id = intval($_POST['id'] ?? 0);

        if ($id <= 0) {
            echo json_encode(['success' => false, 'message' => 'Invalid pincode ID.']);
            exit;
        }

        $stmt = $conn->prepare("DELETE FROM pincodes WHERE id = ?");
        $stmt->bind_param("i", $id);

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Pincode deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete pincode: ' . $stmt->error]);
        }

        $stmt->close();
    }

    $conn->close();
    exit;
}

// Fetch pincodes for display
$result = $conn->query("
    SELECT p.id, p.pincode, r.role_name 
    FROM pincodes p 
    JOIN roles r ON p.role_id = r.id
");

if ($result->num_rows > 0) {
    $pincodes = $result->fetch_all(MYSQLI_ASSOC);
    echo json_encode(['success' => true, 'pincodes' => $pincodes]);
} else {
    echo json_encode(['success' => false, 'message' => 'No pincodes found.']);
}
$conn->close();
?>
