<?php
require_once __DIR__ . '/../Models/CreerContactModel.php';

class CreerContactController {

    private $model;

    public function __construct($conn) {
        $this->model = new CreerContactModel($conn);
    }

    public function index() {

        // 🔹 Enregistrement de la fiche
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            $data = [
                'nom'         => trim($_POST['nom'] ?? ''),
                'prenom'      => trim($_POST['prenom'] ?? ''),
                'email'       => trim($_POST['email'] ?? ''),
                'telephone'   => trim($_POST['telephone'] ?? ''),
                'profession'  => trim($_POST['profession'] ?? ''),
                'societe'     => trim($_POST['societe'] ?? ''),
                'statut'      => trim($_POST['statut'] ?? 'Prospect'),
                'origine'     => trim($_POST['origine'] ?? ''),
                'notes'       => trim($_POST['notes'] ?? ''),
                'pipeline_id' => intval($_POST['pipeline_id'] ?? 1)
            ];

            $ficheId = $this->model->ajouterFiche($data);

            if ($ficheId) {
                header("Location: index.php?page=fiche&id=" . $ficheId . "&pipeline_id=" . $data['pipeline_id']);
                exit;
            } else {
                echo "<p style='color:white;'>❌ Erreur lors de l’enregistrement de la fiche.</p>";
            }
        }

        // 🔹 Affichage du formulaire
        require __DIR__ . '/../Views/creer_contact.view.php';
    }
}


