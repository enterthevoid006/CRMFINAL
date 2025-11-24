<?php
require_once __DIR__ . '/../Models/PipelineModel.php';
require_once __DIR__ . '/../Models/FicheModel.php';

class PipelineController {

    private $model;
    private $conn;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->model = new PipelineModel($conn);
    }

    /* ────────────────────────────────────────────────
       🔹 AFFICHAGE DU PIPELINE (KANBAN)
    ──────────────────────────────────────────────── */
    public function index() {

        // Stages du pipeline
        $stages = ['Prospect', 'En cours', 'Gagné', 'Perdu'];
        $fiches = [];

        // Tous les pipelines disponibles
        $pipelines = $this->model->getAllPipelines();

        // Si aucun pipeline en base, on en crée un par défaut
        if (empty($pipelines)) {
            $defaultId = $this->model->createPipeline('Général');
            $pipelines = $this->model->getAllPipelines();
        }

        // ID du pipeline courant : GET ? sinon premier
        if (isset($_GET['pipeline_id'])) {
            $currentPipelineId = (int) $_GET['pipeline_id'];
        } else {
            $currentPipelineId = (int) $pipelines[0]['id'];
        }

        // Sécuriser : s’assurer qu’il existe
        $currentPipeline = $this->model->getPipelineById($currentPipelineId);
        if (!$currentPipeline) {
            $currentPipelineId = (int) $pipelines[0]['id'];
            $currentPipeline = $pipelines[0];
        }

        // Récupérer les fiches pour chaque stage dans ce pipeline
        foreach ($stages as $stage) {
            $fiches[$stage] = $this->model->getFichesByStage($stage, $currentPipelineId);
        }

        // Inclure la vue
        include __DIR__ . '/../Views/pipeline.view.php';
    }
}

