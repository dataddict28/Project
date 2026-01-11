<?php
require_once APP_PATH . '/models/User.php';

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    
    if (User::authenticate($email, $password)) {
        header('Location: ?page=dashboard');
        exit();
    } else {
        $error = 'Email ou mot de passe incorrect';
    }
}

require_once APP_PATH . '/views/login.php';
?>
