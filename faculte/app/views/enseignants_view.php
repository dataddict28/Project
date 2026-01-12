<div class="card mb-4">
    <div class="card-header">
        <h4 class="mb-0">
            <i class="bi bi-person-badge me-2"></i>Ajouter un Enseignant
        </h4>
    </div>
    <div class="card-body">
        <form method="POST">
            <input type="hidden" name="action" value="add">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nom" class="form-label">Nom</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="specialite" class="form-label">Spécialité</label>
                    <input type="text" class="form-control" id="specialite" name="specialite">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="telephone" class="form-label">Téléphone</label>
                    <input type="tel" class="form-control" id="telephone" name="telephone">
                </div>
            </div>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle me-2"></i>Ajouter
            </button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="mb-0">
            <i class="bi bi-people-fill me-2"></i>Liste des Enseignants
        </h4>
    </div>
    <div class="card-body">
        <?php if (empty($enseignants)): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>Aucun enseignant enregistré.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Spécialité</th>
                            <th>Téléphone</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($enseignants as $ens): ?>
                            <tr>
                                <td><?php echo $ens['id']; ?></td>
                                <td><strong><?php echo htmlspecialchars($ens['nom']); ?></strong></td>
                                <td><?php echo htmlspecialchars($ens['email']); ?></td>
                                <td><?php echo htmlspecialchars($ens['specialite'] ?? '-'); ?></td>
                                <td><?php echo htmlspecialchars($ens['telephone'] ?? '-'); ?></td>
                                <td>
                                    <a href="?page=enseignants&delete=<?php echo $ens['id']; ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet enseignant?');">
                                        <i class="bi bi-trash me-1"></i>Supprimer
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
