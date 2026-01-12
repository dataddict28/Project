<div class="card mb-4">
    <div class="card-header">
        <h4 class="mb-0">
            <i class="bi bi-calendar-plus me-2"></i>Enregistrer une Absence
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
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="date_absence" class="form-label">Date</label>
                    <input type="date" class="form-control" id="date_absence" name="date_absence" required>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="statut" class="form-label">Statut</label>
                    <select class="form-select" id="statut" name="statut">
                        <option value="absent">Absent</option>
                        <option value="present">Présent</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn-success">
                <i class="bi bi-check-circle me-2"></i>Enregistrer
            </button>
        </form>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h4 class="mb-0">
            <i class="bi bi-calendar-check me-2"></i>Historique des Absences
        </h4>
    </div>
    <div class="card-body">
        <?php if (empty($absences)): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>Aucune absence enregistrée.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Étudiant</th>
                            <th>Cours</th>
                            <th>Date</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($absences as $abs): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($abs['etudiant_nom']); ?></td>
                                <td><?php echo htmlspecialchars($abs['cours_nom']); ?></td>
                                <td><?php echo htmlspecialchars($abs['date_absence']); ?></td>
                                <td>
                                    <span class="badge <?php echo $abs['statut'] == 'present' ? 'bg-success' : 'bg-danger'; ?>">
                                        <?php echo ucfirst($abs['statut']); ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
