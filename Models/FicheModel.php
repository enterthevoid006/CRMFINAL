<?php
class FicheModel {
    private $conn;

    public function __construct($dbConn) {
        $this->conn = $dbConn;
    }

    /* ────────────────────────────────────────────────
       🔹 FICHE
    ──────────────────────────────────────────────── */
    public function getFicheById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM fiches WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        return $stmt->get_result()->fetch_assoc();
    }

    public function deleteFiche($id) {
        $stmt = $this->conn->prepare("DELETE FROM fiches WHERE id = ?");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    /* ────────────────────────────────────────────────
       🔹 NOTES
    ──────────────────────────────────────────────── */
    public function getNotes($fiche_id) {
        $stmt = $this->conn->prepare("
            SELECT * FROM notes 
            WHERE fiche_id = ? 
            ORDER BY date_creation DESC
        ");
        $stmt->bind_param("i", $fiche_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    /* ────────────────────────────────────────────────
       🔹 FICHIERS
    ──────────────────────────────────────────────── */
    public function getFichiers($fiche_id) {
        $stmt = $this->conn->prepare("
            SELECT * FROM fichiers 
            WHERE fiche_id = ? 
            ORDER BY date_upload DESC
        ");
        $stmt->bind_param("i", $fiche_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    /* ────────────────────────────────────────────────
       🔹 TÂCHES (liées à une fiche)
    ──────────────────────────────────────────────── */
    public function getTaches($fiche_id) {
        $stmt = $this->conn->prepare("
            SELECT * FROM taches 
            WHERE fiche_id = ? 
            ORDER BY date_creation DESC
        ");
        $stmt->bind_param("i", $fiche_id);
        $stmt->execute();
        return $stmt->get_result();
    }

    /* ────────────────────────────────────────────────
       🔹 AJOUTER UNE TÂCHE
    ──────────────────────────────────────────────── */
    public function ajouterTache($fiche_id, $titre, $description, $date_echeance, $statut = 'À faire') {
        $stmt = $this->conn->prepare("
            INSERT INTO taches (fiche_id, titre, description, date_echeance, statut, date_creation)
            VALUES (?, ?, ?, ?, ?, NOW())
        ");
        $stmt->bind_param("issss", $fiche_id, $titre, $description, $date_echeance, $statut);
        return $stmt->execute();
    }

    /* ────────────────────────────────────────────────
       🔹 MARQUER UNE TÂCHE COMME TERMINÉE
    ──────────────────────────────────────────────── */
    public function terminerTache($id) {
        $stmt = $this->conn->prepare("
            UPDATE taches 
            SET statut = 'Terminée' 
            WHERE id = ?
        ");
        $stmt->bind_param("i", $id);
        return $stmt->execute();
    }

    /* ────────────────────────────────────────────────
       🔹 TÂCHES DU JOUR (toutes fiches confondues)
    ──────────────────────────────────────────────── */
    public function getTachesDuJour() {
        $stmt = $this->conn->prepare("
            SELECT 
                t.*, 
                f.prenom, 
                f.nom
            FROM taches t
            LEFT JOIN fiches f ON f.id = t.fiche_id
            WHERE DATE(t.date_echeance) = CURDATE()
            ORDER BY t.date_creation DESC
        ");
        $stmt->execute();
        return $stmt->get_result();
    }
}

