<div class="card mb-4">
    <div class="card-header">
        <h4 class="mb-0">
            <i class="bi bi-book-half me-2"></i>Ajouter un Cours
        </h4>
    </div>
    <div class="card-body">
        <form method="POST">
            <input type="hidden" name="action" value="add">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="nom" class="form-label">Nom du cours</label>
                    <input type="text" class="form-control" id="nom" name="nom" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="code" class="form-label">Code du cours</label>
                    <input type="text" class="form-control" id="code" name="code" required>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="enseignant_id" class="form-label">Enseignant</label>
                    <select class="form-select" id="enseignant_id" name="enseignant_id" required>
                        <option value="">-- Sélectionner --</option>
                        <?php foreach ($enseignants as $ens): ?>
                            <option value="<?php echo $ens['enseignant_id']; ?>"><?php echo htmlspecialchars($ens['nom']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="credits" class="form-label">Crédits</label>
                    <input type="number" class="form-control" id="credits" name="credits" value="3" min="1" max="10">
                </div>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
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
            <i class="bi bi-list-ul me-2"></i>Liste des Cours
        </h4>
    </div>
    <div class="card-body">
        <?php if (empty($cours_list)): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>Aucun cours enregistré.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Code</th>
                            <th>Enseignant</th>
                            <th>Crédits</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cours_list as $c): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($c['nom']); ?></strong></td>
                                <td><span class="badge bg-secondary"><?php echo htmlspecialchars($c['code']); ?></span></td>
                                <td><?php echo htmlspecialchars($c['enseignant_nom']); ?></td>
                                <td><?php echo $c['credits']; ?></td>
                                <td>
                                    <a href="?page=cours&delete=<?php echo $c['id']; ?>" 
                                       class="btn btn-danger btn-sm" 
                                       onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours?');">
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
