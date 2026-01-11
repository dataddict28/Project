<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

// Vérifier que l'utilisateur est enseignant
if ($_SESSION['role'] != 'enseignant') {
    header("Location: dashboard.php");
    exit;
}

// Récupérer l'ID de l'enseignant
$query = "SELECT id FROM enseignants WHERE user_id = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $_SESSION['user_id']);
$stmt->execute();
$enseignant = $stmt->get_result()->fetch_assoc();

if (!$enseignant) {
    die("Profil enseignant non trouvé!");
}

$enseignant_id = $enseignant['id'];

// Récupérer les cours de cet enseignant
$query = "SELECT * FROM cours WHERE enseignant_id = ? ORDER BY nom";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $enseignant_id);
$stmt->execute();
$cours_list = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Cours - Gestion Faculté</title>
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
                    <a href="mes_cours_enseignant.php" class="list-group-item list-group-item-action active">Mes Cours</a>
                    <a href="mes_absences_enseignant.php" class="list-group-item list-group-item-action">Gérer Absences</a>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>Mes Cours</h4>
                    </div>
                    <div class="card-body">
                        <?php if (empty($cours_list)): ?>
                            <div class="alert alert-info">Aucun cours assigné.</div>
                        <?php else: ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Nom du Cours</th>
                                        <th>Code</th>
                                        <th>Crédits</th>
                                        <th>Description</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($cours_list as $c): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($c['nom']); ?></td>
                                            <td><?php echo htmlspecialchars($c['code']); ?></td>
                                            <td><?php echo $c['credits']; ?></td>
                                            <td><?php echo htmlspecialchars(substr($c['description'], 0, 50)); ?></td>
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
