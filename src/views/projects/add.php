<?php
// Fichier : src/views/projects/add.php

require_once __DIR__ . '/../shared/header.php'; // Inclure le header
require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../src/controllers/ProjectController.php'; // Inclure le contrôleur des projets
global $pdo;

// Vérifie si l'utilisateur est connecté
if (!isset($_SESSION['user'])) {
    header('Location: /login');
    exit();
}

// Initialiser le contrôleur des projets
$projectController = new ProjectController($pdo);
$userId = $_SESSION['user']['id'];

// Récupérer les projets de l'utilisateur connecté
$projects = $projectController->getProjects($userId);
?>

    <h1>Ajouter un Projet</h1>
    <form method="POST" action="/projects/add">
        <label for="title">Titre du projet :</label><br>
        <input type="text" name="title" id="title" required><br><br>

        <label for="description">Description :</label><br>
        <textarea name="description" id="description" rows="4" required></textarea><br><br>

        <label for="image_path">Image (URL) :</label><br>
        <input type="text" name="image_path" id="image_path" required><br><br>

        <label for="link">Lien :</label><br>
        <input type="url" name="link" id="link" required><br><br>

        <button type="submit">Ajouter</button>
    </form>

    <hr>

    <h2>Mes Projets</h2>
<?php if (empty($projects)): ?>
    <p>Vous n'avez ajouté aucun projet pour le moment.</p>
<?php else: ?>
    <table>
        <thead>
        <tr>
            <th>Titre</th>
            <th>Description</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($projects as $project): ?>
            <tr>
                <td><?= htmlspecialchars($project['title']); ?></td>
                <td><?= htmlspecialchars($project['description']); ?></td>
                <td>
                    <!-- Formulaire pour supprimer le projet -->
                    <form method="POST" action="/projects/delete" style="display:inline;">
                        <input type="hidden" name="project_id" value="<?= $project['id']; ?>">
                        <button type="submit" onclick="return confirm('Voulez-vous vraiment supprimer ce projet ?');">
                            Supprimer
                        </button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
<?php endif; ?>

<?php
require_once __DIR__ . '/../shared/footer.php'; // Inclure le footer
?>