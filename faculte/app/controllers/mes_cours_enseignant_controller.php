<?php
require_once APP_PATH . '/models/Cours.php';
require_once APP_PATH . '/models/Enseignant.php';
require_once BASE_PATH . '/includes/functions.php';

require_login();

if ($_SESSION['role'] != 'enseignant') {
    header("Location: ?page=dashboard");
    exit();
}

$page_title = 'Mes Cours';
$show_navbar = true;
$show_sidebar = true;
$current_page = 'mes_cours_enseignant';

// Get teacher profile
$enseignant = Enseignant::getByUserId($_SESSION['user_id']);

if (!$enseignant) {
    header("Location: ?page=dashboard");
    exit();
}

// Get courses for this teacher
$cours_list = Cours::getByEnseignantId($enseignant['id']);

ob_start();
include APP_PATH . '/views/mes_cours_enseignant_view.php';
$content = ob_get_clean();

include APP_PATH . '/views/layout.php';
?>
