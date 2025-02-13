<?php
define('DB_HOST', 'localhost');
define('DB_PORT', 3306);
define('DB_NAME', 'projetb2');
define('DB_USER', 'root');
define('DB_PASS', '');

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";port=" . DB_PORT . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $exception) {
    die("Erreur de connexion : " . $exception->getMessage());
}
return $pdo;