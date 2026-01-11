<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';

$error = '';
$success = '';

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

// Ajouter une absence
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $etudiant_id = $_POST['etudiant_id'] ?? '';
    $cours_id = $_POST['cours_id'] ?? '';
    $date_absence = $_POST['date_absence'] ?? '';
    $statut = $_POST['statut'] ?? 'absent';
    
    if (empty($etudiant_id) || empty($cours_id) || empty($date_absence)) {
        $error = "Tous les champs sont requis!";
    } else {
        $query = "INSERT INTO absences (etudiant_id, cours_id, date_absence, statut) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($query);
        $stmt->bind_param("iiss", $etudiant_id, $cours_id, $date_absence, $statut);
        
        if ($stmt->execute()) {
            $success = "Absence enregistrée!";
        } else {
            $error = "Erreur lors de l'enregistrement!";
        }
    }
}

// Récupérer les cours de cet enseignant
$cours_query = "SELECT id, nom FROM cours WHERE enseignant_id = ?";
$stmt = $conn->prepare($cours_query);
$stmt->bind_param("i", $enseignant_id);
$stmt->execute();
$cours_list = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Récupérer les étudiants inscrits aux cours de cet enseignant
$etudiants_query = "SELECT DISTINCT e.id, u.nom FROM etudiants e 
                    JOIN users u ON e.user_id = u.id
                    JOIN inscriptions i ON e.id = i.etudiant_id
                    JOIN cours c ON i.cours_id = c.id
                    WHERE c.enseignant_id = ?
                    ORDER BY u.nom";
$stmt = $conn->prepare($etudiants_query);
$stmt->bind_param("i", $enseignant_id);
$stmt->execute();
$etudiants = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

// Récupérer les absences des cours de cet enseignant
$absences_query = "SELECT a.*, u.nom as etudiant_nom, c.nom as cours_nom FROM absences a 
                   JOIN etudiants e ON a.etudiant_id = e.id 
                   JOIN users u ON e.user_id = u.id 
                   JOIN cours c ON a.cours_id = c.id
                   WHERE c.enseignant_id = ?
                   ORDER BY a.date_absence DESC";
$stmt = $conn->prepare($absences_query);
$stmt->bind_param("i", $enseignant_id);
$stmt->execute();
$absences = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer Absences - Gestion Faculté</title>
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
                    <!-- Added dynamic sidebar for teacher navigation -->
                    <a href="dashboard.php" class="list-group-item list-group-item-action">Accueil</a>
                    <a href="mes_cours_enseignant.php" class="list-group-item list-group-item-action">Mes Cours</a>
                    <a href="mes_absences_enseignant.php" class="list-group-item list-group-item-action active">Gérer Absences</a>
                    <a href="inscriptions_enseignant.php" class="list-group-item list-group-item-action">Inscrire Étudiants</a>
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
                        <h4>Enregistrer une Absence</h4>
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
                                            <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['nom']); ?></option>
                                        <?php endforeach; ?>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="date_absence" class="form-label">Date</label>
                                    <input type="date" class="form-control" id="date_absence" name="date_absence" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="statut" class="form-label">Statut</label>
                                    <select class="form-control" id="statut" name="statut">
                                        <option value="absent">Absent</option>
                                        <option value="present">Présent</option>
                                    </select>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-success">Enregistrer</button>
                        </form>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h4>Historique des Absences</h4>
                    </div>
                    <div class="card-body">
                        <?php if (empty($absences)): ?>
                            <div class="alert alert-info">Aucun enregistrement d'absence.</div>
                        <?php else: ?>
                            <table class="table table-striped">
                                <thead>
                                    <tr>
                                        <th>Étudiant</th>
                                        <th>Cours</th>
                                        <th>Date</th>
                                        <th>Statut</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($absences as $abs): ?>
                                        <tr>
                                            <td><?php echo htmlspecialchars($abs['etudiant_nom']); ?></td>
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
