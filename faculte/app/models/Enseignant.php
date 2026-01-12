<?php
class Enseignant {
    protected static $db;
    
    public static function setDB($db) {
        self::$db = $db;
    }
    
    public static function getAll() {
        $query = "SELECT u.*, e.id as enseignant_id, e.specialite, e.telephone FROM enseignants e 
                  JOIN users u ON e.user_id = u.id";
        $stmt = self::$db->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public static function getById($id) {
        $query = "SELECT e.id, u.* FROM enseignants e 
                  JOIN users u ON e.user_id = u.id 
                  WHERE e.id = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public static function getByUserId($user_id) {
        $query = "SELECT * FROM enseignants WHERE user_id = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public static function create($nom, $email, $specialite = null, $telephone = null) {
        $password_hash = password_hash('password123', PASSWORD_BCRYPT);
        $role = 'enseignant';
        $user_query = "INSERT INTO users (nom, email, mot_de_passe, role) VALUES (?, ?, ?, ?)";
        $user_stmt = self::$db->prepare($user_query);
        $user_stmt->bind_param("ssss", $nom, $email, $password_hash, $role);
        
        if ($user_stmt->execute()) {
            $user_id = self::$db->insert_id;
            
            $ens_query = "INSERT INTO enseignants (user_id, specialite, telephone) VALUES (?, ?, ?)";
            $ens_stmt = self::$db->prepare($ens_query);
            $ens_stmt->bind_param("iss", $user_id, $specialite, $telephone);
            $ens_stmt->execute();
            
            return $user_id;
        }
        return false;
        
    }
    
    public static function delete($id) {
        $query = "DELETE FROM users WHERE id IN (SELECT user_id FROM enseignants WHERE id = ?)";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
?>
