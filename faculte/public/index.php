<?php
session_start();

// Set base path for includes
define('BASE_PATH', dirname(__DIR__));
define('APP_PATH', BASE_PATH . '/app');
$base_url = str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME']));
define('BASE_URL', rtrim($base_url, '/public'));
// Define assets path relative to public/index.php
define('ASSETS_URL', '../assets');

// Load core includes
require_once BASE_PATH . '/config/database.php';
require_once BASE_PATH . '/includes/functions.php';

// Initialize models with database connection
require_once APP_PATH . '/models/User.php';
require_once APP_PATH . '/models/Etudiant.php';
require_once APP_PATH . '/models/Enseignant.php';
require_once APP_PATH . '/models/Cours.php';
require_once APP_PATH . '/models/Absence.php';
require_once APP_PATH . '/models/Inscription.php';
require_once APP_PATH . '/models/Paiement.php';

User::setDB($conn);
Etudiant::setDB($conn);
Enseignant::setDB($conn);
Cours::setDB($conn);
Absence::setDB($conn);
Inscription::setDB($conn);
Paiement::setDB($conn);

// Simple router to handle incoming requests
$request = $_GET['page'] ?? 'dashboard';
$controller_file = APP_PATH . '/controllers/' . $request . '_controller.php';

// Check if user is logged in
$is_logged_in = is_logged_in();

// Route to login if not authenticated (except for login/register/about pages)
if (!$is_logged_in && !in_array($request, ['login', 'register', 'logout', 'about'])) {
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
