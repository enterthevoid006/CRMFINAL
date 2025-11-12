<?php
class Update_statutModel {
    private $conn;

    public function __construct($dbConn) {
        $this->conn = $dbConn;
    }

    public function updateStatut($id, $statut) {
        if ($id <= 0 || empty($statut)) return false;

        $stmt = $this->conn->prepare("UPDATE fiches SET statut = ? WHERE id = ?");
        $stmt->bind_param("si", $statut, $id);
        return $stmt->execute();
    }
}
