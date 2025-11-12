<?php
require_once __DIR__ . '/../Models/SaveModel.php';

class SaveController {
    private $model;

    public function __construct() {
        global $conn;
        $this->model = new SaveModel($conn);
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupération et nettoyage des données
            $data = [
                'nom'        => trim($_POST['nom'] ?? ''),
                'prenom'     => trim($_POST['prenom'] ?? ''),
                'email'      => trim($_POST['email'] ?? ''),
                'telephone'  => trim($_POST['telephone'] ?? ''),
                'profession' => trim($_POST['profession'] ?? ''),
                'societe'    => trim($_POST['societe'] ?? ''),
                'statut'     => ucfirst(strtolower(trim($_POST['statut'] ?? 'Prospect'))),
                'origine'    => trim($_POST['origine'] ?? ''),
                'notes'      => trim($_POST['notes'] ?? '')
            ];

            // Validation des champs obligatoires
            if (empty($data['nom']) || empty($data['prenom']) || empty($data['email'])) {
                die("⚠️ Erreur : les champs nom, prénom et email sont obligatoires.");
            }

            // Normalisation du statut
            $valeurs_valides = ['Prospect', 'En cours', 'Gagné', 'Perdu'];
            if (!in_array($data['statut'], $valeurs_valides)) {
                $data['statut'] = 'Prospect';
            }

            try {
                if ($this->model->creerFiche($data)) {
                    header("Location: index.php?page=list&success=1");
                    exit;
                } else {
                    echo "<p>❌ Erreur lors de l'enregistrement.</p>";
                }
            } catch (Exception $e) {
                echo "<p>❌ " . htmlspecialchars($e->getMessage()) . "</p>";
            }
        } else {
            echo "<p>⚠️ Aucun formulaire soumis.</p>";
        }
    }
}
