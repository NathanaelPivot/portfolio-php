<?php require_once '../src/views/shared/header.php'; ?>

<main>
    <h1>Inscription</h1>
    <?php if (isset($error)): ?>
        <p style="color:red;"><?php echo $error; ?></p>
    <?php endif; ?>
    <form method="POST" action="/register">
        <label>Nom d'utilisateur :</label>
        <input type="text" name="username" required>
        <label>Email :</label>
        <input type="email" name="email" required>
        <label>Mot de passe :</label>
        <input type="password" name="password" required>
        <button type="submit">S'inscrire</button>
    </form>
</main>
