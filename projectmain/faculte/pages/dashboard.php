<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';
require_login();

$user = get_user_info($conn, $_SESSION['user_id']);
$role = $_SESSION['role'];
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Gestion Faculté</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="dashboard.php">Gestion Faculté</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link">Bienvenue, <?php echo htmlspecialchars($_SESSION['nom']); ?></span>
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
                    <a href="dashboard.php" class="list-group-item list-group-item-action active">Accueil</a>
                    
                    <?php if ($role == 'admin'): ?>
                        <a href="enseignants.php" class="list-group-item list-group-item-action">Enseignants</a>
                        <a href="cours.php" class="list-group-item list-group-item-action">Cours</a>
                        <a href="etudiants.php" class="list-group-item list-group-item-action">Étudiants</a>
                        <a href="inscriptions.php" class="list-group-item list-group-item-action">Inscriptions</a>
                        <a href="absences.php" class="list-group-item list-group-item-action">Absences</a>
                    <?php elseif ($role == 'enseignant'): ?>
                        <a href="mes_cours_enseignant.php" class="list-group-item list-group-item-action">Mes Cours</a>
                        <a href="mes_absences_enseignant.php" class="list-group-item list-group-item-action">Gérer Absences</a>
                        <!-- Added link to inscriptions for teachers -->
                        <a href="inscriptions_enseignant.php" class="list-group-item list-group-item-action">Inscrire Étudiants</a>
                    <?php elseif ($role == 'etudiant'): ?>
                        <a href="mes_cours.php" class="list-group-item list-group-item-action">Mes Cours</a>
                        <a href="mes_absences.php" class="list-group-item list-group-item-action">Mes Absences</a>
                    <?php endif; ?>
                </div>
            </div>

            <div class="col-md-9">
                <div class="card">
                    <div class="card-body">
                        <h3>Bienvenue dans le système de gestion de faculté</h3>
                        <p class="lead">Connecté en tant que: <strong><?php echo ucfirst($role); ?></strong></p>
                        
                        <?php if ($role == 'admin'): ?>
                            <div class="alert alert-info">
                                <h4>Accès Administrateur</h4>
                                <p>Vous pouvez gérer les enseignants, les cours, les étudiants et les absences.</p>
                            </div>
                        <?php elseif ($role == 'enseignant'): ?>
                            <div class="alert alert-info">
                                <h4>Accès Enseignant</h4>
                                <p>Vous pouvez voir vos cours et gérer les absences de vos étudiants.</p>
                            </div>
                        <?php elseif ($role == 'etudiant'): ?>
                            <div class="alert alert-info">
                                <h4>Accès Étudiant</h4>
                                <p>Vous pouvez consulter vos cours et vos absences.</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
