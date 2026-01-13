<?php
require_once APP_PATH . '/models/Etudiant.php';
require_once BASE_PATH . '/includes/functions.php';

require_role('admin');

$error = '';
$success = '';
$page_title = 'Gestion des Étudiants';
$show_navbar = true;
$show_sidebar = true;
$current_page = 'etudiants';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add') {
        $nom = $_POST['nom'] ?? '';
        $email = $_POST['email'] ?? '';
        $date_naissance = $_POST['date_naissance'] ?? null;
        $adresse = $_POST['adresse'] ?? null;
        $telephone = $_POST['telephone'] ?? null;

        if (empty($nom) || empty($email)) {
            $error = "Nom et email sont requis!";
        } else {
            if (Etudiant::create($nom, $email, $date_naissance, $adresse, $telephone)) {
                $success = "Étudiant ajouté avec succès!";
            } else {
                $error = "Erreur lors de l'ajout!";
            }
        }
    } elseif ($_POST['action'] === 'update_semester') {
        $user_id = $_POST['user_id'] ?? 0;
        $semestre1_valide = isset($_POST['semestre1_valide']) ? 1 : 0;
        $semestre2_valide = isset($_POST['semestre2_valide']) ? 1 : 0;

        if (Etudiant::updateSemesterValidation($user_id, $semestre1_valide, $semestre2_valide)) {
            $success = "Validation des semestres mise à jour!";
        } else {
            $error = "Erreur lors de la mise à jour!";
        }
    }
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    if (Etudiant::delete($id)) {
        $success = "Étudiant supprimé!";
        header("Location: ?page=etudiants");
        exit();
    }
}

$etudiants = Etudiant::getAllWithPaymentsAndSemesters();

ob_start();
include APP_PATH . '/views/etudiants_view.php';
$content = ob_get_clean();

include APP_PATH . '/views/layout.php';
?>
