<?php
require_once APP_PATH . '/models/Inscription.php';
require_once APP_PATH . '/models/Etudiant.php';
require_once APP_PATH . '/models/Cours.php';
require_once BASE_PATH . '/includes/functions.php';
require_once BASE_PATH . '/config/database.php';

require_role('admin');

$error = '';
$success = '';
$page_title = 'Gestion des Inscriptions';
$show_navbar = true;
$show_sidebar = true;
$current_page = 'inscriptions';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $etudiant_id = $_POST['etudiant_id'] ?? '';
    $cours_id = $_POST['cours_id'] ?? '';
    
    if (empty($etudiant_id) || empty($cours_id)) {
        $error = "Veuillez sélectionner un étudiant et un cours!";
    } else {
        if (Inscription::create($etudiant_id, $cours_id)) {
            $success = "Étudiant inscrit au cours avec succès!";
        } else {
            $error = "Cette inscription existe déjà!";
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (Inscription::deleteById($id)) {
        $success = "Inscription supprimée!";
        header("Location: ?page=inscriptions");
        exit();
    }
}

// Get all students
$query_etudiants = "SELECT e.id, u.nom FROM etudiants e JOIN users u ON e.user_id = u.id ORDER BY u.nom";
$stmt = $conn->prepare($query_etudiants);
$stmt->execute();
$etudiants = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get all courses with teacher names
$cours_list = Cours::getAll();

// Get all inscriptions
$inscriptions = Inscription::getAll();

ob_start();
include APP_PATH . '/views/inscriptions_view.php';
$content = ob_get_clean();

include APP_PATH . '/views/layout.php';
?>
