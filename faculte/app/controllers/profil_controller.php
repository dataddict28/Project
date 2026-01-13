<?php

if ($_SESSION['role'] != 'etudiant') {
    header("Location: ?page=dashboard");
    exit();
}

// Get student profile
$etudiant = Etudiant::getByUserId($_SESSION['user_id']);

if (!$etudiant) {
    // Create student profile if it doesn't exist
    $user_query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($user_query);
    $stmt->bind_param('i', $_SESSION['user_id']);
    $stmt->execute();
    $user = $stmt->get_result()->fetch_assoc();

    if ($user) {
        Etudiant::create($user['nom'], $user['email']);
        $etudiant = Etudiant::getByUserId($_SESSION['user_id']);
    }
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nom = trim($_POST['nom'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $date_naissance = $_POST['date_naissance'] ?? '';
    $adresse = trim($_POST['adresse'] ?? '');
    $telephone = trim($_POST['telephone'] ?? '');

    // Handle photo upload
    $photo_path = $etudiant['photo']; // Keep existing photo by default

    if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = '../uploads/profiles/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0755, true);
        }

        $file_extension = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        $allowed_extensions = ['jpg', 'jpeg', 'png', 'gif'];

        if (in_array($file_extension, $allowed_extensions)) {
            $new_filename = 'profile_' . $_SESSION['user_id'] . '_' . time() . '.' . $file_extension;
            $target_path = $upload_dir . $new_filename;

            if (move_uploaded_file($_FILES['photo']['tmp_name'], $target_path)) {
                // Delete old photo if exists
                if ($etudiant['photo'] && file_exists('../' . $etudiant['photo'])) {
                    unlink('../' . $etudiant['photo']);
                }
                $photo_path = 'uploads/profiles/' . $new_filename;
            } else {
                $error = 'Erreur lors du téléchargement de la photo.';
            }
        } else {
            $error = 'Format de fichier non autorisé. Utilisez JPG, PNG ou GIF.';
        }
    }

    if (empty($error)) {
        // Update profile
        if (Etudiant::updateProfile($_SESSION['user_id'], $nom, $email, $date_naissance, $adresse, $telephone, $photo_path)) {
            $success = 'Profil mis à jour avec succès.';
            // Refresh student data
            $etudiant = Etudiant::getByUserId($_SESSION['user_id']);
            $_SESSION['nom'] = $nom; // Update session name
        } else {
            $error = 'Erreur lors de la mise à jour du profil.';
        }
    }
}

$page_title = 'Mon Profil';
$content = include APP_PATH . '/views/profil_view.php';
include APP_PATH . '/views/layout.php';
?>
