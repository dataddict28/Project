<?php
require_once APP_PATH . '/models/Cours.php';
require_once APP_PATH . '/models/Enseignant.php';
require_once BASE_PATH . '/includes/functions.php';

require_role('admin');

$error = '';
$success = '';
$page_title = 'Gestion des Cours';
$show_navbar = true;
$show_sidebar = true;
$current_page = 'cours';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $nom = $_POST['nom'] ?? '';
    $code = $_POST['code'] ?? '';
    $description = $_POST['description'] ?? '';
    $enseignant_id = $_POST['enseignant_id'] ?? '';
    $credits = $_POST['credits'] ?? 3;
    
    if (empty($nom) || empty($code) || empty($enseignant_id)) {
        $error = "Nom, code et enseignant sont requis!";
    } else {
        if (Cours::create($nom, $code, $description, $enseignant_id, $credits)) {
            $success = "Cours ajouté avec succès!";
        } else {
            $error = "Erreur lors de l'ajout!";
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (Cours::delete($id)) {
        $success = "Cours supprimé!";
        header("Location: ?page=cours");
        exit();
    }
}

$cours_list = Cours::getAll();
$enseignants = Enseignant::getAll();

ob_start();
include APP_PATH . '/views/cours_view.php';
$content = ob_get_clean();

include APP_PATH . '/views/layout.php';
?>
