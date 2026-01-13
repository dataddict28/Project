<?php
class Paiement {
    protected static $db;
    
    public static function setDB($db) {
        self::$db = $db;
    }
    
    public static function getAll() {
        $query = "SELECT p.*, e.numero_matricule, u.nom, u.email 
                  FROM paiements p 
                  LEFT JOIN etudiants e ON p.etudiant_id = e.id 
                  LEFT JOIN users u ON e.user_id = u.id";
        $stmt = self::$db->prepare($query);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
    
    public static function getById($id) {
        $query = "SELECT * FROM paiements WHERE id = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }
    
    public static function create($etudiant_id, $montant, $statut) {
        $query = "INSERT INTO paiements (etudiant_id, montant, statut) VALUES (?, ?, ?)";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('ids', $etudiant_id, $montant, $statut);
        return $stmt->execute();
    }
    
    public static function updateStatut($id, $statut) {
        $query = "UPDATE paiements SET statut = ? WHERE id = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('si', $statut, $id);
        return $stmt->execute();
    }
    
    public static function delete($id) {
        $query = "DELETE FROM paiements WHERE id = ?";
        $stmt = self::$db->prepare($query);
        $stmt->bind_param('i', $id);
        return $stmt->execute();
    }
}
?>
