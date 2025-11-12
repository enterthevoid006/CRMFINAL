<?php
require_once __DIR__ . '/../Models/Creer_contactModel.php';

class Creer_contactController {
    private $model;

    public function __construct($conn) {
        $this->model = new Creer_contactModel($conn);
    }

    public function index() {
        // Si c’est un POST → on enregistre la fiche
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'nom'        => trim($_POST['nom'] ?? ''),
                'prenom'     => trim($_POST['prenom'] ?? ''),
                'email'      => trim($_POST['email'] ?? ''),
                'telephone'  => trim($_POST['telephone'] ?? ''),
                'profession' => trim($_POST['profession'] ?? ''),
                'societe'    => trim($_POST['societe'] ?? ''),
                'statut'     => trim($_POST['statut'] ?? 'Prospect'),
                'origine'    => trim($_POST['origine'] ?? ''),
                'notes'      => trim($_POST['notes'] ?? '')
            ];

            $ficheId = $this->model->ajouterFiche($data);

            if ($ficheId) {
                header("Location: index.php?page=fiche&id=" . $ficheId);
                exit;
            } else {
                echo "<p style='color:white;'>❌ Erreur lors de l’enregistrement de la fiche.</p>";
            }
        }

        // Sinon → on affiche simplement le formulaire (ta page HTML)
        require __DIR__ . '/../Views/creer_contact.view.php';
    }
}

