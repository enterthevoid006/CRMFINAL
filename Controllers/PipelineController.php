<?php
require_once __DIR__ . '/../Models/PipelineModel.php';

class PipelineController {
    private $model;

    public function __construct($conn) {
        $this->model = new PipelineModel($conn);
    }

    public function index() {
        $stages = ['Prospect', 'En cours', 'Gagné', 'Perdu'];
        $fiches = [];

        foreach ($stages as $stage) {
            $fiches[$stage] = $this->model->getFichesByStage($stage);
        }

        include __DIR__ . '/../Views/pipeline.view.php';
    }
}
