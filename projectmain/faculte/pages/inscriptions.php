<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';
require_role('admin');

$error = '';
$success = '';

// Ajouter une inscription
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $etudiant_id = $_POST['etudiant_id'] ?? '';
    $cours_id = $_POST['cours_id'] ?? '';
    
    if (empty($etudiant_id) || empty($cours_id)) {
        $error = "Veuillez sélectionner un étudiant et un cours!";
    } else {
        $query = "INSERT INTO inscriptions (etudiant_id, cours_id) VALUES (?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("ii", $etudiant_id, $cours_id);
        
        if ($stmt->execute()) {
            $success = "Étudiant inscrit au cours avec succès!";
        } else {
            $error = "Cette inscription existe déjà!";
        }
    }
}

// Supprimer une inscription
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM inscriptions WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $success = "Inscription supprimée!";
    }
    header("Location: inscriptions.php");
}

// Récupérer les étudiants
$query_etudiants = "SELECT e.id, u.nom FROM etudiants e JOIN users u ON e.user_id = u.id ORDER BY u.nom";
$stmt = $conn->prepare($query_etudiants);
$stmt->execute();
$etudiants = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Récupérer les cours
$query_cours = "SELECT c.id, c.nom, u.nom as enseignant_nom FROM cours c JOIN enseignants e ON c.enseignant_id = e.id JOIN users u ON e.user_id = u.id ORDER BY c.nom";
$stmt = $conn->prepare($query_cours);
$stmt->execute();
$cours_list = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Récupérer les inscriptions
$query_inscriptions = "SELECT i.id, u.nom as etudiant_nom, c.nom as cours_nom, i.date_inscription FROM inscriptions i 
                       JOIN etudiants e ON i.etudiant_id = e.id 
                       JOIN users u ON e.user_id = u.id 
                       JOIN cours c ON i.cours_id = c.id
                       ORDER BY u.nom, c.nom";
$stmt = $conn->prepare($query_inscriptions);
$stmt->execute();
$inscriptions = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Inscriptions - Gestion Faculté</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Gestion Faculté</a>
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link"><?php echo htmlspecialchars($_SESSION['nom']); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Déconnexion</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            <div class="col-md-3">
                <div class="list-group">
                    <a href="dashboard.php" class="list-group-item list-group-item-action">Accueil</a>
                    <a href="enseignants.php" class="list-group-item list-group-item-action">Enseignants</a>
                    <a href="cours.php" class="list-group-item list-group-item-action">Cours</a>
                    <a href="etudiants.php" class="list-group-item list-group-item-action">Étudiants</a>
                    <a href="inscriptions.php" class="list-group-item list-group-item-action active">Inscriptions</a>
                    <a href="absences.php" class="list-group-item list-group-item-action">Absences</a>
                </div>
            </div>

            <div class="col-md-9">
                <?php if ($error): ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                
                <?php if ($success): ?>
                    <div class="alert alert-success"><?php echo $success; ?></div>
                <?php endif; ?>

                <div class="card mb-4">
                    <div class="card-header bg-primary text-white">
                        <h4>Inscrire un Étudiant à un Cours</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="action" value="add">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="etudiant_id" class="form-label">Étudiant</label>
                                    <select class="form-control" id="etudiant_id" name="etudiant_id" required>
                                        <option value="">-- Sélectionner --</option>
                                        <?php foreach ($etudiants as $etud): ?>
                                            <option value="<?php echo $etud['id']; ?>"><?php echo htmlspecialchars($etud['nom']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="cours_id" class="form-label">Cours</label>
                                    <select class="form-control" id="cours_id" name="cours_id" required>
                                        <option value="">-- Sélectionner --</option>
                                        <?php foreach ($cours_list as $c): ?>
                                            <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['nom']) . " (" . htmlspecialchars($c['enseignant_nom']) . ")"; ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Inscrire</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>Inscriptions</h4>
                    </div>
                    <div class="card-body">
                        <?php if (empty($inscriptions)): ?>
                            <div class="alert alert-info">Aucune inscription enregistrée.</div>
                        <?php else: ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Étudiant</th>
                                        <th>Cours</th>
                                        <th>Date d'inscription</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($inscriptions as $insc): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($insc['etudiant_nom']); ?></td>
                                            <td><?php echo htmlspecialchars($insc['cours_nom']); ?></td>
                                            <td><?php echo htmlspecialchars($insc['date_inscription']); ?></td>
                                            <td>
                                                <a href="inscriptions.php?delete=<?php echo $insc['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr?');">Supprimer</a>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
