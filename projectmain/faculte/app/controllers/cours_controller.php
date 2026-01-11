<?php
require_once APP_PATH . '/models/Cours.php';
require_once APP_PATH . '/models/Enseignant.php';

require_role('admin');

$error = '';
$success = '';

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
    }
}

$cours_list = Cours::getAll();
$enseignants = Enseignant::getAll();
$user = User::getById($_SESSION['user_id']);
$role = $user['role'];

require_once APP_PATH . '/views/cours.php';
?>
