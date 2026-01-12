<?php
require_once APP_PATH . '/models/Inscription.php';
require_once APP_PATH . '/models/Etudiant.php';
require_once APP_PATH . '/models/Cours.php';
require_once BASE_PATH . '/includes/functions.php';
require_once BASE_PATH . '/config/database.php';

require_login();

if ($_SESSION['role'] != 'etudiant') {
    header("Location: ?page=dashboard");
    exit();
}

$page_title = 'Mes Cours';
$show_navbar = true;
$show_sidebar = true;
$current_page = 'mes_cours';

// Get student profile
$etudiant = Etudiant::getByUserId($_SESSION['user_id']);

if (!$etudiant) {
    // Create student profile if it doesn't exist
    $numero_matricule = "MAT-" . date('YmdHis');
    $query_insert = "INSERT INTO etudiants (user_id, numero_matricule) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($query_insert);
    $stmt_insert->bind_param("is", $_SESSION['user_id'], $numero_matricule);
    $stmt_insert->execute();
    $etudiant_id = $conn->insert_id;
} else {
    $etudiant_id = $etudiant['id'];
}

// Get courses for this student
$cours_list = Inscription::getByEtudiantId($etudiant_id);

// Get teacher names for each course
foreach ($cours_list as &$cours) {
    $cours_details = Cours::getById($cours['id']);
    $cours['enseignant_nom'] = $cours_details['enseignant_nom'] ?? 'N/A';
}

ob_start();
include APP_PATH . '/views/mes_cours_view.php';
$content = ob_get_clean();

include APP_PATH . '/views/layout.php';
?>
