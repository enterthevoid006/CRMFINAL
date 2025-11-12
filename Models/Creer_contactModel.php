<?php
class Creer_contactModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function ajouterFiche(array $data) {
        // 🧩 Vérification minimale
        if (empty($data['nom']) || empty($data['prenom']) || empty($data['email'])) {
            return false;
        }

        // 🧱 Préparation de la requête d'insertion
        $stmt = $this->conn->prepare("
            INSERT INTO fiches (
                nom,
                prenom,
                email,
                profession,
                statut,
                telephone,
                societe,
                origine,
                date_creation
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, NOW())
        ");

        // 🧠 Liaison des paramètres (8 valeurs -> 8 "s")
        $stmt->bind_param(
            "ssssssss",
            $data['nom'],
            $data['prenom'],
            $data['email'],
            $data['profession'],
            $data['statut'],
            $data['telephone'],
            $data['societe'],
            $data['origine']
        );

        // 🚀 Exécution de la requête
        if ($stmt->execute()) {
            $id = $this->conn->insert_id;

            // 🗒️ Si des notes sont fournies, on les insère dans la table "notes"
            if (!empty($data['notes'])) {
                $stmtNote = $this->conn->prepare("
                    INSERT INTO notes (fiche_id, contenu, date_creation)
                    VALUES (?, ?, NOW())
                ");
                $stmtNote->bind_param("is", $id, $data['notes']);
                $stmtNote->execute();
                $stmtNote->close();
            }

            $stmt->close();
            return $id;
        }

        // ❌ En cas d'erreur
        $stmt->close();
        return false;
    }
}
