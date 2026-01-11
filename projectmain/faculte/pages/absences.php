<?php
session_start();
include '../config/database.php';
include '../includes/functions.php';
require_role('admin');

$error = '';
$success = '';

// Ajouter une absence
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['action']) && $_POST['action'] == 'add') {
    $etudiant_user_id = $_POST['etudiant_id'] ?? '';
    $cours_id = $_POST['cours_id'] ?? '';
    $date_absence = $_POST['date_absence'] ?? '';
    $statut = $_POST['statut'] ?? 'absent';
    
    if (empty($etudiant_user_id) || empty($cours_id) || empty($date_absence)) {
        $error = "Tous les champs sont requis!";
    } else {
        $query_etud = "SELECT e.id FROM etudiants e WHERE e.user_id = ?";
        $stmt = $conn->prepare($query_etud);
        $stmt->bind_param("i", $etudiant_user_id);
        $stmt->execute();
        $etud_result = $stmt->get_result()->fetch_assoc();
        
        if ($etud_result) {
            $etudiant_id = $etud_result['id'];
            $query = "INSERT INTO absences (etudiant_id, cours_id, date_absence, statut) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("iiss", $etudiant_id, $cours_id, $date_absence, $statut);
            
            if ($stmt->execute()) {
                $success = "Absence enregistrée!";
            } else {
                $error = "Erreur lors de l'enregistrement!";
            }
        } else {
            $error = "Profil étudiant non trouvé!";
        }
    }
}

$etudiants_query = "SELECT u.id, u.nom FROM users u JOIN etudiants e ON u.id = e.user_id WHERE u.role = 'etudiant'";
$etudiants = fetch_all($conn, $etudiants_query);

// Récupérer les cours
$cours_query = "SELECT id, nom FROM cours";
$cours_list = fetch_all($conn, $cours_query);

// Récupérer toutes les absences
$query = "SELECT a.*, u.nom as etudiant_nom, c.nom as cours_nom FROM absences a 
          JOIN etudiants e ON a.etudiant_id = e.id 
          JOIN users u ON e.user_id = u.id 
          JOIN cours c ON a.cours_id = c.id
          ORDER BY a.date_absence DESC";
$absences = fetch_all($conn, $query);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Absences - Gestion Faculté</title>
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
                    <a href="absences.php" class="list-group-item list-group-item-action active">Absences</a>
                    <!-- Added inscriptions link to admin sidebar -->
                    <a href="inscriptions.php" class="list-group-item list-group-item-action">Inscriptions</a>
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
                    <div class="card-header">
                        <h4>Historique des Absences</h4>
                    </div>
                    <div class="card-body">
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
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
