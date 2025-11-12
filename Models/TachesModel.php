<?php
class TachesModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getTachesDuJour($date) {
        $stmt = $this->conn->prepare("
            SELECT t.*, f.prenom, f.nom
            FROM taches t
            JOIN fiches f ON t.fiche_id = f.id
            WHERE t.date_echeance = ?
            ORDER BY t.date_creation DESC
        ");
        $stmt->bind_param('s', $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $taches = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $taches;
    }
}
