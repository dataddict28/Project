<div class="paiements-page">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-plus-circle-fill me-2"></i>Ajouter un Paiement
                    </h4>
                </div>
                <div class="card-body">
                    <form method="POST">
                        <input type="hidden" name="action" value="add_payment">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <label for="etudiant_id" class="form-label">Étudiant</label>
                                <select class="form-select" id="etudiant_id" name="etudiant_id" required>
                                    <option value="">Sélectionner un étudiant</option>
                                    <?php foreach ($etudiants as $etud): ?>
                                        <option value="<?php echo $etud['etudiant_id']; ?>">
                                            <?php echo htmlspecialchars($etud['nom'] . ' (' . ($etud['numero_matricule'] ?? 'N/A') . ')'); ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="montant" class="form-label">Montant (€)</label>
                                <input type="number" step="0.01" class="form-control" id="montant" name="montant" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="statut" class="form-label">Statut</label>
                                <select class="form-select" id="statut" name="statut" required>
                                    <option value="en_attente">En attente</option>
                                    <option value="paye">Payé</option>
                                    <option value="annule">Annulé</option>
                                </select>
                            </div>
                        </div>
                        <button type="submit" class="btn btn-success">
                            <i class="bi bi-check-circle me-2"></i>Ajouter le paiement
                        </button>
                    </form>
                </div>
            </div>

            <div class="card">
                <div class="card-header">
                    <h4 class="mb-0">
                        <i class="bi bi-receipt me-2"></i>Liste des Paiements
                    </h4>
                </div>
                <div class="card-body">
                    <?php if (empty($paiements)): ?>
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>Aucun paiement enregistré.
                        </div>
                    <?php else: ?>
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Étudiant</th>
                                        <th>Matricule</th>
                                        <th>Montant</th>
                                        <th>Statut</th>
                                        <th>Date</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($paiements as $paiement): ?>
                                        <tr>
                                            <td><?php echo $paiement['id']; ?></td>
                                            <td><?php echo htmlspecialchars($paiement['nom']); ?></td>
                                            <td><span class="badge bg-secondary"><?php echo htmlspecialchars($paiement['numero_matricule'] ?? '-'); ?></span></td>
                                            <td><?php echo number_format($paiement['montant'], 2, ',', ' '); ?> €</td>
                                            <td><span class="badge bg-secondary"><?php echo htmlspecialchars($paiement['statut']); ?></span></td>
                                            <td><?php echo date('d/m/Y H:i', strtotime($paiement['date_paiement'])); ?></td>
                                            <td>
                                                <a href="?page=paiements&delete_payment=<?php echo $paiement['id']; ?>"
                                                   class="btn btn-danger btn-sm"
                                                   onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce paiement?');">
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
        </div>
    </div>
</div>
