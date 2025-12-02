<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';
require_role('admin');

$error = '';
$success = '';

// Ajouter un étudiant
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $date_naissance = $_POST['date_naissance'] ?? '';
    $adresse = $_POST['adresse'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $mot_de_passe = password_hash('password123', PASSWORD_BCRYPT);
    
    if (empty($nom) || empty($email)) {
        $error = "Nom et email sont requis!";
    } else {
        // Créer l'utilisateur
        $query = "INSERT INTO users (nom, email, mot_de_passe, role) VALUES (?, ?, ?, 'etudiant')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $nom, $email, $mot_de_passe);
        
        if ($stmt->execute()) {
            $user_id = $conn->insert_id;
            $numero_matricule = "MAT-" . date('YmdHis');
            // Créer le profil étudiant
            $query_etud = "INSERT INTO etudiants (user_id, numero_matricule, date_naissance, adresse, telephone) VALUES (?, ?, ?, ?, ?)";
            $stmt_etud = $conn->prepare($query_etud);
            $stmt_etud->bind_param("issss", $user_id, $numero_matricule, $date_naissance, $adresse, $telephone);
            $stmt_etud->execute();
            $success = "Étudiant ajouté avec succès!";
        } else {
            $error = "Erreur lors de l'ajout!";
        }
    }
}

// Supprimer un étudiant
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM users WHERE id = ? AND role = 'etudiant'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $success = "Étudiant supprimé!";
    }
    header("Location: etudiants.php");
}

// Récupérer tous les étudiants
$query = "SELECT u.*, e.numero_matricule, e.date_naissance FROM users u 
          LEFT JOIN etudiants e ON u.id = e.user_id 
          WHERE u.role = 'etudiant'";
$etudiants = fetch_all($conn, $query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Étudiants - Gestion Faculté</title>
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
                    <a href="etudiants.php" class="list-group-item list-group-item-action active">Étudiants</a>
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
                        <h4>Ajouter un Étudiant</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="action" value="add">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nom" class="form-label">Nom</label>
                                    <input type="text" class="form-control" id="nom" name="nom" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" name="email" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="date_naissance" class="form-label">Date de naissance</label>
                                    <input type="date" class="form-control" id="date_naissance" name="date_naissance">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="tel" class="form-control" id="telephone" name="telephone">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="adresse" class="form-label">Adresse</label>
                                <input type="text" class="form-control" id="adresse" name="adresse">
                            </div>
                            <button type="submit" class="btn btn-success">Ajouter</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>Liste des Étudiants</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Matricule</th>
                                    <th>Date naissance</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($etudiants as $etud): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($etud['nom']); ?></td>
                                        <td><?php echo htmlspecialchars($etud['email']); ?></td>
                                        <td><?php echo htmlspecialchars($etud['numero_matricule'] ?? '-'); ?></td>
                                        <td><?php echo htmlspecialchars($etud['date_naissance'] ?? '-'); ?></td>
                                        <td>
                                            <a href="etudiants.php?delete=<?php echo $etud['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr?');">Supprimer</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
