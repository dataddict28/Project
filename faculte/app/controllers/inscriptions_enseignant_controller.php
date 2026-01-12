<?php
require_once APP_PATH . '/models/Inscription.php';
require_once APP_PATH . '/models/Cours.php';
require_once APP_PATH . '/models/Enseignant.php';
require_once APP_PATH . '/models/Etudiant.php';
require_once BASE_PATH . '/includes/functions.php';
require_once BASE_PATH . '/config/database.php';

require_login();

if ($_SESSION['role'] != 'enseignant') {
    header("Location: ?page=dashboard");
    exit();
}

$error = '';
$success = '';
$page_title = 'Inscrire des Étudiants';
$show_navbar = true;
$show_sidebar = true;
$current_page = 'inscriptions_enseignant';

// Get teacher profile
$enseignant = Enseignant::getByUserId($_SESSION['user_id']);

if (!$enseignant) {
    header("Location: ?page=dashboard");
    exit();
}

// Get courses for this teacher
$cours_list = Cours::getByEnseignantId($enseignant['id']);

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

// Get all students
$query_etudiants = "SELECT e.id, u.nom FROM etudiants e JOIN users u ON e.user_id = u.id ORDER BY u.nom";
$stmt = $conn->prepare($query_etudiants);
$stmt->execute();
$etudiants = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get inscriptions for teacher's courses
$inscriptions = [];
if (!empty($cours_list)) {
    $cours_ids = array_column($cours_list, 'id');
    $placeholders = str_repeat('?,', count($cours_ids) - 1) . '?';
    $query = "SELECT i.*, u.nom as etudiant_nom, c.nom as cours_nom FROM inscriptions i 
              JOIN etudiants e ON i.etudiant_id = e.id 
              JOIN users u ON e.user_id = u.id 
              JOIN cours c ON i.cours_id = c.id
              WHERE i.cours_id IN ($placeholders)
              ORDER BY u.nom, c.nom";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(str_repeat('i', count($cours_ids)), ...$cours_ids);
    $stmt->execute();
    $inscriptions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

ob_start();
include APP_PATH . '/views/inscriptions_enseignant_view.php';
$content = ob_get_clean();

include APP_PATH . '/views/layout.php';
?>
