<?php
class LoginController {
    public function index() {
        require_once __DIR__ . '/../Config/config.php';
        global $conn;

        // 🧭 Pour vérifier que la page s'exécute bien
        echo "<p style='color:yellow'>[DEBUG] LoginController chargé</p>";

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            echo "<p style='color:orange'>[DEBUG] POST reçu</p>";

            $username = trim($_POST['username'] ?? '');
            $password = trim($_POST['password'] ?? '');

            echo "<p>[DEBUG] Username saisi : <strong>$username</strong></p>";

            if ($username === '' || $password === '') {
                echo "<p style='color:red'>Champs manquants.</p>";
            } else {
                $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = ?");
                $stmt->bind_param("s", $username);
                $stmt->execute();
                $result = $stmt->get_result();
                $user = $result->fetch_assoc();

                if (!$user) {
                    echo "<p style='color:red'>[DEBUG] Aucun utilisateur trouvé pour '$username'</p>";
                } else {
                    echo "<p style='color:green'>[DEBUG] Utilisateur trouvé : ID = {$user['id']}</p>";

                    if (password_verify($password, $user['password'])) {
                        echo "<p style='color:lime'>[DEBUG] Mot de passe valide ✅</p>";

                        $_SESSION['user_id'] = $user['id'];
                        $_SESSION['username'] = $user['username'];

                        header("Location: index.php?page=dashboard");
                        exit;
                    } else {
                        echo "<p style='color:red'>[DEBUG] Mot de passe incorrect ❌</p>";
                    }
                }
            }
        }

        require __DIR__ . '/../Views/login.view.php';
    }
}
 


