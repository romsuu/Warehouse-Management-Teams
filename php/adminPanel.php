<?php
session_start();
if (!isset($_SESSION['user']) || $_SESSION['user']['role_id'] !== 1) {
    header('Location: ../index.html');
    exit;
}
include '../a2/php/db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="/a2/css/styles.css">
    <script src="/a2/php/js/manageJobs.js" defer></script>
    <script src="/a2/php/js/managePincodes.js" defer></script>
    <script src="/a2/php/js/manageTeams.js" defer></script>
    <script src="/a2/php/js/submitRows.js" defer></script>
    <script src="/a2/php/js/leaderboard.js" defer></script>
    <script src="/a2/php/js/exportReports.js" defer></script>
</head>
<body>
    <div class="container">
        <h1>Admin Panel</h1>
        <button onclick="location.href='logout.php'">Logout</button>

        <div class="tabs">
            <button class="tab-link active" data-tab="manage-jobs">Manage Jobs</button>
            <button class="tab-link" data-tab="manage-pincodes">Manage Pincodes</button>
            <button class="tab-link" data-tab="manage-teams">Manage Teams</button>
            <button class="tab-link" data-tab="submit-rows">Submit Rows</button>
            <button class="tab-link" data-tab="leaderboard">Leaderboard</button>
            <button class="tab-link" data-tab="export-reports">Export Reports</button>
        </div>

        <!-- Manage Jobs Section -->
        <div id="manage-jobs" class="tab-content active">
            <h2>Manage Jobs</h2>
            <form id="addJobForm">
                <label for="jobName">Job Name:</label>
                <input type="text" id="jobName" name="jobName" required>
                <label for="multiplier">Multiplier:</label>
                <input type="number" id="multiplier" name="multiplier" step="0.1" required>
                <button type="submit">Add Job</button>
            </form>
            <table>
                <thead><tr><th>Job Name</th><th>Multiplier</th><th>Actions</th></tr></thead>
                <tbody id="jobsTable"></tbody>
            </table>
        </div>
    </div>
</body>
</html>
