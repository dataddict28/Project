<div class="login-page-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 col-lg-4">
                <div class="card login-card shadow-xl">
                    <!-- Header -->
                    <div class="login-header">
                        <div class="logo-container">
                            <div class="logo-circle">
                                <i class="bi bi-mortarboard-fill"></i>
                            </div>
                        </div>
                        <h1 class="login-title">Gestion Faculté</h1>
                        <p class="login-subtitle">Système de Gestion Académique</p>
                    </div>

                    <!-- Body -->
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong><?php echo htmlspecialchars($error); ?></strong>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" class="login-form">
                            <div class="mb-4">
                                <label for="email" class="form-label">Adresse Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="votre.email@exemple.com" required>
                            </div>
                            
                            <div class="mb-4">
                                <label for="mot_de_passe" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" placeholder="••••••••" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary w-100 btn-lg">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Se connecter
                            </button>
                        </form>

                        <hr class="my-4" style="border: none; border-top: 2px solid var(--border);">

                        <p class="text-center mb-3 text-muted">Pas encore inscrit?</p>
                        <a href="?page=register" class="btn btn-outline-primary w-100">
                            <i class="bi bi-person-plus me-2"></i>Créer un compte
                        </a>
                    </div>

                    <!-- Footer with demo credentials -->
                    <div class="login-footer">
                        <p class="footer-label"><strong>Démo Admin:</strong></p>
                        <p class="footer-text">Email: admin@faculte.com</p>
                        <p class="footer-text">Mot de passe: admin123</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

