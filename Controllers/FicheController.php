<?php
class FicheController {
    private $conn;

    public function __construct() {
        // ✅ On récupère la connexion renvoyée par config.php
        $this->conn = require __DIR__ . '/../Config/config.php';
    }

    public function index() {
        require_once __DIR__ . '/../Models/FicheModel.php';

        if (!isset($_GET['id'])) {
            die("Aucun prospect sélectionné.");
        }

        $id = intval($_GET['id']);
        $model = new FicheModel($this->conn); // ✅ maintenant $this->conn est bien défini

        $fiche = $model->getFicheById($id);
        if (!$fiche) {
            die("Fiche introuvable.");
        }

        $notes    = $model->getNotes($id);
        $fichiers = $model->getFichiers($id);
        $taches   = $model->getTaches($id);

        // Helpers
        if (!function_exists('h')) {
            function h($v){ return htmlspecialchars((string)$v, ENT_QUOTES, 'UTF-8'); }
        }
        if (!function_exists('initials')) {
            function initials($p,$n){ return strtoupper(mb_substr($p,0,1).mb_substr($n,0,1)); }
        }
        if (!function_exists('statusColor')) {
            function statusColor($s){
                return match (strtolower((string)$s)) {
                    'prospect' => 'primary',
                    'en cours' => 'warning',
                    'gagné', 'client' => 'success',
                    'perdu' => 'danger',
                    default => 'secondary'
                };
            }
        }

        require __DIR__ . '/../Views/fiche.view.php';
    }
}


