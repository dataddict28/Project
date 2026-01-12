<?php
require_once APP_PATH . '/models/User.php';

$error = '';
$success = '';
$page_title = 'Inscription';
$show_navbar = false;
$show_sidebar = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    $confirm_mot_de_passe = $_POST['confirm_mot_de_passe'] ?? '';
    $role = $_POST['role'] ?? 'etudiant';
    
    if (empty($nom) || empty($email) || empty($mot_de_passe)) {
        $error = 'Tous les champs sont requis!';
    } elseif ($mot_de_passe !== $confirm_mot_de_passe) {
        $error = 'Les mots de passe ne correspondent pas!';
    } elseif (strlen($mot_de_passe) < 6) {
        $error = 'Le mot de passe doit contenir au moins 6 caractères!';
    } else {
        if (User::register($nom, $email, $mot_de_passe, $role)) {
            $success = 'Inscription réussie! Veuillez vous connecter.';
            header("Refresh: 2; url=?page=login");
        } else {
            $error = 'Cet email existe déjà!';
        }
    }
}

ob_start();
include APP_PATH . '/views/register_view.php';
$content = ob_get_clean();

include APP_PATH . '/views/layout.php';
?>
