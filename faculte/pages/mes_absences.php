<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

// Vérifier que l'utilisateur est étudiant
if ($_SESSION['role'] != 'etudiant') {
    header("Location: dashboard.php");
    exit;
}

// Récupérer l'ID de l'étudiant
$query = "SELECT id FROM etudiants WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$etudiant = $stmt->get_result()->fetch_assoc();

if (!$etudiant) {
    die("Profil étudiant non trouvé!");
}

$etudiant_id = $etudiant['id'];

// Récupérer les absences de cet étudiant
$query = "SELECT a.*, c.nom as cours_nom FROM absences a 
          JOIN cours c ON a.cours_id = c.id
          WHERE a.etudiant_id = ?
          ORDER BY a.date_absence DESC";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $etudiant_id);
$stmt->execute();
$absences = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Calculer les statistiques
$total = count($absences);
$presents = count(array_filter($absences, fn($a) => $a['statut'] == 'present'));
$absents = $total - $presents;
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Absences - Gestion Faculté</title>
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
                    <a href="mes_cours.php" class="list-group-item list-group-item-action">Mes Cours</a>
                    <a href="mes_absences.php" class="list-group-item list-group-item-action active">Mes Absences</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="row mb-4">
                    <div class="col-md-4">
                        <div class="card bg-info text-white">
                            <div class="card-body">
                                <h5 class="card-title">Total</h5>
                                <p class="card-text display-4"><?php echo $total; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-success text-white">
                            <div class="card-body">
                                <h5 class="card-title">Présents</h5>
                                <p class="card-text display-4"><?php echo $presents; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-danger text-white">
                            <div class="card-body">
                                <h5 class="card-title">Absents</h5>
                                <p class="card-text display-4"><?php echo $absents; ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>Historique de mes Absences</h4>
                    </div>
                    <div class="card-body">
                        <?php if (empty($absences)): ?>
                            <div class="alert alert-info">Aucun enregistrement d'absence.</div>
                        <?php else: ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Cours</th>
                                        <th>Date</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($absences as $abs): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($abs['cours_nom']); ?></td>
                                            <td><?php echo htmlspecialchars($abs['date_absence']); ?></td>
                                            <td>
                                                <span class="badge <?php echo $abs['statut'] == 'present' ? 'bg-success' : 'bg-danger'; ?>">
                                                    <?php echo ucfirst($abs['statut']); ?>
                                                </span>
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
