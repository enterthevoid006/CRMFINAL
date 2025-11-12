<?php
require_once __DIR__ . '/../Models/TachesModel.php';

class TachesController {
    private $model;

    public function __construct($conn) {
        $this->model = new TachesModel($conn);
    }

    public function index() {
        date_default_timezone_set('Europe/Paris');
        $today = date('Y-m-d');
        $taches = $this->model->getTachesDuJour($today);

        include __DIR__ . '/../Views/taches.view.php';
    }
}
