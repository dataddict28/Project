<?php
require_once APP_PATH . '/models/User.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $role = $_POST['role'] ?? '';
    
    if ($password !== $confirm_password) {
        $error = 'Les mots de passe ne correspondent pas';
    } elseif (empty($nom) || empty($email) || empty($password) || empty($role)) {
        $error = 'Tous les champs sont requis';
    } else {
        if (User::register($nom, $email, $password, $role)) {
            $success = 'Inscription réussie! Vous pouvez maintenant vous connecter.';
        } else {
            $error = 'Cet email est déjà utilisé';
        }
    }
}

require_once APP_PATH . '/views/register.php';
?>
