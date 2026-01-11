<?php
// Génère un vrai hash bcrypt pour le mot de passe "admin123"
$password = "admin123";
$hash = password_hash($password, PASSWORD_BCRYPT);

echo "Copier ce hash:<br>";
echo "<strong>" . $hash . "</strong><br><br>";
echo "À mettre dans phpMyAdmin dans le champ mot_de_passe de l'utilisateur admin";
?>
