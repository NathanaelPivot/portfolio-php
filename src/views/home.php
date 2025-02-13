<?php require_once 'shared/header.php'; ?>

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

            <?php if (isset($_SESSION['user']['role']) && $_SESSION['user']['role'] === 'admin'): ?>
                <!-- Lien visible uniquement par les administrateurs -->
                <li><a href="/skills/manage">Gérer les compétences</a></li>
            <?php endif; ?>
        </ul>

        <hr>

    <?php else: ?>
        <p>Pour accéder à vos fonctionnalités, veuillez <a href="/login">vous connecter</a>.</p>
    <?php endif; ?>
</main>