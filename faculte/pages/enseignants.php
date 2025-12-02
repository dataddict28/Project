<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';
require_role('admin');

$error = '';
$success = '';

// Ajouter un enseignant
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $specialite = $_POST['specialite'] ?? '';
    $telephone = $_POST['telephone'] ?? '';
    $mot_de_passe = password_hash('password123', PASSWORD_BCRYPT);
    
    if (empty($nom) || empty($email)) {
        $error = "Nom et email sont requis!";
    } else {
        // Créer l'utilisateur
        $query = "INSERT INTO users (nom, email, mot_de_passe, role) VALUES (?, ?, ?, 'enseignant')";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sss", $nom, $email, $mot_de_passe);
        
        if ($stmt->execute()) {
            $user_id = $conn->insert_id;
            // Créer le profil enseignant
            $query_ens = "INSERT INTO enseignants (user_id, specialite, telephone) VALUES (?, ?, ?)";
            $stmt_ens = $conn->prepare($query_ens);
            $stmt_ens->bind_param("iss", $user_id, $specialite, $telephone);
            $stmt_ens->execute();
            $success = "Enseignant ajouté avec succès!";
        } else {
            $error = "Erreur lors de l'ajout!";
        }
    }
}

// Supprimer un enseignant
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM users WHERE id = ? AND role = 'enseignant'";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $success = "Enseignant supprimé!";
    }
    header("Location: enseignants.php");
}

// Récupérer tous les enseignants
$query = "SELECT u.*, e.specialite, e.telephone FROM users u 
          LEFT JOIN enseignants e ON u.id = e.user_id 
          WHERE u.role = 'enseignant'";
$enseignants = fetch_all($conn, $query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Enseignants - Gestion Faculté</title>
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
                    <a href="enseignants.php" class="list-group-item list-group-item-action active">Enseignants</a>
                    <a href="cours.php" class="list-group-item list-group-item-action">Cours</a>
                    <a href="etudiants.php" class="list-group-item list-group-item-action">Étudiants</a>
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
                        <h4>Ajouter un Enseignant</h4>
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
                                    <label for="specialite" class="form-label">Spécialité</label>
                                    <input type="text" class="form-control" id="specialite" name="specialite">
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="telephone" class="form-label">Téléphone</label>
                                    <input type="tel" class="form-control" id="telephone" name="telephone">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Ajouter</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>Liste des Enseignants</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Nom</th>
                                    <th>Email</th>
                                    <th>Spécialité</th>
                                    <th>Téléphone</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($enseignants as $ens): ?>
                                    <tr>
                                        <td><?php echo $ens['id']; ?></td>
                                        <td><?php echo htmlspecialchars($ens['nom']); ?></td>
                                        <td><?php echo htmlspecialchars($ens['email']); ?></td>
                                        <td><?php echo htmlspecialchars($ens['specialite'] ?? '-'); ?></td>
                                        <td><?php echo htmlspecialchars($ens['telephone'] ?? '-'); ?></td>
                                        <td>
                                            <a href="enseignants.php?delete=<?php echo $ens['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr?');">Supprimer</a>
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
