<?php
session_start();

// Check if the logout parameter is set
if (isset($_GET['logout'])) {
    // Unset all session variables
    session_unset();
    
    // Destroy the session
    session_destroy();
    
    // Redirect to the index page
    header("Location: /index.php");
    exit;
}
?>
