<?php
require_once APP_PATH . '/models/Absence.php';
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
$page_title = 'Gérer les Absences';
$show_navbar = true;
$show_sidebar = true;
$current_page = 'mes_absences_enseignant';

// Get teacher profile
$enseignant = Enseignant::getByUserId($_SESSION['user_id']);

if (!$enseignant) {
    header("Location: ?page=dashboard");
    exit();
}

// Get courses for this teacher
$cours_list = Cours::getByEnseignantId($enseignant['id']);

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $etudiant_user_id = $_POST['etudiant_id'] ?? '';
    $cours_id = $_POST['cours_id'] ?? '';
    $date_absence = $_POST['date_absence'] ?? '';
    $statut = $_POST['statut'] ?? 'absent';
    
    if (empty($etudiant_user_id) || empty($cours_id) || empty($date_absence)) {
        $error = "Tous les champs sont requis!";
    } else {
        $etudiant = Etudiant::getByUserId($etudiant_user_id);
        if ($etudiant) {
            $etudiant_id = $etudiant['id'];
            if (Absence::create($etudiant_id, $cours_id, $date_absence, $statut)) {
                $success = "Absence enregistrée!";
            } else {
                $error = "Erreur lors de l'enregistrement!";
            }
        } else {
            $error = "Profil étudiant non trouvé!";
        }
    }
}

// Get students enrolled in teacher's courses
$etudiants = [];
if (!empty($cours_list)) {
    $cours_ids = array_column($cours_list, 'id');
    $placeholders = str_repeat('?,', count($cours_ids) - 1) . '?';
    $query = "SELECT DISTINCT u.id, u.nom FROM users u 
              JOIN etudiants e ON u.id = e.user_id 
              JOIN inscriptions i ON e.id = i.etudiant_id 
              WHERE i.cours_id IN ($placeholders)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(str_repeat('i', count($cours_ids)), ...$cours_ids);
    $stmt->execute();
    $etudiants = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Get absences for teacher's courses
$absences = [];
if (!empty($cours_ids)) {
    $placeholders = str_repeat('?,', count($cours_ids) - 1) . '?';
    $query = "SELECT a.*, u.nom as etudiant_nom, c.nom as cours_nom FROM absences a 
              JOIN etudiants e ON a.etudiant_id = e.id 
              JOIN users u ON e.user_id = u.id 
              JOIN cours c ON a.cours_id = c.id
              WHERE a.cours_id IN ($placeholders)
              ORDER BY a.date_absence DESC";
    $stmt = $conn->prepare($query);
    $stmt->bind_param(str_repeat('i', count($cours_ids)), ...$cours_ids);
    $stmt->execute();
    $absences = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

ob_start();
include APP_PATH . '/views/mes_absences_enseignant_view.php';
$content = ob_get_clean();

include APP_PATH . '/views/layout.php';
?>
