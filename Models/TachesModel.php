<?php

class TachesModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /* ===================================================
        🔹 Récupérer les tâches du jour
    ====================================================*/
    public function getTachesDuJour($date) {
        $sql = "
            SELECT t.*, f.prenom, f.nom
            FROM taches t
            JOIN fiches f ON t.fiche_id = f.id
            WHERE t.date_echeance = ?
            ORDER BY t.date_creation DESC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $taches = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $taches;
    }

    /* ===================================================
        🔹 Tâches à venir
    ====================================================*/
    public function getTachesAVenir($date) {
        $sql = "
            SELECT t.*, f.prenom, f.nom
            FROM taches t
            JOIN fiches f ON t.fiche_id = f.id
            WHERE t.date_echeance > ?
            ORDER BY t.date_echeance ASC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $taches = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $taches;
    }

    /* ===================================================
        🔹 Tâches passées
    ====================================================*/
    public function getTachesPassees($date) {
        $sql = "
            SELECT t.*, f.prenom, f.nom
            FROM taches t
            JOIN fiches f ON t.fiche_id = f.id
            WHERE t.date_echeance < ?
            ORDER BY t.date_echeance DESC
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $date);
        $stmt->execute();
        $result = $stmt->get_result();
        $taches = $result->fetch_all(MYSQLI_ASSOC);
        $stmt->close();

        return $taches;
    }

    /* ===================================================
        🔹 Ajouter tâche
    ====================================================*/
    public function ajouterTache($fiche_id, $titre, $description, $date_echeance, $statut) {
        $sql = "
            INSERT INTO taches (fiche_id, titre, description, date_echeance, statut, date_creation)
            VALUES (?, ?, ?, ?, ?, NOW())
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('issss', $fiche_id, $titre, $description, $date_echeance, $statut);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /* ===================================================
        🔹 Supprimer tâche
    ====================================================*/
    public function supprimerTache($id) {
        $sql = "DELETE FROM taches WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }

    /* ===================================================
        🔹 Marquer comme terminée
    ====================================================*/
    public function terminerTache($id) {
        $sql = "UPDATE taches SET statut = 'Terminée' WHERE id = ?";

        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('i', $id);
        $success = $stmt->execute();
        $stmt->close();

        return $success;
    }
}
