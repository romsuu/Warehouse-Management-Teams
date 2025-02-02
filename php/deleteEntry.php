<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'DELETE') {
    parse_str(file_get_contents("php://input"), $_DELETE);
    $entryId = intval($_DELETE['id']);

    if ($entryId > 0) {
        $stmt = $conn->prepare("DELETE FROM entries WHERE id = ?");
        if ($stmt === false) {
            echo json_encode(['success' => false, 'message' => 'Failed to prepare statement.']);
            exit;
        }

        $bind = $stmt->bind_param("i", $entryId);
        if ($bind === false) {
            echo json_encode(['success' => false, 'message' => 'Failed to bind parameters.']);
            exit;
        }

        if ($stmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Entry deleted successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Failed to delete entry.']);
        }

        $stmt->close();
    } else {
        echo json_encode(['success' => false, 'message' => 'Invalid entry ID.']);
    }

    $conn->close();
}
?>
