<?php
class TachesController {
    private $conn;

    public function __construct() {
        $this->conn = require __DIR__ . '/../Config/config.php';
    }

    public function index() {
        require_once __DIR__ . '/../Models/FicheModel.php';
        $model = new FicheModel($this->conn);

        $today = date('Y-m-d');

        // 🔹 Récupération de toutes les tâches
        $stmt = $this->conn->prepare("
            SELECT t.*, f.prenom, f.nom
            FROM taches t
            LEFT JOIN fiches f ON f.id = t.fiche_id
            ORDER BY t.date_echeance ASC, t.date_creation DESC
        ");
        $stmt->execute();
        $taches = $stmt->get_result();

        // 🔹 Tri logique
        $tachesJour = [];
        $tachesPassees = [];
        $tachesAVenir = [];

        while ($t = $taches->fetch_assoc()) {
            if (empty($t['date_echeance'])) continue;

            if ($t['date_echeance'] < $today) {
                $tachesPassees[] = $t;
            } elseif ($t['date_echeance'] === $today) {
                $tachesJour[] = $t;
            } else {
                $tachesAVenir[] = $t;
            }
        }

        require __DIR__ . '/../Views/taches.view.php';
    }
}
