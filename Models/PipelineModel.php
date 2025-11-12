<?php
class PipelineModel {
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function getFichesByStage($stage) {
        $stmt = $this->conn->prepare("SELECT * FROM fiches WHERE statut = ?");
        $stmt->bind_param('s', $stage);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
