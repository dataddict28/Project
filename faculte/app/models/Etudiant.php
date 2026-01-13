<?php
class Etudiant {
    protected static $db;
    
    public static function setDB($db) {
        self::$db = $db;
    }
    
    public static function getAll() {
        $query = "SELECT u.*, e.numero_matricule, e.date_naissance FROM users u 
                  LEFT JOIN etudiants e ON u.id = e.user_id 
                  WHERE u.role = 'etudiant'";
        $stmt = self::$db->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public static function getById($id) {
        $query = "SELECT u.*, e.numero_matricule, e.date_naissance, e.adresse, e.telephone, e.photo
                  FROM users u
                  LEFT JOIN etudiants e ON u.id = e.user_id
                  WHERE u.id = ? AND u.role = 'etudiant'";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public static function getByUserId($user_id) {
        $query = "SELECT * FROM etudiants WHERE user_id = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $user_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public static function create($nom, $email, $date_naissance = null, $adresse = null, $telephone = null) {
        // Create user
        $password_hash = password_hash('password123', PASSWORD_BCRYPT);
        $role = 'etudiant';
        $user_query = "INSERT INTO users (nom, email, mot_de_passe, role) VALUES (?, ?, ?, ?)";
        $user_stmt = self::$db->prepare($user_query);
        $user_stmt->bind_param("ssss", $nom, $email, $password_hash, $role);
        
        if ($user_stmt->execute()) {
            $user_id = self::$db->insert_id;
            $numero_matricule = "STU" . str_pad($user_id, 5, '0', STR_PAD_LEFT);
            
            // Create student profile
            $etud_query = "INSERT INTO etudiants (user_id, numero_matricule, date_naissance, adresse, telephone) 
                          VALUES (?, ?, ?, ?, ?)";
            $etud_stmt = self::$db->prepare($etud_query);
            $etud_stmt->bind_param("issss", $user_id, $numero_matricule, $date_naissance, $adresse, $telephone);
            $etud_stmt->execute();
            
            return $user_id;
        }
        return false;
    }
    
    public static function updateProfile($user_id, $nom, $email, $date_naissance, $adresse, $telephone, $photo = null) {
        // Update user info
        $user_query = "UPDATE users SET nom = ?, email = ? WHERE id = ? AND role = 'etudiant'";
        $user_stmt = self::$db->prepare($user_query);
        $user_stmt->bind_param("ssi", $nom, $email, $user_id);
        $user_stmt->execute();

        // Update student profile
        if ($photo !== null) {
            $etud_query = "UPDATE etudiants SET date_naissance = ?, adresse = ?, telephone = ?, photo = ? WHERE user_id = ?";
            $etud_stmt = self::$db->prepare($etud_query);
            $etud_stmt->bind_param("ssssi", $date_naissance, $adresse, $telephone, $photo, $user_id);
        } else {
            $etud_query = "UPDATE etudiants SET date_naissance = ?, adresse = ?, telephone = ? WHERE user_id = ?";
            $etud_stmt = self::$db->prepare($etud_query);
            $etud_stmt->bind_param("sssi", $date_naissance, $adresse, $telephone, $user_id);
        }
        return $etud_stmt->execute();
    }

    public static function delete($id) {
        $query = "DELETE FROM users WHERE id = ? AND role = 'etudiant'";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }

    public static function getAllWithPaymentsAndSemesters() {
        $query = "SELECT u.*, e.id AS etudiant_id, e.numero_matricule, e.date_naissance, e.semestre1_valide, e.semestre2_valide,
                         p.statut AS paiement_statut
                  FROM users u
                  INNER JOIN etudiants e ON u.id = e.user_id
                  LEFT JOIN paiements p ON e.id = p.etudiant_id
                  WHERE u.role = 'etudiant'";
        $stmt = self::$db->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public static function updateSemesterValidation($user_id, $semestre1_valide, $semestre2_valide) {
        $query = "UPDATE etudiants SET semestre1_valide = ?, semestre2_valide = ? WHERE user_id = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('iii', $semestre1_valide, $semestre2_valide, $user_id);
        return $stmt->execute();
    }
}
?>
