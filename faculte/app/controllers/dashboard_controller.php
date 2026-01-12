<?php
require_once APP_PATH . '/models/User.php';
require_once BASE_PATH . '/includes/functions.php';

require_login();

$user_id = $_SESSION['user_id'];
$user = User::getById($user_id);
$role = $_SESSION['role'] ?? $user['role'];

$page_title = 'Tableau de bord';
$show_navbar = true;
$show_sidebar = true;
$current_page = 'dashboard';

ob_start();
include APP_PATH . '/views/dashboard_view.php';
$content = ob_get_clean();

include APP_PATH . '/views/layout.php';
?>
