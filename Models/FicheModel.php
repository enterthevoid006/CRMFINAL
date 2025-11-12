<?php
class FicheModel {
    private $conn;

    public function __construct($dbConn) {
        $this->conn = $dbConn;
    }

    public function getFicheById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM fiches WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function getNotes($fiche_id) {
        $stmt = $this->conn->prepare("SELECT * FROM notes WHERE fiche_id = ? ORDER BY date_creation DESC");
        $stmt->bind_param("i", $fiche_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getFichiers($fiche_id) {
        $stmt = $this->conn->prepare("SELECT * FROM fichiers WHERE fiche_id = ? ORDER BY date_upload DESC");
        $stmt->bind_param("i", $fiche_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    public function getTaches($fiche_id) {
        $stmt = $this->conn->prepare("SELECT * FROM taches WHERE fiche_id = ? ORDER BY date_creation DESC");
        $stmt->bind_param("i", $fiche_id);
        $stmt->execute();
        return $stmt->get_result();
    }
}

