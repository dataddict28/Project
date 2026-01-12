<?php
require_once APP_PATH . '/models/Absence.php';
require_once APP_PATH . '/models/Etudiant.php';
require_once APP_PATH . '/models/Cours.php';
require_once BASE_PATH . '/includes/functions.php';
require_once BASE_PATH . '/config/database.php';

require_role('admin');

$error = '';
$success = '';
$page_title = 'Gestion des Absences';
$show_navbar = true;
$show_sidebar = true;
$current_page = 'absences';

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

// Get all students (users with role etudiant)
$query_etudiants = "SELECT u.id, u.nom FROM users u JOIN etudiants e ON u.id = e.user_id WHERE u.role = 'etudiant'";
$stmt = $conn->prepare($query_etudiants);
$stmt->execute();
$etudiants = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Get all courses
$cours_list = Cours::getAll();

// Get all absences
$absences = Absence::getAll();

ob_start();
include APP_PATH . '/views/absences_view.php';
$content = ob_get_clean();

include APP_PATH . '/views/layout.php';
?>
