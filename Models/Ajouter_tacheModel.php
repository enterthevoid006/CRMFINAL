<?php
class Ajouter_tacheModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function ajouterTache(int $ficheId, string $titre, string $description = '', ?string $dateEcheance = null): bool {
        if (empty($titre)) return false;

        $stmt = $this->conn->prepare("
            INSERT INTO taches (fiche_id, titre, description, date_echeance)
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param("isss", $ficheId, $titre, $description, $dateEcheance);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }
}
