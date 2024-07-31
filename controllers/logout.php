<?php
session_start();

// Unset all session variables
session_unset();

// Destroy the session
session_destroy();

// Start a new session to set the status message
session_start();
$_SESSION['status'] = "You have logged out successfully";

// Redirect to the login page
header("Location: ../views/login.php");
exit();
?>
