<?php
session_start();

// Set base path for includes
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');

// Load core includes
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/includes/functions.php';

// Simple router to handle incoming requests
$request = $_GET['page'] ?? 'dashboard';
$controller_file = APP_PATH . '/controllers/' . $request . '_controller.php';

// Check if user is logged in
$is_logged_in = is_logged_in();

// Route to login if not authenticated (except for login/register pages)
if (!$is_logged_in && !in_array($request, ['login', 'register', 'logout'])) {
    header('Location: ?page=login');
    exit();
}

// Check if controller exists
if (file_exists($controller_file)) {
    require_once $controller_file;
} else {
    // Default to dashboard or login based on auth status
    if ($is_logged_in) {
        require_once APP_PATH . '/controllers/dashboard_controller.php';
    } else {
        require_once APP_PATH . '/controllers/login_controller.php';
    }
}
?>
