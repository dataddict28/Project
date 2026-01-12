<div class="card">
    <div class="card-header" style="padding: 2rem 1.75rem;">
        <h2 style="margin: 0;">
            <i class="bi bi-house-door-fill me-2"></i>Bienvenue dans le système de gestion de faculté
        </h2>
    </div>
    <div class="card-body">
        <p class="lead" style="margin-bottom: 1.5rem;">
            Connecté en tant que: <span style="background-color: #e6f0ff; color: #0066cc; padding: 0.25rem 0.75rem; border-radius: 6px; font-weight: 600;">
                <?php echo ucfirst(str_replace('_', ' ', $role)); ?>
            </span>
        </p>
        
        <?php if ($role == 'admin'): ?>
            <div class="alert alert-info">
                <h4 style="margin-bottom: 0.5rem;">
                    <i class="bi bi-person-badge me-2"></i>Accès Administrateur
                </h4>
                <p style="margin-bottom: 0;">Vous avez accès à toutes les fonctionnalités du système. Gérez les enseignants, les cours, les étudiants et suivez les absences.</p>
            </div>
        <?php elseif ($role == 'enseignant'): ?>
            <div class="alert alert-info">
                <h4 style="margin-bottom: 0.5rem;">
                    <i class="bi bi-person-check me-2"></i>Accès Enseignant
                </h4>
                <p style="margin-bottom: 0;">Consultez vos cours, gérez les absences de vos étudiants et inscrivez les élèves à vos cours.</p>
            </div>
        <?php elseif ($role == 'etudiant'): ?>
            <div class="alert alert-info">
                <h4 style="margin-bottom: 0.5rem;">
                    <i class="bi bi-mortarboard me-2"></i>Accès Étudiant
                </h4>
                <p style="margin-bottom: 0;">Consultez vos cours inscrits et vérifiez vos absences.</p>
            </div>
        <?php endif; ?>

        <!-- Statistics Cards -->
        <div class="row g-4 mt-3">
            <div class="col-md-6 col-lg-3">
                <div class="stat-card stat-card-primary">
                    <div class="stat-icon">
                        <i class="bi bi-people-fill"></i>
                    </div>
                    <div class="stat-content">
                        <h5 class="stat-label">Utilisateurs</h5>
                        <p class="stat-value">Actifs</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="stat-card stat-card-success">
                    <div class="stat-icon">
                        <i class="bi bi-book-fill"></i>
                    </div>
                    <div class="stat-content">
                        <h5 class="stat-label">Cours</h5>
                        <p class="stat-value">Disponibles</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="stat-card stat-card-warning">
                    <div class="stat-icon">
                        <i class="bi bi-calendar-x-fill"></i>
                    </div>
                    <div class="stat-content">
                        <h5 class="stat-label">Absences</h5>
                        <p class="stat-value">Suivi</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-3">
                <div class="stat-card stat-card-danger">
                    <div class="stat-icon">
                        <i class="bi bi-clipboard-check-fill"></i>
                    </div>
                    <div class="stat-content">
                        <h5 class="stat-label">Inscriptions</h5>
                        <p class="stat-value">Gérées</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
