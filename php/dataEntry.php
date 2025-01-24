<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] !== 2) {
    header('Location: ../index.html');
    exit;
}
include 'db.php';

$team_id = $_SESSION['user']['team_id'];
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
        <select name="employee" id="employee"></select>
        <label for="job">Select Job:</label>
        <select name="job" id="job"></select>
        <label for="rows">Rows:</label>
        <input type="number" name="rows" id="rows">
        <button type="submit">Submit</button>
    </form>
</body>
</html>
