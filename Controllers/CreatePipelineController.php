<?php
require_once __DIR__ . '/../Models/PipelineModel.php';

class CreatePipelineController {

    private $model;

    public function __construct($conn) {
        $this->model = new PipelineModel($conn);
    }

    public function index() {

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (empty($_POST['nom'])) {
                header('Location: index.php?page=pipeline');
                exit;
            }

            $nom = trim($_POST['nom']);
            if (mb_strlen($nom) > 255) {
                $nom = mb_substr($nom, 0, 255);
            }

            $newId = $this->model->createPipeline($nom);

            if ($newId) {
                // Redirection vers le pipeline vierge
                header('Location: index.php?page=pipeline&pipeline_id=' . (int) $newId);
                exit;
            }
        }

        // Fallback : retour au pipeline
        header('Location: index.php?page=pipeline');
        exit;
    }
}
