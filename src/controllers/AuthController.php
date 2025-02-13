
<?php
require_once '../src/models/User.php';

class AuthController {

    public static function loginPage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $user = User::findByEmail($email);
            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id']; // Stocker l'ID utilisateur dans la session
                $_SESSION['user'] = [
                    'id' => $user['id'],
                    'username' => $user['username'],
                    'role' => $user['role'] // si les rôles existent
                ];

                header('Location: /');
                exit;
            } else {
                $error = "Identifiants incorrects.";
            }
        }

        require_once '../src/views/auth/login.php';
    }

    public static function registerPage() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
            $result = User::createUser($username, $email, $hashedPassword);

            if ($result) {
                header('Location: /login');
                exit;
            } else {
                $error = "Erreur lors de l'inscription.";
            }
        }

        require_once '../src/views/auth/register.php';
    }

    public static function logout() {
        session_destroy();
        header('Location: /');
        exit;
    }
}