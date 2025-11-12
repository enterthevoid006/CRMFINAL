<?php
class AjouterTacheController {
    private $conn;

    public function __construct() {
        // ✅ Récupération de la connexion à la base
        $this->conn = require __DIR__ . '/../Config/config.php';
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die("Méthode non autorisée");
        }

        // 🔹 Récupération sécurisée des données du formulaire
        $fiche_id = isset($_POST['fiche_id']) ? intval($_POST['fiche_id']) : 0;
        $titre = trim($_POST['titre'] ?? '');
        $description = trim($_POST['description'] ?? '');
        $date_echeance = $_POST['date_echeance'] ?? date('Y-m-d');
        $statut = $_POST['statut'] ?? 'À faire';

        if ($fiche_id <= 0 || $titre === '') {
            die("❌ Données invalides.");
        }

        require_once __DIR__ . '/../Models/FicheModel.php';
        $model = new FicheModel($this->conn);

        // 🔹 Insertion de la tâche via le modèle
        $ok = $model->ajouterTache($fiche_id, $titre, $description, $date_echeance, $statut);

        if ($ok) {
            // ✅ Redirection vers la fiche correspondante
            header("Location: index.php?page=fiche&id=" . $fiche_id);
            exit;
        } else {
            echo "❌ Erreur lors de l’ajout de la tâche.";
        }
    }
}
