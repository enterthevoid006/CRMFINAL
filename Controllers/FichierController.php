<?php
require_once __DIR__ . '/../Models/FicheModel.php';

class UploadFichierController {
    private $conn;
    private $model;

    public function __construct($conn) {
        $this->conn = $conn;
        $this->model = new FicheModel($conn);
    }

    public function index() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            die('Méthode non autorisée');
        }

        $fiche_id = intval($_POST['fiche_id'] ?? 0);
        $fichier = $_FILES['fichier'] ?? null;

        if (!$fiche_id || !$fichier) {
            die('Paramètres manquants.');
        }

        // Vérifie les erreurs d’upload
        if ($fichier['error'] !== UPLOAD_ERR_OK) {
            header("Location: index.php?page=fiche&id=$fiche_id&upload=error");
            exit;
        }

        // Répertoire d’upload
        $upload_dir = __DIR__ . '/../uploads/';
        if (!is_dir($upload_dir)) {
            mkdir($upload_dir, 0777, true);
        }

        // Nettoyage du nom de fichier
        $nom_fichier = basename($fichier['name']);
        $nom_nettoye = preg_replace('/[^A-Za-z0-9_\-.]/', '_', $nom_fichier);
        $chemin_final = $upload_dir . time() . '_' . $nom_nettoye;

        // Déplacement du fichier
        if (move_uploaded_file($fichier['tmp_name'], $chemin_final)) {
            $chemin_affichage = 'uploads/' . basename($chemin_final);

            // Insertion en base
            $stmt = $this->conn->prepare("
                INSERT INTO fichiers (fiche_id, nom_fichier, chemin, date_upload)
                VALUES (?, ?, ?, NOW())
            ");
            $stmt->bind_param("iss", $fiche_id, $nom_nettoye, $chemin_affichage);
            $stmt->execute();
            $stmt->close();

            header("Location: index.php?page=fiche&id=$fiche_id&upload=success");
            exit;
        } else {
            header("Location: index.php?page=fiche&id=$fiche_id&upload=moveerror");
            exit;
        }
    }
}
