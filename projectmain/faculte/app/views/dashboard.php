<?php
// This file contains only the view logic
?>
<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Gestion Faculté</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <nav class="sidebar">
        <h2>Menu</h2>
        <ul>
            <li><a href="?page=dashboard">Accueil</a></li>
            
            <?php if ($role === 'admin'): ?>
                <li><a href="?page=etudiants">Étudiants</a></li>
                <li><a href="?page=enseignants">Enseignants</a></li>
                <li><a href="?page=cours">Cours</a></li>
                <li><a href="?page=inscriptions">Inscriptions</a></li>
                <li><a href="?page=absences">Gérer Absences</a></li>
            <?php elseif ($role === 'enseignant'): ?>
                <li><a href="?page=mes_cours_enseignant">Mes Cours</a></li>
                <li><a href="?page=mes_absences_enseignant">Gérer Absences</a></li>
                <li><a href="?page=inscriptions_enseignant">Inscrire Étudiants</a></li>
            <?php elseif ($role === 'etudiant'): ?>
                <li><a href="?page=mes_cours">Mes Cours</a></li>
                <li><a href="?page=mes_absences">Mes Absences</a></li>
            <?php endif; ?>
            
            <li><a href="?page=logout">Déconnexion</a></li>
        </ul>
    </nav>
    
    <main class="content">
        <h1>Bienvenue, <?= htmlspecialchars($user['nom']) ?></h1>
        <p>Rôle: <?= htmlspecialchars($role) ?></p>
    </main>
</body>
</html>
