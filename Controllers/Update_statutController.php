<?php
require_once __DIR__ . '/../Models/Update_statutModel.php';

class Update_statutController {
    private $model;

    public function __construct() {
        $this->conn = require __DIR__ . '/../Config/config.php';
        $this->model = new Update_statutModel($this->conn);
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);
            $statut = trim($_POST['statut'] ?? '');

            if ($this->model->updateStatut($id, $statut)) {
                echo "success";
            } else {
                echo "error";
            }
        } else {
            http_response_code(405);
            echo "Méthode non autorisée";
        }
    }
}
