<?php
require_once APP_PATH . '/models/Absence.php';
require_once APP_PATH . '/models/Etudiant.php';
require_once BASE_PATH . '/includes/functions.php';

require_login();

if ($_SESSION['role'] != 'etudiant') {
    header("Location: ?page=dashboard");
    exit();
}

$page_title = 'Mes Absences';
$show_navbar = true;
$show_sidebar = true;
$current_page = 'mes_absences';

// Get student profile
$etudiant = Etudiant::getByUserId($_SESSION['user_id']);

if (!$etudiant) {
    header("Location: ?page=dashboard");
    exit();
}

// Get absences for this student
$absences = Absence::getByEtudiantId($etudiant['id']);

ob_start();
include APP_PATH . '/views/mes_absences_view.php';
$content = ob_get_clean();

include APP_PATH . '/views/layout.php';
?>
