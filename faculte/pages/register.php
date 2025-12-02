<?php
session_start();

// Si déjà connecté, rediriger
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}

include '../config/database.php';
include '../includes/functions.php';

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nom = $_POST['nom'] ?? '';
    $email = $_POST['email'] ?? '';
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    $confirm_mot_de_passe = $_POST['confirm_mot_de_passe'] ?? '';
    $role = $_POST['role'] ?? 'etudiant';
    
    // Validations
    if (empty($nom) || empty($email) || empty($mot_de_passe)) {
        $error = "Tous les champs sont requis!";
    } elseif ($mot_de_passe != $confirm_mot_de_passe) {
        $error = "Les mots de passe ne correspondent pas!";
    } elseif (strlen($mot_de_passe) < 6) {
        $error = "Le mot de passe doit contenir au moins 6 caractères!";
    } else {
        // Vérifier si l'email existe déjà
        $check_email = "SELECT id FROM users WHERE email = ?";
        $stmt = $conn->prepare($check_email);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            $error = "Cet email existe déjà!";
        } else {
            // Créer le nouvel utilisateur
            $mot_de_passe_hash = hash_password($mot_de_passe);
            $query = "INSERT INTO users (nom, email, mot_de_passe, role) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("ssss", $nom, $email, $mot_de_passe_hash, $role);
            
            if ($stmt->execute()) {
                $user_id = $conn->insert_id;
                
                // Si c'est un enseignant, créer le profil
                if ($role == 'enseignant') {
                    $query_ens = "INSERT INTO enseignants (user_id) VALUES (?)";
                    $stmt_ens = $conn->prepare($query_ens);
                    $stmt_ens->bind_param("i", $user_id);
                    $stmt_ens->execute();
                }
                
                // Si c'est un étudiant, créer le profil
                if ($role == 'etudiant') {
                    $numero_matricule = "MAT-" . date('YmdHis');
                    $query_etud = "INSERT INTO etudiants (user_id, numero_matricule) VALUES (?, ?)";
                    $stmt_etud = $conn->prepare($query_etud);
                    $stmt_etud->bind_param("is", $user_id, $numero_matricule);
                    $stmt_etud->execute();
                }
                
                $success = "Inscription réussie! Veuillez vous connecter.";
                header("Refresh: 2; url=login.php");
            } else {
                $error = "Erreur lors de l'inscription!";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription - Gestion Faculté</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-7">
                <div class="card shadow">
                    <div class="card-body p-5">
                        <h2 class="text-center mb-4">Inscription</h2>
                        
                        <?php if ($error): ?>
                            <div class="alert alert-danger"><?php echo $error; ?></div>
                        <?php endif; ?>
                        
                        <?php if ($success): ?>
                            <div class="alert alert-success"><?php echo $success; ?></div>
                        <?php endif; ?>
                        
                        <form method="POST">
                            <div class="mb-3">
                                <label for="nom" class="form-label">Nom complet</label>
                                <input type="text" class="form-control" id="nom" name="nom" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="role" class="form-label">Rôle</label>
                                <select class="form-control" id="role" name="role" required>
                                    <option value="etudiant">Étudiant</option>
                                    <option value="enseignant">Enseignant</option>
                                </select>
                            </div>
                            
                            <div class="mb-3">
                                <label for="mot_de_passe" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" required>
                            </div>
                            
                            <div class="mb-3">
                                <label for="confirm_mot_de_passe" class="form-label">Confirmer mot de passe</label>
                                <input type="password" class="form-control" id="confirm_mot_de_passe" name="confirm_mot_de_passe" required>
                            </div>
                            
                            <button type="submit" class="btn btn-success w-100">S'inscrire</button>
                        </form>
                        
                        <hr>
                        
                        <p class="text-center">Déjà inscrit? <a href="login.php">Se connecter ici</a></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
