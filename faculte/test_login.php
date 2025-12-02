<?php
session_start();

include 'config/database.php';

// Test 1: Vérifier la connexion à la base de données
echo "<h2>Test de Connexion à la Base de Données</h2>";
if ($conn->connect_error) {
    echo "ERREUR: " . $conn->connect_error;
} else {
    echo "✓ Connexion à la base de données OK<br>";
}

// Test 2: Vérifier si l'utilisateur admin existe
echo "<h2>Test de l'Utilisateur Admin</h2>";
$query = "SELECT * FROM users WHERE email = 'admin@faculte.com'";
$result = $conn->query($query);

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    echo "✓ Utilisateur admin trouvé<br>";
    echo "ID: " . $user['id'] . "<br>";
    echo "Email: " . $user['email'] . "<br>";
    echo "Hash stocké: " . $user['mot_de_passe'] . "<br>";
    echo "Rôle: " . $user['role'] . "<br>";
} else {
    echo "ERREUR: Utilisateur admin non trouvé!";
}

// Test 3: Tester la vérification du mot de passe
echo "<h2>Test de Vérification du Mot de Passe</h2>";
$password_test = "admin123";
$hash_test = $user['mot_de_passe'];

if (password_verify($password_test, $hash_test)) {
    echo "✓ Le mot de passe est CORRECT<br>";
} else {
    echo "ERREUR: Le mot de passe ne correspond pas<br>";
}

// Test 4: Tester le login directement
echo "<h2>Test de Connexion</h2>";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'] ?? '';
    $mot_de_passe = $_POST['mot_de_passe'] ?? '';
    
    $query = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($mot_de_passe, $user['mot_de_passe'])) {
            echo "✓ CONNEXION RÉUSSIE!";
        } else {
            echo "ERREUR: Mot de passe incorrect";
        }
    } else {
        echo "ERREUR: Email non trouvé";
    }
}
?>

<form method="POST">
    <input type="email" name="email" value="admin@faculte.com" required>
    <input type="password" name="mot_de_passe" value="admin123" required>
    <button type="submit">Tester Login</button>
</form>
