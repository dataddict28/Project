<?php
require_once APP_PATH . '/models/User.php';

$user_id = $_SESSION['user_id'];
$user = User::getById($user_id);
$role = $user['role'];

// Load appropriate view based on role
require_once APP_PATH . '/views/dashboard.php';
?>
