<div class="card mb-4">
    <div class="card-header">
        <h4 class="mb-0">
            <i class="bi bi-clipboard-plus me-2"></i>Inscrire un Étudiant à un Cours
        </h4>
    </div>
    <div class="card-body">
        <form method="POST">
            <input type="hidden" name="action" value="add">
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="etudiant_id" class="form-label">Étudiant</label>
                    <select class="form-select" id="etudiant_id" name="etudiant_id" required>
                        <option value="">-- Sélectionner --</option>
                        <?php foreach ($etudiants as $etud): ?>
                            <option value="<?php echo $etud['id']; ?>"><?php echo htmlspecialchars($etud['nom']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="cours_id" class="form-label">Cours</label>
                    <select class="form-select" id="cours_id" name="cours_id" required>
                        <option value="">-- Sélectionner --</option>
                        <?php foreach ($cours_list as $c): ?>
                            <option value="<?php echo $c['id']; ?>"><?php echo htmlspecialchars($c['nom']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle me-2"></i>Inscrire
            </button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="mb-0">
            <i class="bi bi-list-check me-2"></i>Inscriptions de Mes Cours
        </h4>
    </div>
    <div class="card-body">
        <?php if (empty($inscriptions)): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>Aucun étudiant inscrit à vos cours pour le moment.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Étudiant</th>
                            <th>Cours</th>
                            <th>Date d'inscription</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($inscriptions as $insc): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($insc['etudiant_nom']); ?></td>
                                <td><?php echo htmlspecialchars($insc['cours_nom']); ?></td>
                                <td><?php echo htmlspecialchars($insc['date_inscription'] ?? '-'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
