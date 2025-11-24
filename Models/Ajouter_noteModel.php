<?php
class Ajouter_noteModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /* ───────────────────────────────────────────────
        AJOUTER UNE NOTE
    ─────────────────────────────────────────────── */
    public function ajouterNote(int $ficheId, string $contenu): bool {
        if ($ficheId <= 0 || trim($contenu) === '') return false;

        $stmt = $this->conn->prepare("
            INSERT INTO notes (fiche_id, contenu, date_creation)
            VALUES (?, ?, NOW())
        ");
        $stmt->bind_param("is", $ficheId, $contenu);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    /* ───────────────────────────────────────────────
        SUPPRIMER UNE NOTE
    ─────────────────────────────────────────────── */
    public function supprimerNote(int $noteId, int $ficheId): bool {
        if ($noteId <= 0 || $ficheId <= 0) return false;

        $stmt = $this->conn->prepare("
            DELETE FROM notes 
            WHERE id = ? AND fiche_id = ?
        ");
        $stmt->bind_param("ii", $noteId, $ficheId);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }

    /* ───────────────────────────────────────────────
        (OPTIONNEL) RÉCUPÉRER UNE NOTE PAR ID
        UTILE POUR EDITER UNE NOTE PLUS TARD
    ─────────────────────────────────────────────── */
    public function getNoteById(int $noteId) {
        $stmt = $this->conn->prepare("SELECT * FROM notes WHERE id = ?");
        $stmt->bind_param("i", $noteId);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_assoc();
        $stmt->close();

        return $result;
    }
}
