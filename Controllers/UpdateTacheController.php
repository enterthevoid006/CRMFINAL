<?php
class UpdateTacheController {
    private $conn;

    public function __construct() {
        // Connexion à la base de données
        $this->conn = require __DIR__ . '/../Config/config.php';
    }

    public function index() {
        // Vérifie que c’est bien un appel POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo "Méthode non autorisée";
            return;
        }

        // Récupération et validation de l'ID
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        if ($id <= 0) {
            http_response_code(400);
            echo "ID invalide";
            return;
        }

        // Statut par défaut
        $statut = $_POST['statut'] ?? 'Terminée';

        // Appel du modèle
        require_once __DIR__ . '/../Models/FicheModel.php';
        $model = new FicheModel($this->conn);

        // Mise à jour du statut de la tâche
        if (mb_strtolower($statut) === 'terminée') {
            $ok = $model->terminerTache($id);
        } else {
            $stmt = $this->conn->prepare("UPDATE taches SET statut = ? WHERE id = ?");
            $stmt->bind_param("si", $statut, $id);
            $ok = $stmt->execute();
        }

        echo $ok ? 'success' : 'error';
    }
}
