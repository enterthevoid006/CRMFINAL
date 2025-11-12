<?php
/**
 * ===========================
 * 🌐 ORDEX CRM - FRONT CONTROLLER
 * ===========================
 * Point d'entrée unique de l'application.
 * Gère le routage MVC, la sécurité et la configuration globale.
 */

ob_start();
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);
session_start();

// ---------------------------------------------------------
// 1️⃣ Chargement de la configuration globale
// ---------------------------------------------------------
$conn = require __DIR__ . '/Config/config.php';

// ---------------------------------------------------------
// 2️⃣ Détermination de la page demandée
// ---------------------------------------------------------
$page = $_GET['page'] ?? 'dashboard';
$page = strtolower(trim($page));

// ---------------------------------------------------------
// 3️⃣ Gestion des pages publiques / protégées
// ---------------------------------------------------------
$public_pages = ['login', 'register'];

if (!isset($_SESSION['user_id']) && !in_array($page, $public_pages)) {
    // Redirige vers login si pas connecté
    header("Location: index.php?page=login");
    exit();
}

// ---------------------------------------------------------
// 4️⃣ Conversion du nom de page en format StudlyCase
//     Exemple : ajouter_tache → AjouterTacheController
// ---------------------------------------------------------
$studly = str_replace(' ', '', ucwords(str_replace(['-', '_'], ' ', $page)));
$controllerName = $studly . 'Controller';
$controllerPath = __DIR__ . "/Controllers/{$controllerName}.php";

// ---------------------------------------------------------
// 5️⃣ Vérification du contrôleur et exécution de la méthode index()
// ---------------------------------------------------------
if (file_exists($controllerPath)) {
    require_once $controllerPath;

    if (class_exists($controllerName)) {

        // ⚙️ Vérifie si le constructeur du contrôleur attend la connexion
        $reflection = new ReflectionClass($controllerName);
        $constructor = $reflection->getConstructor();

        if ($constructor && $constructor->getNumberOfParameters() > 0) {
            $controller = new $controllerName($conn); // Injection de la connexion
        } else {
            $controller = new $controllerName();
        }

        // ✅ Exécution de la méthode index()
        if (method_exists($controller, 'index')) {
            $controller->index();
        } else {
            echo "<h2 style='color:white;'>❌ Erreur : la méthode <code>index()</code> est manquante dans <strong>$controllerName</strong>.</h2>";
        }

    } else {
        echo "<h2 style='color:white;'>❌ Erreur : la classe <strong>$controllerName</strong> n'existe pas dans le fichier.</h2>";
    }

} else {
    // ---------------------------------------------------------
    // 6️⃣ Page introuvable (404 stylée)
    // ---------------------------------------------------------
    http_response_code(404);
    echo "
    <main style='
        font-family:Inter,sans-serif;
        text-align:center;
        padding:4rem;
        color:#e5e7eb;
        background:#0f172a;
        min-height:100vh;
    '>
        <h1 style='font-size:3rem;color:#3b82f6;margin-bottom:1rem;'>Erreur 404</h1>
        <p style='font-size:1.2rem;margin-bottom:2rem;'>
            Le contrôleur <strong>$controllerName</strong> est introuvable.
        </p>
        <a href='index.php?page=dashboard' style='
            color:#60a5fa;
            text-decoration:none;
            font-weight:600;
        '>⬅ Retour au tableau de bord</a>
    </main>";
}



