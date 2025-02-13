<?php
// Fichier : src/views/skills/assign.php

require_once __DIR__ . '/../../../config/database.php';
require_once __DIR__ . '/../../../src/controllers/SkillController.php';
require_once __DIR__ . '/../../../src/controllers/UserSkillController.php';
require_once __DIR__ . '/../shared/header.php'; // Inclusion du header
$title = "Gérer les compétences";

// Démarrer la session si ce n'est pas déjà fait
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Vérifier que l'utilisateur est connecté
if (!isset($_SESSION['user']['id'])) {
    die('Vous devez être connecté pour accéder à cette page.');
}

// Récupération de l'ID utilisateur
$userId = $_SESSION['user']['id'];

// Initialisation des contrôleurs
$skillController = new SkillController($pdo);
$userSkillController = new UserSkillController($pdo);

// Récupérer la liste des compétences
$skills = $skillController->getSkills();

// Gestion de l'attribution des compétences
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $skillId = $_POST['skill_id'];
    $level = $_POST['level'];

    if ($skillId && $level) {
        $userSkillController->assignSkillToUser($userId, $skillId, $level);
        echo "<p>Compétence ajoutée avec succès !</p>";
    } else {
        echo "<p>Erreur : veuillez remplir tous les champs correctement.</p>";
    }
}

// Récupérer les compétences déjà assignées
$userSkills = $userSkillController->getUserSkills($userId);
?>

    <h1>Gérer les compétences</h1>

    <!-- Formulaire pour ajouter une compétence -->
    <h2>Ajouter une compétence</h2>
    <form method="POST">
        <label for="skill_id">Compétence :</label>
        <select name="skill_id" id="skill_id" required>
            <?php foreach ($skills as $skill): ?>
                <option value="<?= htmlspecialchars($skill['id']); ?>">
                    <?= htmlspecialchars($skill['name']); ?>
                </option>
            <?php endforeach; ?>
        </select>
        <br>
        <label for="level">Niveau :</label>
        <input type="number" name="level" id="level" min="1" max="3" required>
        <br>
        <button type="submit">Attribuer la compétence</button>
    </form>

    <!-- Liste des compétences déjà assignées -->
    <h2>Compétences assignées</h2>
<?php if (empty($userSkills)): ?>
    <p>Aucune compétence assignée pour le moment.</p>
<?php else: ?>
    <ul>
        <?php foreach ($userSkills as $userSkill): ?>
            <li>
                <?= htmlspecialchars($userSkill['name']); ?> - Niveau : <?= htmlspecialchars($userSkill['level']); ?>
            </li>
        <?php endforeach; ?>
    </ul>
<?php endif; ?>

<?php require_once __DIR__ . '/../shared/footer.php'; // Inclusion du footer ?>