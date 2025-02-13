<?php
require_once 'shared/header.php';
require_once __DIR__ . '/../../src/controllers/ProjectController.php'; // Inclure le contrôleur des projets
require_once __DIR__ . '/../../config/database.php'; // Inclure la configuration PDO

// Initialiser le contrôleur
$projectController = new ProjectController($pdo);

// Récupérer les projets de l'utilisateur connecté
if (isset($_SESSION['user']['id'])) {
    $userId = $_SESSION['user']['id'];
    $projects = $projectController->getProjects($userId); // Récupère les projets de l'utilisateur connecté
} else {
    $projects = []; // Aucun projet pour les utilisateurs non connectés
}
?>
<main>
    <h1>Bienvenue sur le Portfolio</h1>

    <?php if (isset($_SESSION['user'])): ?>
        <p>Bonjour, <?php echo htmlspecialchars($_SESSION['user']['username']); ?>.</p>
        <p><a href="/logout">Se déconnecter</a></p>

        <hr>

        <!-- Liens vers les fonctionnalités Skills -->
        <h2>Compétences</h2>
        <ul>
            <li><a href="/skills/assign">Ajouter mes compétences</a></li>

            <?php if ($_SESSION['user']['role'] === 'admin'): ?>
                <!-- Lien visible uniquement par les administrateurs -->
                <li><a href="/skills/manage">Gérer les compétences</a></li>
            <?php endif; ?>

            <li><a href="/projects/add">Ajouter un projet</a></li>
        </ul>

        <hr>

        <h2>Mes Projets</h2>
        <?php if (empty($projects)): ?>
            <p>Vous n'avez ajouté aucun projet pour le moment.</p>
        <?php else: ?>
            <ul>
                <?php foreach ($projects as $project): ?>
                    <li>
                        <h3><?= htmlspecialchars($project['title']); ?></h3>
                        <p><?= htmlspecialchars($project['description']); ?></p>
                        <?php if (!empty($project['image_path'])): ?>
                            <img src="<?= htmlspecialchars($project['image_path']); ?>" alt="Image du projet" width="200"><br>
                        <?php endif; ?>
                        <a href="<?= htmlspecialchars($project['link']); ?>" target="_blank">Voir le projet</a>
                    </li>
                <?php endforeach; ?>
            </ul>
        <?php endif; ?>

    <?php else: ?>
        <p>Pour accéder à vos fonctionnalités, veuillez <a href="/login">vous connecter</a>.</p>
    <?php endif; ?>

</main>