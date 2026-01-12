<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Gestion Faculté</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo isset($page_title) ? $page_title . ' - ' : ''; ?>Gestion Faculté</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="<?php 
        // Use simple relative path from public/index.php to assets/style.css
        $assets_path = '../assets/style.css';
        echo $assets_path . '?v=' . time();
    ?>">
</head>
<body>
    <?php if (isset($show_navbar) && $show_navbar): ?>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container-fluid px-4">
            <a class="navbar-brand d-flex align-items-center" href="?page=dashboard">
                <div class="logo-icon me-2">
                    <i class="bi bi-mortarboard-fill"></i>
                </div>
                <div class="brand-text">
                    <span class="brand-name">Gestion Faculté</span>
                    <small class="brand-subtitle d-block">Système Académique</small>
                </div>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <span class="nav-link">
                            <i class="bi bi-person-circle me-1"></i>
                            <?php echo htmlspecialchars($_SESSION['nom'] ?? ''); ?>
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="?page=logout">
                            <i class="bi bi-box-arrow-right me-1"></i>
                            Déconnexion
                        </a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <?php endif; ?>

    <?php if (isset($show_sidebar) && $show_sidebar): ?>
    <nav class="sidebar">
        <h2>Menu</h2>
        <ul>
            <li><a href="?page=dashboard">Accueil</a></li>

            <?php if ($_SESSION['role'] === 'admin'): ?>
                <li><a href="?page=etudiants">Étudiants</a></li>
                <li><a href="?page=enseignants">Enseignants</a></li>
                <li><a href="?page=cours">Cours</a></li>
                <li><a href="?page=inscriptions">Inscriptions</a></li>
                <li><a href="?page=absences">Gérer Absences</a></li>
            <?php elseif ($_SESSION['role'] === 'enseignant'): ?>
                <li><a href="?page=mes_cours_enseignant">Mes Cours</a></li>
                <li><a href="?page=mes_absences_enseignant">Gérer Absences</a></li>
                <li><a href="?page=inscriptions_enseignant">Inscrire Étudiants</a></li>
            <?php elseif ($_SESSION['role'] === 'etudiant'): ?>
                <li><a href="?page=mes_cours">Mes Cours</a></li>
                <li><a href="?page=mes_absences">Mes Absences</a></li>
            <?php endif; ?>

            <li><a href="?page=logout">Déconnexion</a></li>
        </ul>
    </nav>
    <?php endif; ?>

    <div class="container-fluid py-4" style="padding-top: 5rem;">
        <div class="row g-4">
            <!-- Main Content -->
            <div class="col-12">
                <?php if (isset($error) && $error): ?>
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="bi bi-exclamation-triangle-fill me-2"></i>
                        <strong><?php echo htmlspecialchars($error); ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php if (isset($success) && $success): ?>
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="bi bi-check-circle-fill me-2"></i>
                        <strong><?php echo htmlspecialchars($success); ?></strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <?php echo $content; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<html lang="fr">
