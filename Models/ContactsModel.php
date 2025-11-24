<?php
class ContactsModel {
    private $conn;

    public function __construct($dbConn) {
        $this->conn = $dbConn;
    }

    public function getContacts($search = '', $statut = '') {
        $query = "SELECT * FROM fiches WHERE 1";
        $params = [];
        $types = "";

        if ($search) {
            $query .= " AND (nom LIKE ? OR prenom LIKE ? OR email LIKE ? OR societe LIKE ?)";
            $searchTerm = "%{$search}%";
            $params = array_merge($params, [$searchTerm, $searchTerm, $searchTerm, $searchTerm]);
            $types .= "ssss";
        }

        if ($statut) {
            $query .= " AND statut = ?";
            $params[] = $statut;
            $types .= "s";
        }

        $query .= " ORDER BY date_creation DESC";

        $stmt = $this->conn->prepare($query);
        if (!empty($params)) $stmt->bind_param($types, ...$params);
        $stmt->execute();
        return $stmt->get_result();
    }
}
