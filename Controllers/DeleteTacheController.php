<?php

class DeleteTacheController {
    private $conn;

    public function __construct() {
        $this->conn = require __DIR__ . '/../Config/config.php';
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Méthode non autorisée");
        }

        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

        if ($id <= 0) {
            echo "ID invalide";
            exit;
        }

        require_once __DIR__ . '/../Models/TachesModel.php';
        $model = new TachesModel($this->conn);

        $ok = $model->supprimerTache($id);

        if ($ok) {
            echo "success";
        } else {
            echo "Erreur lors de la suppression";
        }
    }
}
