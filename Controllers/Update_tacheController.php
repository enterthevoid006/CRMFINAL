<?php
require_once __DIR__ . '/../Models/Update_tacheModel.php';

class Update_tacheController {
    private $model;

    public function __construct() {
        $this->conn = require __DIR__ . '/../Config/config.php';
        $this->model = new Update_tacheModel($this->conn);
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = intval($_POST['id'] ?? 0);

            if ($this->model->terminerTache($id)) {
                echo "success";
            } else {
                echo "error";
            }
        } else {
            http_response_code(405);
            echo "invalid";
        }
    }
}
