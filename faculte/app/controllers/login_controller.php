<?php
require_once APP_PATH . '/models/User.php';

$error = '';
$page_title = 'Connexion';
$show_navbar = false;
$show_sidebar = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    
    if (empty($email) || empty($mot_de_passe)) {
        $error = 'Email et mot de passe requis!';
    } else {
        if (User::authenticate($email, $mot_de_passe)) {
            header('Location: ?page=dashboard');
            exit();
        } else {
            $error = 'Email ou mot de passe incorrect!';
        }
    }
}

ob_start();
include APP_PATH . '/views/login_view.php';
$content = ob_get_clean();

include APP_PATH . '/views/layout.php';
?>
