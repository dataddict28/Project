<?php
session_start();
include 'config/database.php';
include 'includes/functions.php';

// If already logged in, go to dashboard
if (is_logged_in()) {
    header("Location: pages/dashboard.php");
    exit();
}

// Otherwise, redirect to login
header("Location: pages/login.php");
exit();
?>
