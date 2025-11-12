<?php
include __DIR__ . '/Config/config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fiche_id = intval($_POST['fiche_id']);
    $fichier = $_FILES['fichier'];

    if ($fichier['error'] !== UPLOAD_ERR_OK) {
        header("Location: fiche.php?id=$fiche_id&upload=error");
        exit;
    }

    $upload_dir = __DIR__ . '/uploads/';
    if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

    $nom_fichier = basename($fichier['name']);
    $nom_nettoye = preg_replace('/[^A-Za-z0-9_\-.]/', '_', $nom_fichier);
    $chemin_final = $upload_dir . time() . '_' . $nom_nettoye;

    if (move_uploaded_file($fichier['tmp_name'], $chemin_final)) {
        $stmt = $conn->prepare("
            INSERT INTO fichiers (fiche_id, nom_fichier, chemin, date_upload)
            VALUES (?, ?, ?, NOW())
        ");
        $chemin_affichage = 'uploads/' . basename($chemin_final);
        $stmt->bind_param("iss", $fiche_id, $nom_nettoye, $chemin_affichage);
        $stmt->execute();
        $stmt->close();

        header("Location: fiche.php?id=$fiche_id&upload=success");
        exit;
    } else {
        header("Location: fiche.php?id=$fiche_id&upload=moveerror");
        exit;
    }
}
?>

