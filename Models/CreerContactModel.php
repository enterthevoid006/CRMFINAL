<?php
class CreerContactModel {

    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function ajouterFiche($data) {

        $stmt = $this->conn->prepare("
            INSERT INTO fiches (
                nom,
                prenom,
                email,
                telephone,
                profession,
                societe,
                statut,
                origine,
                pipeline_id,
                date_creation
            )
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");

        // 9 valeurs → donc 9 types
        $stmt->bind_param(
            "ssssssssi",   // ✔️ FIX : 9 caractères, pas 10
            $data['nom'],
            $data['prenom'],
            $data['email'],
            $data['telephone'],
            $data['profession'],
            $data['societe'],
            $data['statut'],
            $data['origine'],
            $data['pipeline_id']
        );

        if ($stmt->execute()) {

            $fiche_id = $stmt->insert_id;

            // 🔹 Notes
            if (!empty($data['notes'])) {
                $note = $this->conn->prepare("
                    INSERT INTO notes (fiche_id, contenu, date_creation)
                    VALUES (?, ?, NOW())
                ");
                $note->bind_param("is", $fiche_id, $data['notes']);
                $note->execute();
            }

            return $fiche_id;
        }

        return false;
    }
}

