<div class="card">
    <div class="card-header">
        <h4 class="mb-0">
            <i class="bi bi-calendar-x-fill me-2"></i>Mes Absences
        </h4>
    </div>
    <div class="card-body">
        <?php if (empty($absences)): ?>
            <div class="alert alert-success">
                <i class="bi bi-check-circle me-2"></i>Excellent! Vous n'avez aucune absence enregistrée.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Cours</th>
                            <th>Date</th>
                            <th>Statut</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($absences as $abs): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($abs['cours_nom'] ?? 'N/A'); ?></td>
                                <td><?php echo htmlspecialchars($abs['date_absence'] ?? '-'); ?></td>
                                <td>
                                    <span class="badge <?php echo ($abs['statut'] == 'present' || $abs['statut'] == 'Présent') ? 'bg-success' : 'bg-danger'; ?>">
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
