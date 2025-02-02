<?php
session_start();
require_once __DIR__ . '/db.php';

// Ensure user is logged in
if (!isset($_SESSION['user'])) {
    header("Location: /index.php?error=Please log in first.");
    exit;
}

$isAdmin = $_SESSION['user']['role_id'] === 1;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="/css/styles.css">
    <script src="/js/functions.js" defer></script>
</head>
<body>
    <h1>Admin Panel</h1>
    <a href="/php/auth.php?logout=true">Logout</a>

    <div class="tabs">
        <button onclick="showTab('manage-jobs')">Manage Jobs</button>
        <button onclick="showTab('manage-trucks')">Manage Trucks</button>
        <button onclick="showTab('manage-pincodes')">Manage Pincodes</button>
        <button onclick="showTab('manage-employees')">Manage Employees</button>
        <button onclick="showTab('manage-teams')">Manage Teams</button>
        <button onclick="showTab('manage-users')">Manage Users</button>
        <button onclick="showTab('submit-rows')">Submit Rows</button>
        <button onclick="showTab('export-reports')">Export Reports</button>
        <button onclick="showTab('settings')">Settings</button>
    </div>

    <div id="manage-jobs" class="tab-content"><?php include 'manageJobs.php'; ?></div>
    <div id="manage-trucks" class="tab-content"><?php include 'manageTrucks.php'; ?></div>
    <div id="manage-pincodes" class="tab-content"><?php include 'managePincodes.php'; ?></div>
    <div id="manage-employees" class="tab-content"><?php include 'manageEmployees.php'; ?></div>
    <div id="manage-teams" class="tab-content"><?php include 'manageTeams.php'; ?></div>
    <div id="manage-users" class="tab-content"><?php include 'manageUsers.php'; ?></div>
    <div id="submit-rows" class="tab-content"><?php include 'submitData.php'; ?></div>
    <div id="export-reports" class="tab-content"><?php include 'exportReports.php'; ?></div>
    <div id="settings" class="tab-content"><?php include 'settings.php'; ?></div>

    <script>
        function showTab(tabId) {
            document.querySelectorAll('.tab-content').forEach(tab => tab.style.display = 'none');
            document.getElementById(tabId).style.display = 'block';
        }
        showTab('manage-jobs'); // Default tab
    </script>
</body>
</html>
