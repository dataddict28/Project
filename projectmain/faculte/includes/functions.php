<?php
// Démarrer la session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Fonction pour hashage du mot de passe
function hash_password($password) {
    return password_hash($password, PASSWORD_BCRYPT);
}

// Fonction pour vérifier le mot de passe
function verify_password($password, $hash) {
    return password_verify($password, $hash);
}

// Fonction pour vérifier si l'utilisateur est connecté
function is_logged_in() {
    return isset($_SESSION['user_id']);
}

// Fonction pour rediriger si non connecté
function require_login() {
    if (!is_logged_in()) {
        header("Location: login.php");
        exit();
    }
}

// Fonction pour rediriger selon le rôle
function require_role($role) {
    require_login();
    if ($_SESSION['role'] != $role) {
        header("Location: dashboard.php");
        exit();
    }
}

// Fonction pour obtenir les informations de l'utilisateur
function get_user_info($conn, $user_id) {
    $query = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    return $stmt->get_result()->fetch_assoc();
}

// Fonction pour afficher des messages
function display_message($type, $message) {
    echo "<div class='alert alert-$type' role='alert'>$message</div>";
}

// Fonction pour faire un SELECT
function fetch_all($conn, $query, $params = []) {
    $stmt = $conn->prepare($query);
    if (!empty($params)) {
        $types = str_repeat("s", count($params));
        $stmt->bind_param($types, ...$params);
    }
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Fonction pour faire un INSERT/UPDATE/DELETE
function execute_query($conn, $query, $params = []) {
    $stmt = $conn->prepare($query);
    if (!empty($params)) {
        $types = str_repeat("s", count($params));
        $stmt->bind_param($types, ...$params);
    }
    return $stmt->execute();
}
?>
