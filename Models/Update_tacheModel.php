<?php
class Update_tacheModel {
    private $conn;

    public function __construct($dbConn) {
        $this->conn = $dbConn;
    }

    public function terminerTache($id) {
        if ($id <= 0) return false;

        $stmt = $this->conn->prepare("UPDATE taches SET statut = 'Terminée' WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }
}
