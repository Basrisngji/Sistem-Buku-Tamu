<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    // Unset session variables and destroy the session
    session_unset();
    session_destroy();
    // Redirect to the login page
    header('Location: login.php');
    exit();
}

// If accessed directly, redirect to login
header('Location: login.php');
exit();
?>
