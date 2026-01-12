<div class="card mb-4">
    <div class="card-header">
        <h4 class="mb-0">
            <i class="bi bi-person-plus-fill me-2"></i>Ajouter un Étudiant
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
                    <label for="date_naissance" class="form-label">Date de naissance</label>
                    <input type="date" class="form-control" id="date_naissance" name="date_naissance">
                </div>
                <div class="col-md-6 mb-3">
                    <label for="telephone" class="form-label">Téléphone</label>
                    <input type="tel" class="form-control" id="telephone" name="telephone">
                </div>
            </div>
            <div class="mb-3">
                <label for="adresse" class="form-label">Adresse</label>
                <input type="text" class="form-control" id="adresse" name="adresse">
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
            <i class="bi bi-people-fill me-2"></i>Liste des Étudiants
        </h4>
    </div>
    <div class="card-body">
        <?php if (empty($etudiants)): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>Aucun étudiant enregistré.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Matricule</th>
                            <th>Date naissance</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($etudiants as $etud): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($etud['nom']); ?></td>
                                <td><?php echo htmlspecialchars($etud['email']); ?></td>
                                <td><span class="badge bg-primary"><?php echo htmlspecialchars($etud['numero_matricule'] ?? '-'); ?></span></td>
                                <td><?php echo htmlspecialchars($etud['date_naissance'] ?? '-'); ?></td>
                                <td>
                                    <a href="?page=etudiants&delete=<?php echo $etud['id']; ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant?');">
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
