<div class="login-page-wrapper">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-7 col-lg-6">
                <div class="card register-card shadow-xl">
                    <!-- Header -->
                    <div class="login-header">
                        <div class="logo-container">
                            <div class="logo-circle register-logo">
                                <i class="bi bi-person-plus-fill"></i>
                            </div>
                        </div>
                        <h1 class="login-title">Inscription</h1>
                        <p class="login-subtitle">Créer un nouveau compte</p>
                    </div>

                    <!-- Body -->
                    <div class="card-body">
                        <?php if ($error): ?>
                            <div class="alert alert-danger d-flex align-items-center" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong><?php echo htmlspecialchars($error); ?></strong>
                            </div>
                        <?php endif; ?>
                        
                        <?php if ($success): ?>
                            <div class="alert alert-success d-flex align-items-center" role="alert">
                                <i class="bi bi-check-circle-fill me-2"></i>
                                <strong><?php echo htmlspecialchars($success); ?></strong>
                            </div>
                        <?php endif; ?>
                        
                        <form method="POST" class="register-form">
                            <div class="mb-4">
                                <label for="nom" class="form-label">Nom complet</label>
                                <input type="text" class="form-control" id="nom" name="nom" placeholder="Jean Dupont" required>
                            </div>
                            
                            <div class="mb-4">
                                <label for="email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="email" name="email" placeholder="jean.dupont@exemple.com" required>
                            </div>
                            
                            <div class="mb-4">
                                <label for="role" class="form-label">Rôle</label>
                                <select class="form-select" id="role" name="role" required>
                                    <option value="etudiant">Étudiant</option>
                                    <option value="enseignant">Enseignant</option>
                                </select>
                            </div>
                            
                            <div class="mb-4">
                                <label for="mot_de_passe" class="form-label">Mot de passe</label>
                                <input type="password" class="form-control" id="mot_de_passe" name="mot_de_passe" placeholder="••••••••" required>
                            </div>
                            
                            <div class="mb-4">
                                <label for="confirm_mot_de_passe" class="form-label">Confirmer mot de passe</label>
                                <input type="password" class="form-control" id="confirm_mot_de_passe" name="confirm_mot_de_passe" placeholder="••••••••" required>
                            </div>
                            
                            <button type="submit" class="btn btn-success w-100 btn-lg">
                                <i class="bi bi-person-plus me-2"></i>S'inscrire
                            </button>
                        </form>
                        
                        <hr class="my-4" style="border: none; border-top: 2px solid var(--border);">
                        
                        <p class="text-center mb-0 text-muted">
                            Déjà inscrit? <a href="?page=login" class="text-primary fw-bold text-decoration-none">Se connecter ici</a>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

