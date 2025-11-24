<?php
require_once __DIR__ . '/../Models/FicheModel.php';

class UpdateStatutController {

    private $model;

    public function __construct($conn) {
        $this->model = new FicheModel($conn);
    }

    public function index() {

        if (!isset($_POST['id'], $_POST['statut'])) {
            echo "missing_params";
            return;
        }

        $id = intval($_POST['id']);
        $stage = trim($_POST['statut']);

        $allowed = ['Prospect', 'En cours', 'Gagné', 'Perdu'];
        if (!in_array($stage, $allowed)) {
            echo "invalid_value";
            return;
        }

        if ($this->model->updateStage($id, $stage)) {
            echo "success";
        } else {
            echo "db_error";
        }
    }
}
