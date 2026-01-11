<?php
class Inscription {
    protected static $db;
    
    public static function setDB($db) {
        self::$db = $db;
    }
    
    public static function getAll() {
        $query = "SELECT i.*, u.nom as etudiant_nom, c.nom as cours_nom FROM inscriptions i
                  JOIN etudiants e ON i.etudiant_id = e.id
                  JOIN users u ON e.user_id = u.id
                  JOIN cours c ON i.cours_id = c.id";
        $stmt = self::$db->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public static function getByEtudiantId($etudiant_id) {
        $query = "SELECT c.* FROM inscriptions i
                  JOIN cours c ON i.cours_id = c.id
                  WHERE i.etudiant_id = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $etudiant_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public static function getByCourseId($cours_id) {
        $query = "SELECT u.id, u.nom, e.numero_matricule FROM inscriptions i
                  JOIN etudiants e ON i.etudiant_id = e.id
                  JOIN users u ON e.user_id = u.id
                  WHERE i.cours_id = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $cours_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public static function create($etudiant_id, $cours_id) {
        $query = "INSERT INTO inscriptions (etudiant_id, cours_id) VALUES (?, ?)";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('ii', $etudiant_id, $cours_id);
        return $stmt->execute();
    }
    
    public static function delete($etudiant_id, $cours_id) {
        $query = "DELETE FROM inscriptions WHERE etudiant_id = ? AND cours_id = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('ii', $etudiant_id, $cours_id);
        return $stmt->execute();
    }
}
?>
