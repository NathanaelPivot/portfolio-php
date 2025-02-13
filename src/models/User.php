
<?php
require_once '../config/database.php';

class User {
    public static function findByEmail($email) {
        global $pdo;
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public static function createUser($username, $email, $password) {
        global $pdo;
        $stmt = $pdo->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        return $stmt->execute([
            'username' => $username,
            'email' => $email,
            'password' => $password,
        ]);
    }
}