<?php

class PipelineModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /* 🔹 Récupérer les fiches par stage + pipeline */
    public function getFichesByStage($stage, $pipelineId) {
        $stmt = $this->conn->prepare("
            SELECT *
            FROM fiches
            WHERE statut = ?
              AND pipeline_id = ?
        ");
        $stmt->bind_param('si', $stage, $pipelineId);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /* 🔹 Tous les pipelines (pour le dropdown) */
    public function getAllPipelines() {
        $sql = "SELECT * FROM pipelines ORDER BY created_at ASC";
        $result = $this->conn->query($sql);
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /* 🔹 Un pipeline par son id */
    public function getPipelineById($id) {
        $stmt = $this->conn->prepare("SELECT * FROM pipelines WHERE id = ?");
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_assoc();
    }

    /* 🔹 Créer un nouveau pipeline */
    public function createPipeline($nom) {
        $stmt = $this->conn->prepare("INSERT INTO pipelines (nom) VALUES (?)");
        $stmt->bind_param('s', $nom);
        if ($stmt->execute()) {
            return $stmt->insert_id;
        }
        return false;
    }
}

