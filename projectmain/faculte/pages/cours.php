<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';
require_role('admin');

$error = '';
$success = '';

// Ajouter un cours
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $nom = $_POST['nom'] ?? '';
    $code = $_POST['code'] ?? '';
    $description = $_POST['description'] ?? '';
    $enseignant_id = $_POST['enseignant_id'] ?? '';
    $credits = $_POST['credits'] ?? 3;
    
    if (empty($nom) || empty($code) || empty($enseignant_id)) {
        $error = "Nom, code et enseignant sont requis!";
    } else {
        $query = "INSERT INTO cours (nom, code, description, enseignant_id, credits) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("sssii", $nom, $code, $description, $enseignant_id, $credits);
        
        if ($stmt->execute()) {
            $success = "Cours ajouté avec succès!";
        } else {
            $error = "Erreur lors de l'ajout!";
        }
    }
}

// Supprimer un cours
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM cours WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $id);
    if ($stmt->execute()) {
        $success = "Cours supprimé!";
    }
    header("Location: cours.php");
}

// Récupérer les enseignants
$enseignants_query = "SELECT e.id, u.nom FROM enseignants e JOIN users u ON e.user_id = u.id";
$enseignants = fetch_all($conn, $enseignants_query);

// Récupérer tous les cours
$query = "SELECT c.*, u.nom as enseignant_nom FROM cours c 
          JOIN enseignants e ON c.enseignant_id = e.id 
          JOIN users u ON e.user_id = u.id";
$cours_list = fetch_all($conn, $query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Cours - Gestion Faculté</title>
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
                    <a href="cours.php" class="list-group-item list-group-item-action active">Cours</a>
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
                        <h4>Ajouter un Cours</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <input type="hidden" name="action" value="add">
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="nom" class="form-label">Nom du cours</label>
                                    <input type="text" class="form-control" id="nom" name="nom" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="code" class="form-label">Code du cours</label>
                                    <input type="text" class="form-control" id="code" name="code" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="enseignant_id" class="form-label">Enseignant</label>
                                    <select class="form-control" id="enseignant_id" name="enseignant_id" required>
                                        <option value="">-- Sélectionner --</option>
                                        <?php foreach ($enseignants as $ens): ?>
                                            <option value="<?php echo $ens['id']; ?>"><?php echo htmlspecialchars($ens['nom']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="credits" class="form-label">Crédits</label>
                                    <input type="number" class="form-control" id="credits" name="credits" value="3">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
                            </div>
                            <button type="submit" class="btn btn-success">Ajouter</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h4>Liste des Cours</h4>
                    </div>
                    <div class="card-body">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Nom</th>
                                    <th>Code</th>
                                    <th>Enseignant</th>
                                    <th>Crédits</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($cours_list as $c): ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($c['nom']); ?></td>
                                        <td><?php echo htmlspecialchars($c['code']); ?></td>
                                        <td><?php echo htmlspecialchars($c['enseignant_nom']); ?></td>
                                        <td><?php echo $c['credits']; ?></td>
                                        <td>
                                            <a href="cours.php?delete=<?php echo $c['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Êtes-vous sûr?');">Supprimer</a>
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
