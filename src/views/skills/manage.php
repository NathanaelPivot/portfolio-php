
<?php
// Fichier : skills/manage.php

require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../src/controllers/SkillController.php';

$skillController = new SkillController($pdo);

// Traitement des actions administrateur
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    if ($action === 'add') {
        $name = $_POST['name'];
        $description = $_POST['description'];
        $skillController->addSkill($name, $description);
    } elseif ($action === 'delete') {
        $skillId = $_POST['skill_id'];
        $skillController->deleteSkill($skillId);
    }
}

// Récupérer toutes les compétences
$skills = $skillController->getSkills();
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Gérer les compétences</title>
</head>
<body>
<h1>Gestion des compétences</h1>

<!-- Ajouter une nouvelle compétence -->
<form method="POST">
    <input type="hidden" name="action" value="add">
    <label for="name">Nom de la compétence :</label>
    <input type="text" id="name" name="name" required>
    <label for="description">Description :</label>
    <input type="text" id="description" name="description">
    <button type="submit">Ajouter</button>
</form>

<h2>Liste des compétences</h2>
<ul>
    <?php foreach ($skills as $skill): ?>
        <li>
            <?= htmlspecialchars($skill['name']) ?> - <?= htmlspecialchars($skill['description']) ?>
            <form method="POST" style="display:inline;">
                <input type="hidden" name="action" value="delete">
                <input type="hidden" name="skill_id" value="<?= $skill['id'] ?>">
                <button type="submit">Supprimer</button>
            </form>
        </li>
    <?php endforeach; ?>
</ul>
</body>
</html>