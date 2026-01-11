<?php
require_once APP_PATH . '/models/Etudiant.php';
require_once APP_PATH . '/models/Enseignant.php';

require_role('admin');

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $date_naissance = $_POST['date_naissance'] ?? null;
    $adresse = $_POST['adresse'] ?? null;
    $telephone = $_POST['telephone'] ?? null;
    
    if (empty($nom) || empty($email)) {
        $error = "Nom et email sont requis!";
    } else {
        if (Etudiant::create($nom, $email, $date_naissance, $adresse, $telephone)) {
            $success = "Étudiant ajouté avec succès!";
        } else {
            $error = "Erreur lors de l'ajout!";
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (Etudiant::delete($id)) {
        $success = "Étudiant supprimé!";
    }
}

$etudiants = Etudiant::getAll();
$user = User::getById($_SESSION['user_id']);
$role = $user['role'];

require_once APP_PATH . '/views/etudiants.php';
?>
