<?php
class Cours {
    protected static $db;
    
    public static function setDB($db) {
        self::$db = $db;
    }
    
    public static function getAll() {
        $query = "SELECT c.*, u.nom as enseignant_nom FROM cours c 
                  JOIN enseignants e ON c.enseignant_id = e.id 
                  JOIN users u ON e.user_id = u.id";
        $stmt = self::$db->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public static function getById($id) {
        $query = "SELECT c.*, u.nom as enseignant_nom FROM cours c 
                  JOIN enseignants e ON c.enseignant_id = e.id 
                  JOIN users u ON e.user_id = u.id 
                  WHERE c.id = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public static function getByEnseignantId($enseignant_id) {
        $query = "SELECT * FROM cours WHERE enseignant_id = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $enseignant_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public static function create($nom, $code, $description, $enseignant_id, $credits = 3) {
        $query = "INSERT INTO cours (nom, code, description, enseignant_id, credits) VALUES (?, ?, ?, ?, ?)";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param("sssii", $nom, $code, $description, $enseignant_id, $credits);
        return $stmt->execute() ? self::$db->insert_id : false;
    }
    
    public static function delete($id) {
        $query = "DELETE FROM cours WHERE id = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
?>
