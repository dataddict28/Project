<?php
class Absence {
    protected static $db;
    
    public static function setDB($db) {
        self::$db = $db;
    }
    
    public static function getByEtudiantId($etudiant_id) {
        $query = "SELECT a.*, u.nom, c.nom as cours_nom FROM absences a
                  JOIN etudiants e ON a.etudiant_id = e.id
                  JOIN users u ON e.user_id = u.id
                  JOIN cours c ON a.cours_id = c.id
                  WHERE a.etudiant_id = ?
                  ORDER BY a.date DESC";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $etudiant_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public static function getByCourseId($cours_id) {
        $query = "SELECT a.*, u.nom as etudiant_nom FROM absences a
                  JOIN etudiants e ON a.etudiant_id = e.id
                  JOIN users u ON e.user_id = u.id
                  WHERE a.cours_id = ?
                  ORDER BY a.date DESC";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $cours_id);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public static function create($etudiant_id, $cours_id, $date, $statut = 'Absent') {
        $query = "INSERT INTO absences (etudiant_id, cours_id, date, statut) VALUES (?, ?, ?, ?)";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('iiss', $etudiant_id, $cours_id, $date, $statut);
        return $stmt->execute();
    }
    
    public static function delete($id) {
        $query = "DELETE FROM absences WHERE id = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
?>
