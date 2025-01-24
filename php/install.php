<?php
include 'php/db.php';

$sql = "
CREATE TABLE IF NOT EXISTS roles (
    id INT AUTO_INCREMENT PRIMARY KEY,
    role_name VARCHAR(255) NOT NULL UNIQUE
);

CREATE TABLE IF NOT EXISTS pincodes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    pincode VARCHAR(255) NOT NULL UNIQUE,
    role_id INT NOT NULL,
    FOREIGN KEY (role_id) REFERENCES roles(id) ON DELETE CASCADE
);

CREATE TABLE IF NOT EXISTS employees (
    id INT AUTO_INCREMENT PRIMARY KEY,
    employee_name VARCHAR(255) NOT NULL,
    team VARCHAR(255) NOT NULL
);

CREATE TABLE IF NOT EXISTS jobs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    job_name VARCHAR(255) NOT NULL,
    multiplier FLOAT NOT NULL
);

INSERT IGNORE INTO roles (role_name) VALUES
('Admin'), ('Team Leader'), ('Employee');
";

if ($conn->multi_query($sql)) {
    echo 'Database setup successfully.';
} else {
    echo 'Error setting up database: ' . $conn->error;
}

$conn->close();
?>
