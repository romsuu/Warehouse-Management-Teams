<?php
session_start();
require_once __DIR__ . '/db.php';

if (!isset($_SESSION['user']['role_id']) || $_SESSION['user']['role_id'] !== 1) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit;
}

// Fetch Teams
$teams = $conn->query("SELECT id, team_name FROM teams ORDER BY team_name ASC");

// Handle Add Team
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['team_name'])) {
    $teamName = trim($_POST['team_name']);
    
    if (empty($teamName)) {
        echo json_encode(["success" => false, "message" => "Team name cannot be empty."]);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO teams (team_name) VALUES (?)");
    $stmt->bind_param("s", $teamName);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Team added successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to add team."]);
    }
    exit;
}

// Handle Delete Team
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_team_id'])) {
    $teamId = intval($_POST['delete_team_id']);
    
    $stmt = $conn->prepare("DELETE FROM teams WHERE id = ?");
    $stmt->bind_param("i", $teamId);
    
    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Team deleted successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to delete team."]);
    }
    exit;
}
?>

<h2>Manage Teams</h2>
<form id="addTeamForm">
    <input type="text" name="team_name" placeholder="Enter Team Name" required>
    <button type="submit">Add Team</button>
</form>
<table>
    <thead><tr><th>Team Name</th><th>Actions</th></tr></thead>
    <tbody>
        <?php while ($team = $teams->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($team['team_name']) ?></td>
                <td><button class="delete-team" data-id="<?= $team['id'] ?>">Delete</button></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
