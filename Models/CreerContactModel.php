<?php
class CreerContactModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function ajouterFiche($data) {
        $stmt = $this->conn->prepare("
            INSERT INTO fiches (nom, prenom, email, telephone, profession, societe, statut, origine, date_creation)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");

        $stmt->bind_param(
            "ssssssss",
            $data['nom'],
            $data['prenom'],
            $data['email'],
            $data['telephone'],
            $data['profession'],
            $data['societe'],
            $data['statut'],
            $data['origine']
        );

        if ($stmt->execute()) {
            $fiche_id = $stmt->insert_id;

            // 🔹 Si des notes ont été ajoutées, on les insère dans la table notes
            if (!empty($data['notes'])) {
                $noteStmt = $this->conn->prepare("
                    INSERT INTO notes (fiche_id, contenu, date_creation)
                    VALUES (?, ?, NOW())
                ");
                $noteStmt->bind_param("is", $fiche_id, $data['notes']);
                $noteStmt->execute();
            }

            return $fiche_id;
        }

        return false;
    }
}

