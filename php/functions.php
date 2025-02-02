<?php
include 'db.php';

// Function to get all jobs
function getJobs() {
    global $conn;
    $query = "SELECT id, job_name, multiplier FROM jobs";
    return $conn->query($query)->fetch_all(MYSQLI_ASSOC);
}

// Function to get all pincodes
function getPincodes() {
    global $conn;
    $query = "SELECT * FROM pincodes";
    return $conn->query($query)->fetch_all(MYSQLI_ASSOC);
}

// Function to get all teams
function getTeams() {
    global $conn;
    $query = "SELECT id, team_name FROM teams";
    return $conn->query($query)->fetch_all(MYSQLI_ASSOC);
}

// Function to get all employees with team name
function getEmployees() {
    global $conn;
    $query = "SELECT employees.id, employees.employee_name, teams.team_name FROM employees 
              LEFT JOIN teams ON employees.team_id = teams.id";
    return $conn->query($query)->fetch_all(MYSQLI_ASSOC);
}

// Function to get leaderboard data
function getLeaderboard() {
    global $conn;
    $query = "SELECT employee_name, SUM(total) AS total_rows FROM entries GROUP BY employee_name ORDER BY total_rows DESC";
    return $conn->query($query)->fetch_all(MYSQLI_ASSOC);
}
?>
