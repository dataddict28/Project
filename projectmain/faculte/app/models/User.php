<?php
class User {
    protected static $db;
    
    public static function setDB($db) {
        self::$db = $db;
    }
    
    public static function getById($id) {
        $stmt = self::$db->prepare('SELECT * FROM users WHERE id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public static function getByEmail($email) {
        $stmt = self::$db->prepare('SELECT * FROM users WHERE email = ?');
        $stmt->bind_param('s', $email);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public static function authenticate($email, $password) {
        $user = self::getByEmail($email);
        if ($user && password_verify($password, $user['password_hash'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
        return false;
    }
    
    public static function register($nom, $email, $password, $role) {
        if (self::getByEmail($email)) {
            return false;
        }
        
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = self::$db->prepare('INSERT INTO users (nom, email, password_hash, role) VALUES (?, ?, ?, ?)');
        $stmt->bind_param('ssss', $nom, $email, $password_hash, $role);
        
        if ($stmt->execute()) {
            $user_id = $stmt->insert_id;
            
            // Create student or teacher profile
            if ($role === 'etudiant') {
                $numero_matricule = 'STU' . str_pad($user_id, 5, '0', STR_PAD_LEFT);
                $stmt2 = self::$db->prepare('INSERT INTO etudiants (user_id, numero_matricule) VALUES (?, ?)');
                $stmt2->bind_param('is', $user_id, $numero_matricule);
                $stmt2->execute();
            } elseif ($role === 'enseignant') {
                $stmt2 = self::$db->prepare('INSERT INTO enseignants (user_id) VALUES (?)');
                $stmt2->bind_param('i', $user_id);
                $stmt2->execute();
            }
            
            return true;
        }
        
        return false;
    }
}

// Initialize DB connection for User model
User::setDB($mysqli);
?>
