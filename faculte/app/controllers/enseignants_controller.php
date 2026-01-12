<?php
require_once APP_PATH . '/models/Enseignant.php';
require_once BASE_PATH . '/includes/functions.php';

require_role('admin');

$error = '';
$success = '';
$page_title = 'Gestion des Enseignants';
$show_navbar = true;
$show_sidebar = true;
$current_page = 'enseignants';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $specialite = $_POST['specialite'] ?? null;
    $telephone = $_POST['telephone'] ?? null;
    
    if (empty($nom) || empty($email)) {
        $error = "Nom et email sont requis!";
    } else {
        if (Enseignant::create($nom, $email, $specialite, $telephone)) {
            $success = "Enseignant ajouté avec succès!";
        } else {
            $error = "Erreur lors de l'ajout!";
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (Enseignant::delete($id)) {
        $success = "Enseignant supprimé!";
        header("Location: ?page=enseignants");
        exit();
    }
}

$enseignants = Enseignant::getAll();

ob_start();
include APP_PATH . '/views/enseignants_view.php';
$content = ob_get_clean();

include APP_PATH . '/views/layout.php';
?>
