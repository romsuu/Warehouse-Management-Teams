<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] !== 2) {
    header('Location: ../index.html');
    exit;
}
include 'db.php';

$team_id = $_SESSION['user']['team_id'];

// Fetch employees and jobs for the dropdowns
$employees = $conn->query("SELECT id, name FROM employees WHERE team_id = $team_id");
$jobs = $conn->query("SELECT id, job_name FROM jobs");

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Data Entry</title>
    <link rel="stylesheet" href="../css/styles.css">
    <script src="../php/js/manageEntries.js"></script>
</head>
<body>
    <h1>Welcome, Team Leader</h1>
    <form id="dataForm">
        <label for="employee">Select Employee:</label>
        <select name="employee" id="employee">
            <?php while ($employee = $employees->fetch_assoc()): ?>
                <option value="<?= $employee['id']; ?>"><?= $employee['name']; ?></option>
            <?php endwhile; ?>
        </select>
        <label for="job">Select Job:</label>
        <select name="job" id="job">
            <?php while ($job = $jobs->fetch_assoc()): ?>
                <option value="<?= $job['id']; ?>"><?= $job['job_name']; ?></option>
            <?php endwhile; ?>
        </select>
        <label for="rows">Rows:</label>
        <input type="number" name="rows" id="rows">
        <button type="submit">Submit</button>
    </form>
</body>
</html>
