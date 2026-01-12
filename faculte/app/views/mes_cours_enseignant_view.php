<div class="card">
    <div class="card-header">
        <h4 class="mb-0">
            <i class="bi bi-book-fill me-2"></i>Mes Cours
        </h4>
    </div>
    <div class="card-body">
        <?php if (empty($cours_list)): ?>
            <div class="alert alert-info">
                <i class="bi bi-info-circle me-2"></i>Vous n'enseignez aucun cours pour le moment.
            </div>
        <?php else: ?>
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Nom du Cours</th>
                            <th>Code</th>
                            <th>Description</th>
                            <th>Crédits</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($cours_list as $c): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($c['nom']); ?></strong></td>
                                <td><span class="badge bg-secondary"><?php echo htmlspecialchars($c['code']); ?></span></td>
                                <td><?php echo htmlspecialchars($c['description'] ?? '-'); ?></td>
                                <td><?php echo $c['credits']; ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </div>
</div>
