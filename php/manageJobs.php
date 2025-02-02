<?php
session_start();
require_once __DIR__ . '/db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['jobName'])) {
        $jobName = trim($_POST['jobName']);
        $multiplier = floatval($_POST['multiplier']);

        if (!empty($jobName) && $multiplier > 0) {
            $stmt = $conn->prepare("INSERT INTO jobs (job_name, multiplier) VALUES (?, ?)");
            $stmt->bind_param("sd", $jobName, $multiplier);
            if ($stmt->execute()) {
                echo json_encode(["success" => true, "message" => "Job added successfully."]);
            } else {
                echo json_encode(["success" => false, "message" => "Failed to add job."]);
            }
        } else {
            echo json_encode(["success" => false, "message" => "Invalid job data."]);
        }
        exit;
    }

    if (isset($_POST['editJobId'])) {
        $jobId = intval($_POST['editJobId']);
        $jobName = trim($_POST['editJobName']);
        $multiplier = floatval($_POST['editMultiplier']);

        $stmt = $conn->prepare("UPDATE jobs SET job_name = ?, multiplier = ? WHERE id = ?");
        $stmt->bind_param("sdi", $jobName, $multiplier, $jobId);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Job updated successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to update job."]);
        }
        exit;
    }

    if (isset($_POST['deleteJobId'])) {
        $jobId = intval($_POST['deleteJobId']);
        $stmt = $conn->prepare("DELETE FROM jobs WHERE id = ?");
        $stmt->bind_param("i", $jobId);
        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Job deleted successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to delete job."]);
        }
        exit;
    }
}

$result = $conn->query("SELECT * FROM jobs");
$jobs = [];
while ($job = $result->fetch_assoc()) {
    $jobs[] = $job;
}
echo json_encode(["success" => true, "jobs" => $jobs]);
?>
