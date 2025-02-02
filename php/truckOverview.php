<?php
include 'db.php';

$query = "SELECT carrier, truck_number, trailer_number, pallets, ibc, arrival_date FROM trucks";
$result = $conn->query($query);

echo "<table border='1'>";
echo "<tr><th>Carrier</th><th>Truck Number</th><th>Trailer Number</th><th>Pallets</th><th>IBC</th><th>Arrival Date</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>
            <td>{$row['carrier']}</td>
            <td>{$row['truck_number']}</td>
            <td>{$row['trailer_number']}</td>
            <td>{$row['pallets']}</td>
            <td>{$row['ibc']}</td>
            <td>{$row['arrival_date']}</td>
          </tr>";
}
echo "</table>";
?>
