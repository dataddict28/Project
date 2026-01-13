<?php
require_once APP_PATH . '/models/Etudiant.php';
require_once APP_PATH . '/models/Paiement.php';
require_once BASE_PATH . '/includes/functions.php';

require_role('admin');

$error = '';
$success = '';
$page_title = 'Gestion des Paiements';
$show_navbar = true;
$show_sidebar = true;
$current_page = 'paiements';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'add_payment') {
        $etudiant_id = $_POST['etudiant_id'];
        $montant = $_POST['montant'];
        $statut = $_POST['statut'];

        if (Paiement::create($etudiant_id, $montant, $statut)) {
            $success = "Paiement ajouté avec succès!";
        } else {
            $error = "Erreur lors de l'ajout du paiement!";
        }
    } elseif ($_POST['action'] === 'update_payment') {
        $id = $_POST['id'];
        $statut = $_POST['statut'];

        if (Paiement::updateStatut($id, $statut)) {
            $success = "Statut du paiement mis à jour!";
        } else {
            $error = "Erreur lors de la mise à jour!";
        }
    }
}

if (isset($_GET['delete_payment'])) {
    $id = $_GET['delete_payment'];
    if (Paiement::delete($id)) {
        $success = "Paiement supprimé!";
        header("Location: ?page=paiements");
        exit();
    }
}

$etudiants = Etudiant::getAllWithPaymentsAndSemesters();
$paiements = Paiement::getAll();

ob_start();
include APP_PATH . '/views/paiements_view.php';
$content = ob_get_clean();

include APP_PATH . '/views/layout.php';
?>
