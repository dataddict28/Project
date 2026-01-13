<div class="card">
    <div class="card-header" style="padding: 2rem 1.75rem;">
        <div class="d-flex justify-content-between align-items-center">
            <h2 style="margin: 0;">
                <i class="bi bi-person-circle me-2"></i>Mon Profil
            </h2>
            <a href="?page=dashboard" class="btn btn-secondary">
                <i class="bi bi-arrow-left me-2"></i>Retour au Dashboard
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-4 text-center mb-4">
                <div class="profile-photo-container">
                    <?php if (isset($etudiant['photo']) && $etudiant['photo']): ?>
                        <img src="<?php echo htmlspecialchars('../' . $etudiant['photo']); ?>" alt="Photo de profil" class="profile-photo img-fluid rounded-circle" style="width: 200px; height: 200px; object-fit: cover; border: 4px solid #007bff;">
                    <?php else: ?>
                        <div class="profile-photo-placeholder rounded-circle d-inline-flex align-items-center justify-content-center" style="width: 200px; height: 200px; background-color: #e9ecef; border: 4px solid #007bff;">
                            <i class="bi bi-person-fill" style="font-size: 5rem; color: #6c757d;"></i>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-md-8">
                <form method="POST" enctype="multipart/form-data">
                    <div class="row g-3">
                        <div class="col-md-6">
                            <label for="nom" class="form-label">Nom complet</label>
                            <input type="text" class="form-control" id="nom" name="nom" value="<?php echo htmlspecialchars($etudiant['nom'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($etudiant['email'] ?? ''); ?>" required>
                        </div>
                        <div class="col-md-6">
                            <label for="date_naissance" class="form-label">Date de naissance</label>
                            <input type="date" class="form-control" id="date_naissance" name="date_naissance" value="<?php echo htmlspecialchars($etudiant['date_naissance'] ?? ''); ?>">
                        </div>
                        <div class="col-md-6">
                            <label for="telephone" class="form-label">Téléphone</label>
                            <input type="tel" class="form-control" id="telephone" name="telephone" value="<?php echo htmlspecialchars($etudiant['telephone'] ?? ''); ?>">
                        </div>
                        <div class="col-12">
                            <label for="adresse" class="form-label">Adresse</label>
                            <textarea class="form-control" id="adresse" name="adresse" rows="3"><?php echo htmlspecialchars($etudiant['adresse'] ?? ''); ?></textarea>
                        </div>
                        <div class="col-12">
                            <label for="photo" class="form-label">Photo de profil</label>
                            <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
                            <div class="form-text">Formats acceptés: JPG, PNG, GIF. Taille maximale: 5MB.</div>
                        </div>
                        <div class="col-12">
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-check-circle me-2"></i>Mettre à jour le profil
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<style>
.profile-photo-container {
    position: relative;
}
</style>
