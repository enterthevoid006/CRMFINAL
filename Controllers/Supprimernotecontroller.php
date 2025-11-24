<?php
require_once __DIR__ . '/../Models/Ajouter_noteModel.php';

class SupprimerNoteController {
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

        $noteId  = intval($_POST['note_id'] ?? 0);
        $ficheId = intval($_POST['fiche_id'] ?? 0);

        if ($noteId <= 0 || $ficheId <= 0) {
            echo "Paramètres invalides.";
            return;
        }

        // Supprimer la note
        $this->model->supprimerNote($noteId, $ficheId);

        // Rediriger vers la fiche
        header("Location: index.php?page=fiche&id=" . $ficheId);
        exit;
    }
}
