<?php
if (!defined('APP_NAME')) {
    define('APP_NAME', 'Ordex CRM');
}

$host = "localhost";
$user = "root";
$pass = "";
$db   = "bonjourcrm";


// ✅ Création de la connexion
$conn = new mysqli($host, $user, $pass, $db);

// ✅ Test de connexion
if ($conn->connect_error) {
    die("Erreur de connexion à la base de données : " . $conn->connect_error);
}

// ✅ Rendre la connexion accessible globalement
return $conn;


