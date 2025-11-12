<?php
class DashboardModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    // 🔹 Statistiques du pipeline
    public function getStats() {
        return [
            'total_clients' => $this->count("SELECT COUNT(*) AS total FROM fiches"),
            'prospects'     => $this->count("SELECT COUNT(*) AS total FROM fiches WHERE statut='Prospect'"),
            'encours'       => $this->count("SELECT COUNT(*) AS total FROM fiches WHERE statut='En cours'"),
            'gagnes'        => $this->count("SELECT COUNT(*) AS total FROM fiches WHERE statut='Gagné'"),
            'perdus'        => $this->count("SELECT COUNT(*) AS total FROM fiches WHERE statut='Perdu'")
        ];
    }

    private function count($query) {
        $result = $this->conn->query($query);
        $row = $result->fetch_assoc();
        return $row['total'] ?? 0;
    }

    // 🔹 Liste des dernières fiches (5 dernières)
    public function getLastFiches() {
        return $this->conn->query("SELECT * FROM fiches ORDER BY id DESC LIMIT 5");
    }
}

