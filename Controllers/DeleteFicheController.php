<?php
class DeleteFicheController {
    private $conn;

    public function __construct() {
        // 🔹 Connexion via config.php
        $this->conn = require __DIR__ . '/../Config/config.php';
    }

    public function index() {
        // 🔹 Vérifie la méthode
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo "Méthode non autorisée";
            return;
        }

        // 🔹 Récupère et sécurise l’ID
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        if ($id <= 0) {
            http_response_code(400);
            echo "ID invalide";
            return;
        }

        // 🔹 Supprime la fiche via le modèle
        require_once __DIR__ . '/../Models/FicheModel.php';
        $model = new FicheModel($this->conn);

        $ok = $model->deleteFiche($id);

        echo $ok ? "success" : "error";
    }
}
