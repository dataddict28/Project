<?php
require_once APP_PATH . '/models/Etudiant.php';
require_once BASE_PATH . '/includes/functions.php';

require_role('admin');

$error = '';
$success = '';
$page_title = 'Gestion des Étudiants';
$show_navbar = true;
$show_sidebar = true;
$current_page = 'etudiants';

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
        header("Location: ?page=etudiants");
        exit();
    }
}

$etudiants = Etudiant::getAll();

ob_start();
include APP_PATH . '/views/etudiants_view.php';
$content = ob_get_clean();

include APP_PATH . '/views/layout.php';
?>
