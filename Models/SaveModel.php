<?php
class SaveModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    /**
     * Crée une nouvelle fiche contact
     */
    public function creerFiche(array $data): bool {
        // Vérifie les colonnes existantes dans la table
        $columns_result = $this->conn->query("SHOW COLUMNS FROM fiches");
        $columns = [];
        while ($col = $columns_result->fetch_assoc()) {
            $columns[] = $col['Field'];
        }

        // Champs obligatoires
        $fields = ['prenom', 'nom', 'email', 'profession', 'statut'];
        $placeholders = ['?', '?', '?', '?', '?'];
        $types = 'sssss';
        $values = [
            $data['prenom'],
            $data['nom'],
            $data['email'],
            $data['profession'],
            $data['statut']
        ];

        // Champs optionnels
        $optionals = ['telephone', 'societe', 'origine', 'notes'];
        foreach ($optionals as $opt) {
            if (in_array($opt, $columns) && isset($data[$opt])) {
                $fields[] = $opt;
                $placeholders[] = '?';
                $types .= 's';
                $values[] = $data[$opt];
            }
        }

        // Requête SQL
        $sql = "INSERT INTO fiches (" . implode(', ', $fields) . ", date_creation)
                VALUES (" . implode(', ', $placeholders) . ", NOW())";

        $stmt = $this->conn->prepare($sql);
        if (!$stmt) {
            throw new Exception("Erreur SQL : " . $this->conn->error);
        }

        $stmt->bind_param($types, ...$values);
        $ok = $stmt->execute();
        $stmt->close();

        return $ok;
    }
}
