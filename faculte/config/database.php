<?php
// Configuration de la base de données
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'faculte');

// Connexion à la base de données
try {
    $conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    
    // Vérifier la connexion
    if ($conn->connect_error) {
        die("Erreur de connexion: " . $conn->connect_error);
    }
    
    // Définir le charset UTF-8
    $conn->set_charset("utf8");
    
} catch (Exception $e) {
    die("Erreur: " . $e->getMessage());
}
?>
