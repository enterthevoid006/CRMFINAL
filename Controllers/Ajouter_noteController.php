<?php
require_once __DIR__ . '/../Models/Ajouter_noteModel.php';

class Ajouter_noteController {
    private $model;

    // Le front-controller te passe $conn si ton constructeur a 1 paramètre
    public function __construct($conn) {
        $this->model = new Ajouter_noteModel($conn);
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            http_response_code(405);
            echo "<p>❌ Méthode non autorisée.</p>";
            return;
        }

        $ficheId = intval($_POST['fiche_id'] ?? 0);
        $contenu = trim($_POST['contenu'] ?? '');

        if ($ficheId <= 0) {
            http_response_code(400);
            echo "<p>❌ fiche_id manquant.</p>";
            return;
        }

        if (!$this->model->ajouterNote($ficheId, $contenu)) {
            echo "<p>⚠️ Impossible d’ajouter la note (contenu vide ?).</p>";
            return;
        }

        header("Location: index.php?page=fiche&id=" . $ficheId);
        exit;
    }
}
