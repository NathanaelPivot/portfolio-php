<?php
session_start();

// Chargement des fichiers de configuration et d'autoload
require_once '../config/database.php';
require_once '../src/controllers/AuthController.php';
require_once '../src/controllers/SkillController.php';
require_once '../src/controllers/UserSkillController.php';

// Analyse de l'URL demandée
$requestUri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);

// Inclure le header commun
$title = "Accueil"; // Titre par défaut, modifié dans chaque vue si nécessaire
require_once '../src/views/shared/header.php';

// Gestion des routes
switch ($requestUri) {
    case '/':
        // Page d'accueil
        $title = "Accueil";
        require_once '../src/views/home.php';
        break;

    case '/login':
        $title = "Connexion";
        AuthController::loginPage();
        break;

    case '/register':
        $title = "Inscription";
        AuthController::registerPage();
        break;

    case '/logout':
        AuthController::logout();
        break;

    // Route : ajouter des compétences à l'utilisateur connecté
    case '/skills/assign':
        $title = "Gérer mes compétences";
        require_once '../src/views/skills/assign.php';
        break;

    // Route : gestion des compétences pour les administrateurs
    case '/skills/manage':
        if (!isset($_SESSION['user']) || $_SESSION['user']['role'] !== 'admin') {
            http_response_code(403);
            echo '403 - Accès interdit.';
            exit;
        }
        $title = "Gestion des compétences";
        require_once '../src/views/skills/manage.php';
        break;

    // Traitement POST : ajout rapide d'une compétence
    case '/skills/add':
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Ajouter une compétence à l'utilisateur connecté
            if (isset($_SESSION['user'])) {
                $userId = $_SESSION['user']['id'];
                $skillId = $_POST['skill_id'] ?? null;
                $level = $_POST['level'] ?? null;

                if ($skillId && $level) {
                    $userSkillController = new UserSkillController($pdo);
                    $userSkillController->assignSkillToUser($userId, $skillId, $level);
                    header('Location: /?success=1');
                    exit();
                }
            }
            // Si l'utilisateur n'est pas connecté ou s’il y a une erreur
            http_response_code(400);
            echo '400 - Requête invalide.';
            exit();
        }
        break;

    default:
        // Page introuvable
        $title = "Page non trouvée";
        http_response_code(404);
        echo '404 - Page non trouvée.';
        break;
}

// Inclure le footer commun à toutes les pages
require_once '../src/views/shared/footer.php';