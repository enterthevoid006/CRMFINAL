<?php
class Ajouter_noteModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function ajouterNote(int $ficheId, string $contenu): bool {
        if ($ficheId <= 0 || $contenu === '') return false;

        $stmt = $this->conn->prepare("
            INSERT INTO notes (fiche_id, contenu, date_creation)
            VALUES (?, ?, NOW())
        ");
        $stmt->bind_param("is", $ficheId, $contenu);
        $ok = $stmt->execute();
        $stmt->close();
        return $ok;
    }
}
