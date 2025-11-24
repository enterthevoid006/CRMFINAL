<?php
require_once __DIR__ . '/../Models/Ajouter_noteModel.php';

class AjouterNoteController {
    private $model;

    public function __construct($conn) {
        $this->model = new Ajouter_noteModel($conn);
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo "Méthode non autorisée.";
            return;
        }

        $ficheId = intval($_POST['fiche_id'] ?? 0);
        $contenu = trim($_POST['contenu'] ?? '');

        if ($ficheId <= 0) {
            echo "❌ fiche_id manquant.";
            return;
        }

        if (!$this->model->ajouterNote($ficheId, $contenu)) {
            echo "⚠️ Impossible d’ajouter la note.";
            return;
        }

        header("Location: index.php?page=fiche&id=" . $ficheId);
        exit;
    }
}

