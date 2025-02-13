<?php require_once '../src/views/shared/header.php'; ?>

<main>
    <h1>Connexion</h1>
    <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="/login">
        <label>Email :</label>
        <input type="email" name="email" required>
        <label>Mot de passe :</label>
        <input type="password" name="password" required>
        <button type="submit">Se connecter</button>
    </form>
    Pas de compte ? <a href="/register">S'inscrire</a>
</main>
