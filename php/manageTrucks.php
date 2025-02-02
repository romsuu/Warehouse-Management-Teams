<?php
session_start();
require_once __DIR__ . '/db.php';

header("Content-Type: application/json");

// Ensure user has admin rights
if (!isset($_SESSION['user']['role_id']) || $_SESSION['user']['role_id'] !== 1) {
    echo json_encode(["success" => false, "message" => "Unauthorized access."]);
    exit;
}

// Handle Adding Truck
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['carrier'], $_POST['truckNumber'], $_POST['trailerNumber'], $_POST['pallets'], $_POST['ibc'], $_POST['arrivalDate'])) {
    $carrier = trim($_POST['carrier']);
    $truckNumber = trim($_POST['truckNumber']);
    $trailerNumber = trim($_POST['trailerNumber']);
    $pallets = intval($_POST['pallets']);
    $ibc = intval($_POST['ibc']);
    $arrivalDate = $_POST['arrivalDate'];

    $stmt = $conn->prepare("INSERT INTO trucks (carrier, truck_number, trailer_number, pallets, ibc, arrival_date) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("sssdds", $carrier, $truckNumber, $trailerNumber, $pallets, $ibc, $arrivalDate);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Truck registered successfully."]);
    } else {
        echo json_encode(["success" => false, "message" => "Failed to register truck."]);
    }
    exit;
}

// Fetch Trucks List
$trucks = $conn->query("SELECT * FROM trucks");
?>
<h2>Truck Management</h2>
<form id="addTruckForm">
    <input type="text" name="carrier" placeholder="Carrier" required>
    <input type="text" name="truckNumber" placeholder="Truck Number" required>
    <input type="text" name="trailerNumber" placeholder="Trailer Number" required>
    <input type="number" name="pallets" placeholder="Pallets" required>
    <input type="number" name="ibc" placeholder="IBC" required>
    <input type="date" name="arrivalDate" required>
    <button type="submit">Register Truck</button>
</form>
<table>
    <thead><tr><th>Carrier</th><th>Truck Number</th><th>Trailer Number</th><th>Pallets</th><th>IBC</th><th>Arrival Date</th><th>Actions</th></tr></thead>
    <tbody id="trucksTable">
        <?php while ($truck = $trucks->fetch_assoc()): ?>
            <tr>
                <td><?= htmlspecialchars($truck['carrier']) ?></td>
                <td><?= htmlspecialchars($truck['truck_number']) ?></td>
                <td><?= htmlspecialchars($truck['trailer_number']) ?></td>
                <td><?= $truck['pallets'] ?></td>
                <td><?= $truck['ibc'] ?></td>
                <td><?= $truck['arrival_date'] ?></td>
                <td><button class="delete-truck" data-id="<?= $truck['id'] ?>">Delete</button></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>
