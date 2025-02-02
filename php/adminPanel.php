<?php
session_start();
require_once __DIR__ . '/db.php';

// Check if the user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: /index.php?error=Please log in first.");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="/css/styles.css">
    <script src="/php/js/functions.js" defer></script>
</head>
<body>
    <h1>Admin Panel</h1>
    <a href="/php/auth.php?logout=true">Logout</a>

    <div class="tabs">
        <button onclick="showTab('manage-jobs')">Manage Jobs</button>
        <button onclick="showTab('manage-trucks')">Truck Management</button>
        <button onclick="showTab('manage-users')">Manage Users</button>
        <button onclick="showTab('manage-pincodes')">Manage Pincodes</button>
        <button onclick="showTab('manage-teams')">Manage Teams</button>
        <button onclick="showTab('manage-employees')">Manage Employees</button>
        <button onclick="showTab('export-reports')">Export Reports</button>
    </div>

    <div id="manage-jobs" class="tab-content"><?php include 'manageJobs.php'; ?></div>
    <div id="manage-trucks" class="tab-content"><?php include 'manageTrucks.php'; ?></div>
    <div id="manage-users" class="tab-content"><?php include 'manageUsers.php'; ?></div>
    <div id="manage-pincodes" class="tab-content"><?php include 'managePincodes.php'; ?></div>
    <div id="manage-teams" class="tab-content"><?php include 'manageTeams.php'; ?></div>
    <div id="manage-employees" class="tab-content"><?php include 'manageEmployees.php'; ?></div>
    <div id="export-reports" class="tab-content"><?php include 'exportReports.php'; ?></div>
</body>
</html>
