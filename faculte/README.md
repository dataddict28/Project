# Système de Gestion de Faculté

## Installation

### Prérequis
- XAMPP installé (https://www.apachefriends.org/)
- Apache et MySQL démarrés

### Étapes d'installation

1. **Télécharger et décompresser les fichiers**
   - Placer le dossier `faculte` dans `C:\xampp\htdocs\` (Windows) ou `/Applications/XAMPP/htdocs/` (Mac)

2. **Créer la base de données**
   - Ouvrir phpMyAdmin: http://localhost/phpmyadmin
   - Cliquer sur "Nouvelle base de données"
   - Nommer la base: `faculte`
   - Sélectionner la base et aller à l'onglet "SQL"
   - Copier-coller le contenu du fichier `database.sql`
   - Cliquer "Exécuter"

3. **Vérifier la configuration**
   - Ouvrir `config/database.php`
   - Vérifier que DB_HOST, DB_USER, DB_PASS, DB_NAME sont corrects

4. **Accéder l'application**
   - Aller à http://localhost/faculte/pages/login.php

## Identifiants de démonstration

**Admin:**
- Email: admin@faculte.com
- Mot de passe: admin123

**Autres utilisateurs:**
- Mot de passe par défaut: password123

## Fonctionnalités

### Admin
- Gestion des enseignants (ajout, suppression)
- Gestion des cours (ajout, suppression)
- Gestion des étudiants (ajout, suppression)
- Enregistrement des absences

### Enseignant
- Consulter ses cours
- Voir les absences

### Étudiant
- Consulter ses cours
- Consulter ses absences

## Structure des fichiers

\`\`\`
faculté/
├── config/
│   └── database.php
├── includes/
│   └── functions.php
├── pages/
│   ├── login.php
│   ├── register.php
│   ├── dashboard.php
│   ├── logout.php
│   ├── enseignants.php
│   ├── cours.php
│   ├── etudiants.php
│   └── absences.php
├── assets/
│   └── style.css
└── README.md
\`\`\`

## Notes

- Les mots de passe sont hashés avec bcrypt
- Les sessions sont utilisées pour l'authentification
- Bootstrap 5 est utilisé pour l'interface
- Tous les inputs sont échappés pour éviter les injections SQL
